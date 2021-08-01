<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use Illuminate\Http\Request;

class DocumentTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data = DocumentTemplate::latest()->simplePaginate(5);
        return view('document_template.index', [
            'data' => $data,
        ])->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //
        return view('document_template.create');
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
            'name' => 'required',
            'stub' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = new DocumentTemplate();
        $dn->name = $request->name;
        $dn->stub = $request->stub;
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('document_template.index')
            ->with('success', 'Berhasil ditambahkan');
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
        $data = DocumentTemplate::find($id);
        return view('document_template.edit', [
            "data" => $data
        ]);
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
            'name' => 'required',
            'stub' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = DocumentTemplate::find($id);
        $dn->name = $request->name;
        $dn->stub = $request->stub;
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('document_template.index')
            ->with('success', 'Berhasil diubah');
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
