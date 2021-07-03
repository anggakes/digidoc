@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>Job Position Management</h2>
        </div>
        <div class="float-right my-2">
            <a class="btn btn-success" href="{{ route('job_position.create') }}"> Create New</a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Label</th>
        <th>Department</th>
        <th>Kepala</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($jobPosition as $jp)

    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $jp->label }}</td>
        <td>{{ $jp->department->name }}</td>
        <td>{{ $jp->parent ? $jp->parent->label : ""}}</td>
        <td>
            <form action="{{ route('job_position.destroy',$jp->id) }}" method="POST">


                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<div class="text-center">
    {!! $jobPosition->links() !!}
</div>


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    svg{
        height:12px;s
    }
</style>
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
