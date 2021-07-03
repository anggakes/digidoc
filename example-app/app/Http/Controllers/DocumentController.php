<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DigSign;
use App\Models\Document;
use App\Models\DocumentAction;
use App\Models\DocumentClassification;
use App\Models\DocumentCodes;
use App\Models\DocumentHistories;
use App\Models\Memo;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Storage;
use Str;

class DocumentController extends Controller
{

    public function compose()
    {
        //

        return view('document.compose');
    }

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
            $document->save();
        }

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

        return view('document.memoPrint', [
            "document" => $document,
            "docAct" => $docAct,
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
            $digSign->id = $id;
            $digSign->document_id = $id;
            $digSign->sign_uniqueness = Str::random(20);
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
            $document->save();

            // create new docACT
            $act = new DocumentAction();
            $act->user_id = $document->memoDepartment->kepala()->user->id;
            $act->action_need = "Baca";
            $act->document_id = $document->id;
            $act->save();


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
            return redirect()->route('document.show', $id)
                ->with('error', $e->getMessage());
        }


        return redirect()->route('document.show', $id);

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


        return view('document.detail', [
            "document" => $document,
            "docAct" => $docAct,
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
