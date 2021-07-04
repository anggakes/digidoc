@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>Inbox</h2>
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
        <th>Number</th>
        <th>Subject</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($document as $da)
    <tr
        class=""
    >
        <td>{{ ++$i }}</td>
        <td>{{ $da->number }}</td>
        <td>{{ $da->title  }}</td>
        <td>
            <a href="{{ route('document.show', $da->id) }}">Lihat</a>
        </td>
    </tr>
    @endforeach
</table>

<div class="text-center">
    {!! $document->links() !!}
</div>


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    svg{
        height:12px;s
    }

    .notdone{
        background: lightpink;
    }
</style>
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
