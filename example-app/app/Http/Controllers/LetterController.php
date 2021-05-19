<?php

namespace App\Http\Controllers;

use App\Models\Docno;
use App\Models\Letter;
use App\Models\OfficialMemo;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $letters = Letter::with("docno")
            ->with("from")
            ->with("to")
            ->with("draftTo")
            ->with("from.attr")
            ->with("to.attr")
            ->with("draftTo.attr")

            ->latest()->simplePaginate(5);
        return view('letter.index', compact('letters'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function sent()
    {
        //
        $letters = Letter::with("docno")
            ->with("from")
            ->with("to")
            ->with("draftTo")
            ->with("from.attr")
            ->with("to.attr")
            ->with("draftTo.attr")
            ->where("from_id", "=", Auth::user()->id)
            ->where("status", "=", "sent")
            ->latest()->simplePaginate(5);
        return view('letter.index', compact('letters'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function draft()
    {
        //
        $letters = Letter::with("docno")
            ->with("from")
            ->with("to")
            ->with("draftTo")
            ->with("from.attr")
            ->with("to.attr")
            ->with("draftTo.attr")
            ->where("from_id", "=", Auth::user()->id)
            ->where("status", "=", "draft")
            ->latest()->simplePaginate(5);
        return view('letter.index', compact('letters'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function inbox()
    {
        //
        $letters = Letter::with("docno")
            ->with("from")
            ->with("to")
            ->with("draftTo")
            ->with("from.attr")
            ->with("to.attr")
            ->with("draftTo.attr")
            ->where("to_id", "=", Auth::user()->id)
            ->latest()->simplePaginate(5);
        return view('letter.index', compact('letters'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dn = Docno::all(["id", "docno", "subject"]);
        $users = User::with("attr")->where("id", "<>", Auth::user()->id)->get();
        return view('letter.create', [
            "docnos" => $dn,
            "users" => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'docno_id' => 'required',
            'to_id' => 'required',
            'draft_to_id' => 'required',
            'message' => 'required',
        ]);

        // upload image
        $path = "";
        $file = $request->file('file');
        if ($file) {
            $path = $file->store('attachment');
        }



        //fungsi eloquent untuk menambah data

        $dn = new Letter();
        $dn->docno_id = $request->docno_id;
        $dn->from_id = Auth::user()->id;
        $dn->to_id = $request->to_id;
        $dn->draft_to_id = $request->draft_to_id;
        $dn->message = $request->message;
        $dn->status = "draft";
        if ($path) {
            $dn->file_path = $path;
        }

        $dn->save();

        $om = new OfficialMemo();
        $om->letter_id = $dn->id;
        $om->number = "ND/02.03/".date("dd/mm/YYYY");
        $om->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('letter.index')
            ->with('success', 'Document Number Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
