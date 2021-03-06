<?php

namespace App\Http\Controllers;

use App\Events\Notif;
use App\Models\Cc;
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
use Mail;
use File;
use PDF;
use Symfony\Component\Debug\Exception\FatalThrowableError;


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
        $userDept = DB::table('users')
            ->select("users.id", "name", "nip", "job_positions.department_id")
            ->join("job_positions", "job_positions.id", "=", "users.job_position_id")
            ->where('job_positions.department_id', '=', Auth::user()->jobPosition->department_id)
            ->get();
        return view('document.memo', [
            "department" => $department,
            "docClass" => $docClass,
            "userDept" => $userDept,
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

        $deptSplit = explode(":", $request->dep_id);

        $depid = $request->dep_id;
        $tujuan = "";
        if (count($deptSplit) == 3) {
            $depid = $deptSplit[2];
            $tujuan = $deptSplit[1];
        }


        $seq = DocumentCodes::where('code', '=', 'MI')->first();
        $seq->seq = $seq->seq + 1;
        $number = "MI/" . ($seq->seq) . "/" . date("mY");
        $document = new Document();
        $document->title = $request->title;
        $document->number = $number;
        $document->content = $request->message;
        $document->status = 'draft';
        $document->type = 'memo';
        $document->memo_to_department_id = $depid;
        $document->created_by = $me->id;
        // create
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
            $label = $me->jobPosition->label;
            if (str_contains($me->jobPosition->label, "Kepala")) $label = "Kepala";
            $digSign->departement = $label;
            $digSign->encrypt()->save();

            // kakacab
            if ($document->memo_to_department_id == 1) {
                $act = new DocumentAction();
                $act->user_id = $document->memoDepartment->kepala()->user->id;
                $act->action_need = "Disposisi";
                $act->document_id = $document->id;
                $act->save();
            }
            if ($depid == 9999) {

                $users = User::all("id");
                foreach ($users as $user) {

                    if ($user->id == 1 || $user->id == 2) continue;

                    $act = new DocumentAction();
                    $act->user_id = $user->id;
                    $act->action_need = "Baca";
                    $act->document_id = $document->id;
                    $act->save();
                }

            } else {
                if ($tujuan == "") {
                    $tujuan = $document->memoDepartment->kepala()->user->id;
                }
                $act = new DocumentAction();
                $act->user_id = $tujuan;
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
                ->where("action_need", "=", "Tanda Tangan")
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
            $label = $me->jobPosition->label;
            if (str_contains($me->jobPosition->label, "Kepala")) $label = "Kepala";
            $digSign->departement = $label;
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
            'note' => 'required',

        ];
        $request->validate($validateRequest);

        $me = Auth::user();
//        $id = $request->document_id;

        DB::beginTransaction();

        try {

//            if ($me->jobPosition->id != 1) {
//                throw new Exception("Anda tidak memiliki akses");
//            }


            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->where("action_need", "=", "Disposisi")
                ->first();

            if (!$docAct) {
                throw new \Exception("Anda Tidak mendapatkan akses untuk melakukan itu.");
            }
            $docAct->is_done = true;
            $docAct->save();


            if ($me->jobPosition->id == 1) {

                foreach ($request->dep_ids as $dep_id) {

                    if ($dep_id == 8) {

                        foreach ([90, 91] as $uid) {
                            $act = new DocumentAction();
                            $act->user_id = $uid;
                            $act->action_need = "Baca";
                            $act->note = $request->note;
                            $act->action_from = $me->id;
                            $act->document_id = $id;
                            $act->save();

                            Notif::dispatch($act);
                        }

                    } else {
                        $act = new DocumentAction();

                        if ($dep_id == "") {
                            continue;
                        }

                        $dep = Department::find($dep_id);

                        $tujuan = "";

                        if ($dep->kepala()) {
                            $tujuan = $dep->kepala()->user->id;
                        } else if ($dep_id == 7) {
                            $tujuan = 85;
                        }


                        $act->user_id = $tujuan;

                        if ($dep_id == "7" || $dep_id == 8) {
                            $act->action_need = "Baca";
                        } else {
                            $act->action_need = "Disposisi";
                        }
                        $act->note = $request->note;
                        $act->action_from = $me->id;

                        $act->document_id = $id;
                        $act->save();


                        Notif::dispatch($act);
                    }


                }

            } else {
                foreach ($request->dep_ids as $dep_id) {
                    if ($dep_id == "") {
                        continue;
                    }
                    $deptSplit = explode(":", $dep_id);
                    $tujuan = "";
                    if (count($deptSplit) == 3) {
                        $dep_id = $deptSplit[2];
                        $tujuan = $deptSplit[1];
                    }
                    $act = new DocumentAction();
                    $act->user_id = $tujuan;
                    $act->action_need = "Baca";
                    $act->note = $request->note;
                    $act->action_from = $me->id;
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
                ->where("action_need", "=", "Baca")
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
            $number = "BA/" . ($seq->seq) . "/" . date("mY");
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
                $digSign->departement = $me->jobPosition->label;
                $digSign->label = "Yang Membuat,";
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
                $digSign->departement = $me->jobPosition->name;
                $digSign->label = "Yang Membuat,";
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
            $digSign->departement = $me->jobPosition->label;

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
                $digSign->label = "Menyetujui,";
            } elseif ($document->status == "sent") {
                $document->status = 'archived';
                $digSign->label = "Mengetahui,";
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

//            if ($me->jobPosition->id != 1) {
//                throw new Exception("Anda tidak memiliki akses");
//            }

            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->where("action_need", "=", "Disposisi")
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

                    // petugas wasrik
                    if ($dep_id == 8) {

                        foreach ([90, 91] as $uid) {
                            $act = new DocumentAction();
                            $act->user_id = $uid;
                            $act->action_need = "Baca";
                            $act->note = $request->note;
                            $act->action_from = $me->id;
                            $act->document_id = $id;
                            $act->save();

                            Notif::dispatch($act);
                        }

                    } else {

                        $dep = Department::find($dep_id);
                        $act = new DocumentAction();
                        $tujuan = "";

                        if ($dep->kepala()) {
                            $tujuan = $dep->kepala()->user->id;
                        } else if ($dep_id == 7) {
                            $tujuan = 85;
                        }

                        $act->user_id = $tujuan;


                        if ($dep_id == "7" || $dep_id == 8) {
                            $act->action_need = "Baca";
                        } else {
                            $act->action_need = "Disposisi";
                        }

                        $act->note = $request->note;
                        $act->action_from = $me->id;

                        $act->document_id = $id;
                        $act->save();


                        Notif::dispatch($act);
                    }
                }
            } else {
                foreach ($request->dep_ids as $dep_id) {
                    if ($dep_id == "") {
                        continue;
                    }
                    $deptSplit = explode(":", $dep_id);
                    $tujuan = "";
                    if (count($deptSplit) == 3) {
                        $dep_id = $deptSplit[2];
                        $tujuan = $deptSplit[1];
                    }
                    $act = new DocumentAction();
                    $act->user_id = $tujuan;
                    $act->action_need = "Baca";
                    $act->note = $request->note;
                    $act->action_from = $me->id;
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

    public function suratMasukPrint($id)
    {
        $document = Document::find($id);
        $docAct = DocumentAction::where("document_id", "=", $id)->get();
        $digSign = DigSign::where("document_id", "=", $id)->get();
        return view('document.suratMasukPrint', [
            "document" => $document,
            "docAct" => $docAct,
            "digSign" => $digSign,
        ]);
    }


    // Surat Keluar

    public function suratKeluar(Request $request)
    {
        //
        $department = Department::all();
        $docClass = DocumentClassification::all();
        $externalRecipient = ExternalRecipient::all();
        $documentTemplate = DocumentTemplate::all();
        $suratKeluarType = $request->query("suratKeluarType");
        return view('document.suratKeluar' . $suratKeluarType, [
            "department" => $department,
            "docClass" => $docClass,
            "externalRecipient" => $externalRecipient,
            "documentTemplate" => $documentTemplate,
            "suratKeluarType" => $suratKeluarType,
        ]);
    }

    public function suratKeluarStore(Request $request)
    {


        //

        $validateRequest = [
            'title' => 'required',
            'doc_class_code' => 'required',
            'surat_keluar_type' => 'required',
            'message' => 'required',
            'surat_keluar_name' => 'required',
            'surat_keluar_email' => 'required',
        ];

        $request->validate($validateRequest);

        $me = Auth::user();

        DB::beginTransaction();

        try {


            $seq = DocumentCodes::where('label', '=', $request->surat_keluar_type)->first();
            $seq->seq = $seq->seq + 1;
            $number = $seq->code . "/" . ($seq->seq) . "/" . date("mY");

            $document = new Document();
            $document->title = $request->title;
            $document->number = $number;
            $document->status = 'draft';
            $document->type = 'surat keluar';
            $document->surat_keluar_name = $request->surat_keluar_name;
            $document->surat_keluar_email = $request->surat_keluar_email;
            $document->surat_keluar_phone = "";
            $document->surat_keluar_address = "";


            $document->created_by = $me->id;
            $document->classification_code = $request->doc_class_code;


            $document->content = $request->message;


            $document->surat_keluar_type = $request->surat_keluar_type;
            $document->save();

            // save sequence baru
            $seq->save();

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

            // add cc
            $ccs = [];
            if (count($request->email_cc) > 1) {
                foreach ($request->email_cc as $ccdata) {
                    if ($ccdata == "") continue;
                    $ccs[] = $ccdata;
                    $ccModel = new Cc();
                    $ccModel->document_id = $document->id;
                    $ccModel->email = $ccdata;
                    $ccModel->save();
                }
            }


            // kirim ke kepala cabang
            if ($me->job_position_id != 1) {
                if ($me->jobPosition->jobParent == null) {

                    $jp = JobPosition::find(1);
                    $act = new DocumentAction();
                    $act->user_id = $jp->user->id;
                    $act->action_need = "Tanda Tangan";
                    $act->document_id = $document->id;
                    $act->save();

                    Notif::dispatch($act);
                } else {

                    $kepalaDivisi = $me->jobPosition->jobParent->user;
                    $act = new DocumentAction();
                    $act->user_id = $kepalaDivisi->id;
                    $act->action_need = "Menyetujui";
                    $act->document_id = $document->id;
                    $act->save();

                    Notif::dispatch($act);
                }

            } else {

                // update histories
                $docHistory = new DocumentHistories();
                $docHistory->user_id = $me->id;
                $docHistory->document_id = $document->id;
                $docHistory->action = "SIGNED";
                $docHistory->description = "dokumen di tandatangani oleh " . $me->name;
                $docHistory->save();

                $digSign = new DigSign();
                $digSign->sign_by_id = $me->id;
                $digSign->document_id = $document->id;
                $digSign->sign_uniqueness = Str::random(20);
                $digSign->signed_by_name = $me->name;
                $digSign->departement = "Kepala";
                $digSign->label = "";
                $digSign->encrypt()->save();

                // send email

                // export file
                $docAct = DocumentAction::where("document_id", "=", $document->id)->get();
                $digSigns = DigSign::where("document_id", "=", $document->id)->get();
                $datapdf = [
                    "document" => $document,
                    "docAct" => $docAct,
                    "digSign" => $digSigns,
                ];

                PDF::loadHTML(view('document.suratKeluarSendEmail', $datapdf)->render())->setPaper('a4')->save(storage_path($document->title . ".pdf"));

                $data = [
                    "email" => $request->surat_keluar_email,
                    "cc" => $ccs,
                    "perihal" => $document->title,
                    "nomor_surat" => $document->number,
                    "penerima" => $request->surat_keluar_name,
                ];

                Mail::send('emails.suratKeluar', $data, function ($m) use ($data) {
                    $m->from('eletcobpjstk@gmail.com', 'e-Letco');
                    $m->to($data['email'])->subject($data['perihal']);
                    if (count($data['cc']) > 0) {
                        $m->cc($data['cc']);
                    }
                    $m->attach(storage_path($data['perihal'] . ".pdf"));
                });

            }

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
            return redirect()->route('document.suratKeluar', ["suratKeluarType" => $request->surat_keluar_type])
                ->with('error', $e->getMessage());
        } catch (FatalThrowableError $e) {
            return redirect()->route('document.suratKeluar', ["suratKeluarType" => $request->surat_keluar_type])
                ->with('error', "Terdapat error pada isi pesan");
        }

    }

    public function suratKeluarMenyetujui($id)
    {


        $me = Auth::user();

        DB::beginTransaction();

        try {

            // update status
            $docAct = DocumentAction::where("document_id", "=", $id)
                ->where("user_id", "=", $me->id)
                ->where("action_need", "=", "Menyetujui")
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
            $docHistory->action = "SIGNED";
            $docHistory->description = "dokumen di tandatangani oleh " . $me->name;
            $docHistory->save();


            $document = Document::find($id);
            $document->editable = false;
            $document->status = 'sent';
            $document->save();

            if ($document->status == "sent" && $me->job_position_id != 1) {
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
            ->with('success', 'Document berhasil disetujui');
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
            $digSign->departement = "Kepala";

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
            $digSign->label = "";


            $document->save();
            $digSign->encrypt()->save();

            if ($document->status == "sent" && $me->job_position_id != 1) {
                // kirim ke kepala
                // create new docACT
                $job = JobPosition::find(1);
                $act = new DocumentAction();
                $act->user_id = $job->user->id;
                $act->action_need = "Tanda Tangan";
                $act->document_id = $document->id;
                $act->save();

                Notif::dispatch($act);
            } else {
                // send email

                $ccs = Cc::select("email")->where("document_id", "=", $document->id)->pluck('email')->toArray();

                // export file
                $docAct = DocumentAction::where("document_id", "=", $document->id)->get();
                $digSigns = DigSign::where("document_id", "=", $document->id)->get();

                PDF::loadHTML(view('document.suratKeluarEmail', [
                    "document" => $document,
                    "docAct" => $docAct,
                    "digSign" => $digSigns,
                ])->render())->setPaper('a4')->save(storage_path($document->title . ".pdf"));

                $data = [
                    "email" => $document->surat_keluar_email,
                    "cc" => $ccs,
                    "perihal" => $document->title,
                    "nomor_surat" => $document->number,
                    "penerima" => $document->surat_keluar_name,
                ];

                Mail::send('emails.suratKeluar', $data, function ($m) use ($data) {
                    $m->from('eletcobpjstk@gmail.com', 'e-Letco');
                    $m->to($data['email'])->subject($data['perihal']);
                    if (count($data['cc']) > 0) {
                        $m->cc($data['cc']);
                    }
                    $m->attach(storage_path($data['perihal'] . ".pdf"));
                });

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

        $userDept = DB::table('users')
            ->select("users.id", "name", "nip", "job_positions.department_id")
            ->join("job_positions", "job_positions.id", "=", "users.job_position_id")
            ->where('job_positions.department_id', '=', Auth::user()->jobPosition->department_id)
            ->get();

        return view('document.detail', [
            "document" => $document,
            "docAct" => $docAct,
            "department" => $department,
            "userDept" => $userDept,
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
