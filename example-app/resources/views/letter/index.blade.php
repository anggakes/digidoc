@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>Distribution Letter</h2>
        </div>
        <div class="float-right my-2">
            <a class="btn btn-success" href="{{ route('letter.create') }}"> Create New</a>
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
        <th>Status</th>
        <th>Document Info</th>
        <th>From</th>
        <th>To</th>
        <th>Draft To</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($letters as $letter)

    <?php
        //var_dump( $user->attr)
    ?>
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $letter->status}}</td>
        <td> {{ $letter->docno->docno }} <br> {{ $letter->docno->subject }}</td>
        <td>{{ $letter->from->name }} <br> <strong>{{ $letter->from->attr ? $letter->from->attr->position : "" }}</strong></td>
        <td>{{ $letter->to->name }} <br> <strong>{{ $letter->to->attr ? $letter->to->attr->position : "" }}</strong></td>
        <td>{{ $letter->draftTo->name }} <br> <strong>{{ $letter->draftTo->attr ? $letter->draftTo->attr->position : "" }}</strong></td>

        <td>
            <a class="btn btn-link" href="{{ route('letter.officialMemo',$letter->id) }}">Official Memo</a>
            <br>
            @if ($letter->file_path)
            <a class="btn btn-link" href="{{  asset($letter->file_path) }}">Attachment</a>
            @endif
            <br>
            <form action="{{ route('letter.destroy',$letter->id) }}" method="POST">

                @if($letter->draft_to_id == Auth::user()->id && $letter->status == "draft")
                    <a class="btn btn-success" href="{{ route('letter.approve',$letter->id) }}">Approve</a>
                @endif


                <a class="btn btn-primary" href="{{ route('letter.edit',$letter->id) }}">Edit</a>



                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<div class="text-center">
    {!! $letters->links() !!}
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
