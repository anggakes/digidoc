@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Buat Template
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
                <form method="post" action="{{ route('document_template.store') }}" id="myForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="name" >
                    </div>

                    <div class="form-group">
                        <label for="name">Konten</label>
                        <textarea name="stub" label="Pesan" rows=5
                                  igroup-size="sm" placeholder="Konten" id="message"></textarea>
                    </div>



                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('document_template.index') }}" class="btn btn-link" >Back</a>
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
<script src="https://cdn.tiny.cloud/1/7fjk5pezammwp7ub2oqhsuj5yrbtmya8i6d7nzu9wbk72zs0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#message',
        plugins: 'image lists paste',
        width : "90%",
        height: "800",
        fix_list_elements : true
        // toolbar: 'numlist bullist'
    });
</script>
@stop
