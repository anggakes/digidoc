<?php

namespace App\Http\Controllers;



use App\Models\Docno;
use Illuminate\Http\Request;

class DocNoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        //
        $docnos = Docno::latest()->simplePaginate(5);
        return view('docno.index', compact('docnos'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
        return view('docno.create');
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

        //melakukan validasi data
        $request->validate([
            'doc_date' => 'required',
            'subject' => 'required',
            'classification' => 'required',
            'doc_type' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = new Docno();
        $dn->doc_date = $request->doc_date;
        $dn->subject = $request->subject;
        $dn->classification = $request->classification;
        $dn->doc_type = $request->doc_type;
        $dn->docno = $request->classification."/".$request->doc_type."/".str_replace("-", "/", $request->doc_date);
        $dn->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('docno.edit', ['docno' => $dn->id])
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
        $docno = Docno::find($id);
        return view('docno.edit', compact('docno'));
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
        //melakukan validasi data
        $request->validate([
            'doc_date' => 'required',
            'subject' => 'required',
            'classification' => 'required',
            'doc_type' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = Docno::find($id);
        $dn->doc_date = $request->doc_date;
        $dn->subject = $request->subject;
        $dn->classification = $request->classification;
        $dn->doc_type = $request->doc_type;
        $dn->docno = $request->classification."/".$request->doc_type."/".str_replace("-", "/", $request->doc_date);
        $dn->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('docno.edit', ['docno' => $dn->id])
            ->with('success', 'Document Number Edited');
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
