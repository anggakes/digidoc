@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>User Management</h2>
        </div>
        <div class="float-right my-2">
            <a class="btn btn-success" href="{{ route('user.create') }}"> Create New</a>
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
        <th>Email</th>
        <th>Name</th>
        <th>Position</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($users as $user)

    <?php
        //var_dump( $user->attr)
    ?>
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->attr ? $user->attr->position : ""}}</td>
        <td>
            <form action="{{ route('user.destroy',$user->id) }}" method="POST">

<!--                <a class="btn btn-primary" href="{{ route('user.edit',$user->id) }}">Edit</a>-->

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<div class="text-center">
    {!! $users->links() !!}
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
