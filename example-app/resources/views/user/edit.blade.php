@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit User
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
                <form method="post" action="{{ route('user.update', $user->id) }}" id="myForm">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="name" value="{{ $user->name  }}">
                    </div>
                    <div class="form-group">
                        <label for="name">NIP</label>
                        <input type="text" name="nip" class="form-control" id="nip" aria-describedby="nip" value="{{ $user->nip  }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="email" value="{{ $user->email  }}">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="name">Job Position</label>
                            <x-adminlte-select2 name="job_position_id" class="form-control"
                                                data-placeholder="Select job position...">
                                <option value="">Select job position...</option>
                                @if($jobPosition)
                                @foreach ($jobPosition as $jp)
                                <option {{ $user->job_position_id == $jp->id ? 'selected="selected"' : '' }} value="{{ $jp->id }}">{{ $jp->label }} </option>
                                @endforeach
                                @endif
                            </x-adminlte-select2>
                        </div>

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
