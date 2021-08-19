<?php

namespace App\Http\Controllers;

use App\Events\Notif;
use App\Models\Department;
use App\Models\DigSign;
use App\Models\Document;
use App\Models\DocumentAction;
use App\Models\DocumentClassification;
use App\Models\DocumentCodes;
use App\Models\DocumentFile;
use App\Models\DocumentHistories;
use App\Models\DocumentTemplate;
use App\Models\ExternalRecipient;
use App\Models\JobPosition;
use App\Models\Memo;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Mockery\Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use Storage;
use Str;
use URL;

class DocumentController extends Controller
{

    public function compose()
    {
        //

        return view('document.compose');
    }

    // MEMO

    public function memo()
    {
        //
        $department = Department::all();
        $docClass = DocumentClassification::all();
        return view('document.memo', [
            "department" => $department,
            "docClass" => $docClass,
        ]);
    }

    public function memoStore(Request $request)
    {
        //
        //melakukan validasi data
        $validateRequest = [
            'title' => 'required',
            'dep_id' => 'required',
            'message' => 'required',
            'doc_class_code' => 'required',
        ];

        $request->validate($validateRequest);

        $me = Auth::user();

        $seq = DocumentCodes::where('code', '=', 'MI')->first();
        $seq->seq = $seq->seq + 1;
        $number = "MI/" . ($seq->seq) . "/" . date("dmy");
        $document = new Document();
        $document->title = $request->title;
        $document->number = $number;
        $document->content = $request->message;
        $document->status = 'draft';
        $document->type = 'memo';
        $document->memo_to_department_id = $request->dep_id;
        $document->created_by = $me->id;
        $document->classification_code = $request->doc_class_code;
        $document->save();

        // save sequence baru
        $seq->save();


        /// notify kepala divisi
        /// get kepala divisi user id dari departemen saat ini

        if (isset($me->jobPosition->jobParent)) {

            $kepalaDivisi = $me->jobPosition->jobParent->user;
            $act = new DocumentAction();
            $act->user_id = $kepalaDivisi->id;
            $act->action_need = "Tanda Tangan";
            $act->document_id = $document->id;
            $act->save();

        } else {
            // kepala yang create memo
            // tidak perlu approval
            $document->editable = false;
            $document->status = 'sent';
            $document->save();

            // langsung di tandatangani
            $digSign = new DigSign();
            $digSign->sign_by_id = $me->id;
            $digSign->document_id = $document->id;
            $digSign->sign_uniqueness = Str::random(20);
            $digSign->signed_by_name = $me->name;
            $digSign->departement = $me->jobPosition->department->name;
            $digSign->encrypt()->save();

            // kakacab
            if ($document->memo_to_department_id == 1) {
                $act = new DocumentAction();
                $act->user_id = $document->memoDepartment->kepala()->user->id;
                $act->action_need = "Disposisi";
                $act->document_id = $document->id;
                $act->save();
            } else {
                $act = new DocumentAction();
                $act->user_id = $document->memoDepartment->kepala()->user->id;
                $act->action_need = "Baca";
                $act->document_id = $document->id;
                $act->save();
            }

        }

        Notif::dispatch($act);

        $docHistory = new DocumentHistories();
        $docHistory->user_id = $me->id;
        $docHistory->document_id = $document->id;
        $docHistory->action = "CREATE";
        $docHistory->description = "dokumen di buat oleh " . $me->name;
        $docHistory->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('document.show', $document->id)
            ->with('success', 'Document Memo Created');
    }

    public function memoPrint($id)
    {
        $document = Document::find($id);
        $docAct = DocumentAction::where("document_id", "=", $id)->get();
        $digSign = DigSign::where("document_id", "=", $id)->get();
        return view('document.memoPrint', [
            "document" => $document,
            "docAct" => $docAct,
            "digSign" => $digSign,
        ]);
    }

