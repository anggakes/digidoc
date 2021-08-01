<?php

namespace App\Http\Controllers;

use App\Models\ExternalRecipient;
use Illuminate\Http\Request;

class ExternalRecipientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ExternalRecipient::latest()->simplePaginate(5);
        return view('external_recipient.index', [
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
        return view('external_recipient.create');
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
        ]);

        //fungsi eloquent untuk menambah data

        $dn = new ExternalRecipient();
        $dn->name = $request->name;
        $dn->email = $request->email;
        $dn->phone =  $request->phone;
        $dn->address =  $request->address;
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('external_recipient.index')
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
        $data = ExternalRecipient::find($id);
        return view('external_recipient.edit', [
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
        ]);

        //fungsi eloquent untuk menambah data

        $dn = ExternalRecipient::find($id);
        $dn->name = $request->name;
        $dn->email = $request->email;
        $dn->phone =  $request->phone;
        $dn->address =  $request->address;
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('external_recipient.index')
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
