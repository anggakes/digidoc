<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with("attr")->latest()->simplePaginate(5);
        return view('user.index', compact('users'))
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
        return view('user.create');
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
            'email' => 'required',
            'password' => 'required',
            'position' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = new User();
        $dn->name = $request->name;
        $dn->email = $request->email;
        $dn->password =  Hash::make($request->password);
        $dn->save();

        $attr = new UserAttribute();
        $attr->user_id = $dn->id;
        $attr->position = $request->position;
        $attr->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('user.index')
            ->with('success', 'User Created');
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
        $id =  User::destroy($id);
        return redirect()->route('user.index')
            ->with('success', 'User deleted');
    }
}
