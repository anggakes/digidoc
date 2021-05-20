@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('plugins.Select2', true)

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Create New Distribution Letter
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
                <form method="post" action="{{ route('letter.store') }}" id="myForm" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Document Number</label>
                        <x-adminlte-select2 name="docno_id" class="form-control"
                                            data-placeholder="Select Document Number...">
                            <option value="">Select Document Number...</option>
                            @foreach ($docnos as $docno)
                            <option value="{{ $docno->id }}">{{ $docno->docno }} - {{ $docno->subject }} </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>

                    <div class="form-group">
                        <label for="name">To</label>
                        <x-adminlte-select2 name="to_id" class="form-control" data-placeholder="Select Recipient...">
                            <option value="">Select Recipient...</option>
                            @foreach ($users as $user)
                                @if($user->attr)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->attr->position }}</option>
                                @endif
                            @endforeach
                        </x-adminlte-select2>
                    </div>

                    <div class="form-group">
                        <label for="name">Send draft to</label>
                        <x-adminlte-select2 name="draft_to_id" class="form-control"
                                            data-placeholder="Select draft will sent to...">
                            <option value="">Select draft will sent to...</option>
                            @foreach ($users as $user)
                            @if($user->attr)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->attr->position }}</option>
                            @endif
                            @endforeach
                        </x-adminlte-select2>
                    </div>

                    <div class="form-group">

                        <x-adminlte-textarea name="message" label="Message" rows=5
                                             igroup-size="sm" placeholder="Insert message...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-dark">
                                    <i class="fas fa-lg fa-file-alt "></i>
                                </div>
                            </x-slot>
                        </x-adminlte-textarea>
                    </div>



                    <div class="form-group">
                        <label for="name">Attachment</label>
                        <x-adminlte-input-file name="file" igroup-size="sm" placeholder="Choose a file...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('user.index') }}" class="btn btn-link">Back</a>
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