    public function memoSign($id)
    {
        $me = Auth::user();

        DB::beginTransaction();

        try {

            // update status
            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();

            // tanda tangani
            $digSign = new DigSign();
            $digSign->sign_by_id = $me->id;
            $digSign->document_id = $id;
            $digSign->sign_uniqueness = Str::random(20);
            $digSign->signed_by_name = $me->name;
            $digSign->departement = $me->jobPosition->department->name;
            $digSign->encrypt()->save();

            // update histories
            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "SIGNED";
            $docHistory->description = "dokumen di tandatangani oleh " . $me->name;
            $docHistory->save();


            $document = Document::find($id);
            $document->editable = false;
            $document->status = 'sent';
            $document->save();

            // create new docACT
            // kakacab
            if ($document->memo_to_department_id == 1) {
                $act = new DocumentAction();
                $act->user_id = $document->memoDepartment->kepala()->user->id;
                $act->action_need = "Disposisi";
                $act->document_id = $document->id;
                $act->save();
            } else {
                $act = new DocumentAction();
                $act->user_id = $document->memoDepartment->kepala()->user->id;
                $act->action_need = "Baca";
                $act->document_id = $document->id;
                $act->save();
            }

            Notif::dispatch($act);


            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.show', $id)
                ->with('error', $e->getMessage());
        }


        return redirect()->route('document.show', $id)
            ->with('success', 'Document berhasil di tanda tangani');

    }

