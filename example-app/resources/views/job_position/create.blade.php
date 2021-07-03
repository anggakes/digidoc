@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Create Job Position
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="post" action="{{ route('job_position.store') }}" id="myForm">
                    @csrf
                    <div class="form-group">
                        <div class="form-group">
                            <label for="name">Department</label>
                            <x-adminlte-select2 name="parent_id" class="form-control"
                                                data-placeholder="Pilih Departemen...">
<!--                                <option value="">Select job supervisor...</option>-->
                                @if($department)
                                @foreach ($department as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach
                                @endif
                            </x-adminlte-select2>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="name">Job Supervisor</label>
                            <x-adminlte-select2 name="parent_id" class="form-control"
                                                data-placeholder="Select job supervisor...">
                                <option value="">Select job supervisor...</option>
                                @if($jobPosition)
                                @foreach ($jobPosition as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->label }}</option>
                                @endforeach
                                @endif
                            </x-adminlte-select2>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="label">Nama Jabatan</label>
                        <input type="text" name="label" class="form-control" id="label" aria-describedby="label" >
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('user.index') }}" class="btn btn-link" >Back</a>
                </form>

            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .select2 {
        border: 1px solid #c0c0c0;
    }
</style>
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
