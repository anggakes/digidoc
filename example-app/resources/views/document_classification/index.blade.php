@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>Klasifikasi Arsip</h2>
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
        <th>Kode Klasifikasi</th>
        <th>Jenis Arsip</th>
        <th>Keterangan</th>
    </tr>
    @foreach ($data as $d)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $d->code }}</td>
        <td>{{ $d->archive_type }}</td>
        <td>{{ $d->description }}</td>

    </tr>
    @endforeach
</table>

<div class="text-center">
    {!! $data->links() !!}
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