    public function memoDisposisi($id, Request $request)
    {
        //melakukan validasi data
        $validateRequest = [
            'dep_ids' => 'required',
        ];

        $me = Auth::user();
//        $id = $request->document_id;

        DB::beginTransaction();

        try {

//            if ($me->jobPosition->id != 1) {
//                throw new Exception("Anda tidak memiliki akses");
//            }


            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();



            if ($me->jobPosition->id == 1) {
                foreach ($request->dep_ids as $dep_id) {
                    if ($dep_id == "") {
                        continue;
                    }
                    $dep = Department::find($dep_id);
                    $act = new DocumentAction();
                    $act->user_id = $dep->kepala()->user->id;
                    if ($dep_id == "7" || $dep_id == 8){
                        $act->action_need = "Baca";
                    }else{
                        $act->action_need = "Disposisi";
                    }
                    $act->note = $request->note;

                    $act->document_id = $id;
                    $act->save();

                    Notif::dispatch($act);
                }
            }

            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "DISPOSITION";
            $docHistory->description = "dokumen di didisposisi oleh " . $me->name;
            $docHistory->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.show', $id)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('document.show', $id)
            ->with('success', 'Document berhasil di disposisi');
    }

    public function memoViewed($id)
    {
        $me = Auth::user();

        DB::beginTransaction();

        try {

            // update status
            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();

            // update histories
            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "VIEWED";
            $docHistory->description = "dokumen sudah dibaca oleh " . $me->name;
            $docHistory->save();

            DB::commit();
            // all good

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            throw $e;
        }


        return redirect()->route('document.show', $id);

    }


    // BERITA ACARA

    public function beritaAcara()
    {
        //
        $department = Department::all();
        $docClass = DocumentClassification::all();

        return view('document.beritaAcara', [
            "department" => $department,
            "docClass" => $docClass,
        ]);
    }

    public function beritaAcaraStore(Request $request)
    {

        $validateRequest = [
            'title' => 'required',
            'message' => 'required',
            'doc_class_code' => 'required',
        ];

        $request->validate($validateRequest);

        $me = Auth::user();

        DB::beginTransaction();

        try {

            $seq = DocumentCodes::where('code', '=', 'BA')->first();
            $seq->seq = $seq->seq + 1;
            $number = "BA/" . ($seq->seq) . "/" . date("dmy");
            $document = new Document();
            $document->title = $request->title;
            $document->number = $number;
            $document->content = $request->message;
            $document->status = 'draft';
            $document->type = 'berita acara';
            $document->created_by = $me->id;
            $document->classification_code = $request->doc_class_code;
            $document->berita_acara_department_id = $me->jobPosition->department->id;

            $document->save();

            // save sequence baru
            $seq->save();


            /// notify kepala divisi
            /// get kepala divisi user id dari departemen saat ini

            if (isset($me->jobPosition->jobParent)) {

                $kepalaDivisi = $me->jobPosition->jobParent->user;
                $act = new DocumentAction();
                $act->user_id = $kepalaDivisi->id;
                $act->action_need = "Tanda Tangan";
                $act->document_id = $document->id;
                $act->save();

                $digSign = new DigSign();
                $digSign->sign_by_id = $me->id;
                $digSign->document_id = $document->id;
                $digSign->sign_uniqueness = Str::random(20);
                $digSign->signed_by_name = $me->name;
                $digSign->departement = $me->jobPosition->department->name;
                $digSign->label = "Yang Membuat";
                $digSign->encrypt()->save();

            } else {
                // kepala yang create memo
                // tidak perlu approval
                $document->editable = false;
                $document->status = 'sent';
                $document->save();

                // langsung di tandatangani
                $digSign = new DigSign();
                $digSign->sign_by_id = $me->id;
                $digSign->document_id = $document->id;
                $digSign->sign_uniqueness = Str::random(20);
                $digSign->signed_by_name = $me->name;
                $digSign->departement = $me->jobPosition->department->name;
                $digSign->label = "Yang Membuat";
                $digSign->encrypt()->save();
            }

            Notif::dispatch($act);

            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $document->id;
            $docHistory->action = "CREATE";
            $docHistory->description = "dokumen di buat oleh " . $me->name;
            $docHistory->save();


            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            throw $e;
        }


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('document.show', $document->id)
            ->with('success', 'Berita Acara berhasil dibuat');
    }


    public function beritaAcaraSign($id)
    {
        $me = Auth::user();

        DB::beginTransaction();

        try {

            // update status
            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();

            // tanda tangani
            $digSign = new DigSign();
            $digSign->sign_by_id = $me->id;
            $digSign->document_id = $id;
            $digSign->sign_uniqueness = Str::random(20);
            $digSign->signed_by_name = $me->name;
            $digSign->departement = $me->jobPosition->department->name;

            // update histories
            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "SIGNED";
            $docHistory->description = "dokumen di tandatangani oleh " . $me->name;
            $docHistory->save();


            $document = Document::find($id);
            $document->editable = false;
            if ($document->status == "draft") {
                $document->status = 'sent';
                $digSign->label = "Menyetujui";
            } elseif ($document->status == "sent") {
                $document->status = 'archived';
                $digSign->label = "Mengetahui";
            }

            $document->save();
            $digSign->encrypt()->save();

            if ($document->status == "sent") {
                // kirim ke kepala
                // create new docACT
                $job = JobPosition::find(1);
                $act = new DocumentAction();
                $act->user_id = $job->user->id;
                $act->action_need = "Tanda Tangan";
                $act->document_id = $document->id;
                $act->save();

                Notif::dispatch($act);
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.show', $id)
                ->with('error', $e->getMessage());
        }


        return redirect()->route('document.show', $id)
            ->with('success', 'Document berhasil di tanda tangani');
    }

    public function beritaAcaraPrint($id)
    {
        $document = Document::find($id);
        $docAct = DocumentAction::where("document_id", "=", $id)->get();
        $digSign = DigSign::where("document_id", "=", $id)->get();
        return view('document.beritaAcaraPrint', [
            "document" => $document,
            "docAct" => $docAct,
            "digSign" => $digSign,
        ]);
    }


    // Surat Masuk
    public function suratMasuk()
    {
        //
        $department = Department::all();
        $docClass = DocumentClassification::all();
        return view('document.suratMasuk', [
            "department" => $department,
            "docClass" => $docClass,
        ]);
    }

    public function suratMasukStore(Request $request)
    {
        //

        $validateRequest = [
            'title' => 'required',
            'surat_masuk_date' => 'required',
            'surat_masuk_from' => 'required',
            'number' => 'required',
            'doc_class_code' => 'required',
        ];

        $request->validate($validateRequest);

        $me = Auth::user();

        DB::beginTransaction();

        try {


            $number = $request->number;

            $document = new Document();
            $document->title = $request->title;
            $document->number = $number;
            $document->content = "";
            $document->status = 'draft';
            $document->type = 'surat masuk';
            $document->surat_masuk_date = $request->surat_masuk_date;
            $document->surat_masuk_from = $request->surat_masuk_from;
            $document->created_by = $me->id;
            $document->classification_code = $request->doc_class_code;
            $document->save();

            // upload file.
            if ($request->has("filenames")) {
                foreach ($request->file('filenames') as $file) {
                    $name = $file->getFilename() . '.' . $file->extension();
                    $file->move(public_path() . '/', $name);
                    $df = new DocumentFile();
                    $df->path = $name;
                    $df->document_id = $document->id;
                    $df->save();
                }
            }

            // kirim ke kepala cabang
            $jp = JobPosition::find(1);
            $act = new DocumentAction();
            $act->user_id = $jp->user->id;
            $act->action_need = "Disposisi";
            $act->document_id = $document->id;
            $act->save();

            Notif::dispatch($act);

            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $document->id;
            $docHistory->action = "CREATE";
            $docHistory->description = "dokumen di buat oleh " . $me->name;
            $docHistory->save();

            DB::commit();
            // all good

            return redirect()->route('document.show', $document->id)
                ->with('success', "Surat masuk berhasil di buat");

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.suratMasuk')
                ->with('error', $e->getMessage());
        }

    }


    public function suratMasukViewed($id)
    {
        $me = Auth::user();

        DB::beginTransaction();

        try {

            // update status
            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();

            // update histories
            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "VIEWED";
            $docHistory->description = "dokumen sudah dibaca oleh " . $me->name;
            $docHistory->save();

            DB::commit();
            // all good

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            throw $e;
        }


        return redirect()->route('document.show', $id);

    }


    public function suratMasukDisposisi($id, Request $request)
    {
        //melakukan validasi data
        $validateRequest = [
            'dep_ids' => 'required',
        ];

        $me = Auth::user();
//        $id = $request->document_id;

        DB::beginTransaction();

        try {

            if ($me->jobPosition->id != 1) {
                throw new Exception("Anda tidak memiliki akses");
            }

            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();

            foreach ($request->dep_ids as $dep_id) {
                $dep = Department::find($dep_id);
                $act = new DocumentAction();
                $act->user_id = $dep->kepala()->user->id;
                $act->action_need = "Baca";
                $act->document_id = $id;
                $act->save();

                Notif::dispatch($act);
            }

            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "DISPOSITION";
            $docHistory->description = "dokumen di didisposisi oleh " . $me->name;
            $docHistory->save();


            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.show', $id)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('document.show', $id)
            ->with('success', 'Document berhasil di disposisi');
    }


    // Surat Keluar

    public function suratKeluar()
    {
        //
        $department = Department::all();
        $docClass = DocumentClassification::all();
        $externalRecipient = ExternalRecipient::all();
        $documentTemplate = DocumentTemplate::all();

        return view('document.suratKeluar', [
            "department" => $department,
            "docClass" => $docClass,
            "externalRecipient" => $externalRecipient,
            "documentTemplate" => $documentTemplate,
        ]);
    }

    public function suratKeluarStore(Request $request)
    {
        //

        $validateRequest = [
            'title' => 'required',
            'number' => 'required',
            'doc_class_code' => 'required',
            'surat_keluar_to' => 'required',
            'surat_keluar_type' => 'required',
            'message' => 'required',
        ];

        $request->validate($validateRequest);

        $me = Auth::user();

        DB::beginTransaction();

        try {


            $number = $request->number;

            $document = new Document();
            $document->title = $request->title;
            $document->number = $number;
            $document->content = "";
            $document->status = 'draft';
            $document->type = 'surat keluar';
            $document->surat_keluar_to = $request->surat_keluar_to;
            $document->created_by = $me->id;
            $document->classification_code = $request->doc_class_code;
            $document->content = $request->message;
            $document->surat_keluar_type = $request->surat_keluar_type;
            $document->save();

            // upload file.
            if ($request->has("filenames")) {
                foreach ($request->file('filenames') as $file) {
                    $name = $file->getFilename() . '.' . $file->extension();
                    $file->move(public_path() . '/', $name);
                    $df = new DocumentFile();
                    $df->path = $name;
                    $df->document_id = $document->id;
                    $df->save();
                }
            }

            // kirim ke kepala cabang
            $kepalaDivisi = $me->jobPosition->jobParent->user;
            $act = new DocumentAction();
            $act->user_id = $kepalaDivisi->id;
            $act->action_need = "Tanda Tangan";
            $act->document_id = $document->id;
            $act->save();

            Notif::dispatch($act);

            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $document->id;
            $docHistory->action = "CREATE";
            $docHistory->description = "dokumen di buat oleh " . $me->name;
            $docHistory->save();

            DB::commit();
            // all good

            return redirect()->route('document.show', $document->id)
                ->with('success', "Surat keluar berhasil di buat");

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.suratKeluar')
                ->with('error', $e->getMessage());
        }

    }


    public function suratKeluarSign($id)
    {
        $me = Auth::user();

        DB::beginTransaction();

        try {

            // update status
            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();

            // tanda tangani
            $digSign = new DigSign();
            $digSign->sign_by_id = $me->id;
            $digSign->document_id = $id;
            $digSign->sign_uniqueness = Str::random(20);
            $digSign->signed_by_name = $me->name;
            $digSign->departement = $me->jobPosition->department->name;

            // update histories
            $docHistory = new DocumentHistories();
            $docHistory->user_id = $me->id;
            $docHistory->document_id = $id;
            $docHistory->action = "SIGNED";
            $docHistory->description = "dokumen di tandatangani oleh " . $me->name;
            $docHistory->save();


            $document = Document::find($id);
            $document->editable = false;
            $document->status = 'sent';
            $digSign->label = "Menyetujui";


            $document->save();
            $digSign->encrypt()->save();

            if ($document->status == "sent") {
                // kirim ke kepala
                // create new docACT
                $job = JobPosition::find(1);
                $act = new DocumentAction();
                $act->user_id = $job->user->id;
                $act->action_need = "Tanda Tangan";
                $act->document_id = $document->id;
                $act->save();

                Notif::dispatch($act);
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect()->route('document.show', $id)
                ->with('error', $e->getMessage());
        }


        return redirect()->route('document.show', $id)
            ->with('success', 'Document berhasil di tanda tangani');
    }

    public function suratKeluarPrint($id)
    {
        $document = Document::find($id);
        $docAct = DocumentAction::where("document_id", "=", $id)->get();
        $digSign = DigSign::where("document_id", "=", $id)->get();
        return view('document.suratKeluarPrint', [
            "document" => $document,
            "docAct" => $docAct,
            "digSign" => $digSign,
        ]);
    }

    public function inbox()
    {
        $docAct = DocumentAction::with('document')->where("user_id", "=", Auth::user()->id)
            ->latest()->simplePaginate(5);

        return view(
            'document.inbox',
            [
                "docact" => $docAct
            ]
        )->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function sent()
    {
        $docAct = Document::
        where("created_by", "=", Auth::user()->id)
            ->latest()->simplePaginate(5);

        return view(
            'document.sent',
            [
                "document" => $docAct
            ]
        )->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $document = Document::find($id);
        $docAct = DocumentAction::where("document_id", "=", $id)->get();
        $department = Department::all();

        $mydeptID=Auth::user()->jobPosition->department->id;
//        $departmentUser=User::where()

        return view('document.detail', [
            "document" => $document,
            "docAct" => $docAct,
            "department" => $department,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
