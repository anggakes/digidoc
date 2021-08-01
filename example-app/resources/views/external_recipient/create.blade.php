@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Buat Organisasi Eksternal
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
                <form method="post" action="{{ route('external_recipient.store') }}" id="myForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="name" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="email" >
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor HP</label>
                        <input type="phone" name="phone" class="form-control" id="phone" aria-describedby="phone" >
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="address" name="address" class="form-control" id="address" aria-describedby="address" >
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
