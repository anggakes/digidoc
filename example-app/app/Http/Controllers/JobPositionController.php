<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jobPosition = JobPosition::with('jobParent')->latest()->simplePaginate(5);
        return view('job_position.index', [
            'jobPosition' => $jobPosition,
        ])
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
        $jobPosition = JobPosition::whereNull('parent_id')->get();
        $department = Department::where('id', "<>", 1)->get();
        return view('job_position.create', [
            'jobPosition' => $jobPosition,
            'department' => $department,
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
            'label' => 'required',
            'department' => 'required',
        ]);

        //fungsi eloquent untuk menambah data

        $dn = new JobPosition();
        $dn->label = $request->label;
        $dn->department = $request->department;
        if($request->parent_id) {
            $dn->parent_id = $request->parent_id;
        }
        $dn->save();


        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('job_position.index')
            ->with('success', 'Job Position Created');
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
        $id =  JobPosition::destroy($id);
        return redirect()->route('job_position.index')
            ->with('success', 'Job Position deleted');
    }
}

