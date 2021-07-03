<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
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
        $users = User::with('jobPosition')->latest()->simplePaginate(5);
        return view('user.index', [
            'users' => $users,
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
        $jobPosition = JobPosition::all();
        return view('user.create', [
            'jobPosition' => $jobPosition,
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

        //melakukan validasi data
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'job_position_id' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = new User();
        $dn->name = $request->name;
        $dn->email = $request->email;
        $dn->password =  Hash::make($request->password);
        $dn->job_position_id =  $request->job_position_id;
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('user.index')
            ->with('success', 'User Created');
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
        $user = User::find($id);
        $jobPosition = JobPosition::all();
        return view('user.edit', [
            'user' => $user,
            'jobPosition' => $jobPosition,
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'job_position_id' => 'required',
        ]);
        //
        $dn = User::find($id);
        $dn->name = $request->name;
        $dn->email = $request->email;
        $dn->job_position_id =  $request->job_position_id;
        $dn->nip =  $request->nip;
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('user.index')
            ->with('success', 'User Updated');
    }
}
