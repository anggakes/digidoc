@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>Organisasi Eksternal</h2>
        </div>
        <div class="float-right my-2">
            <a class="btn btn-success" href="{{ route('external_recipient.create') }}"> Buat Baru</a>
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
        <th>Name</th>
        <th>Email</th>
        <th>Nomor HP</th>
        <th>Alamat</th>
        <th width="280px">Aksi</th>
    </tr>
    @foreach ($data as $d)

    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $d->name }}</td>
        <td>{{ $d->email }}</td>
        <td>{{ $d->phone }}</td>
        <td>{{ $d->address }}</td>

        <td>
            <a class="btn btn-primary" href="{{ route('external_recipient.edit',$d->id) }}">Edit</a>
            </form>
        </td>
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
