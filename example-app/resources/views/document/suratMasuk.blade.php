@extends('adminlte::page')

@section('title', 'Buat Berita Acara')

@section('content_header')

@stop

@section('plugins.Select2', true)

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Buat Berita Acara
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
                <form method="post" action="{{ route('document.suratMasuk.store') }}" id="myForm"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Perihal</label>
                        <input type="text" name="title" class="form-control" id="title" aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="name">Kode Klasifikasi</label>
                        <x-adminlte-select2 name="doc_class_code" class="form-control"
                                            data-placeholder="Pilih Kode Klasifikasi...">
                            <option value="">Pilih Kode Klasifikasi...</option>

                        </x-adminlte-select2>
                    </div>

                    <div class="form-group">
                        <label for="number">Nomor Surat</label>
                        <input type="text" name="number" class="form-control" id="title" aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="number">Tanggal Surat</label>
                        <input type="date" name="surat_masuk_date" class="form-control" id="title"
                               aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="title">Dari</label>
                        <input type="text" name="surat_masuk_from" class="form-control" id="title"
                               aria-describedby="title">
                    </div>
                    <div class="form-group">
                        <label for="title">File</label>
                        <div class="input-group hdtuto control-group lst increment">
                            <input type="file" name="filenames[]" class="myfrm form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success" type="button"><i
                                        class="fldemo glyphicon glyphicon-plus"></i>Add
                                </button>
                            </div>
                        </div>

                        <div class="clone hide">
                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                <input type="file" name="filenames[]" class="myfrm form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger" type="button"><i
                                            class="fldemo glyphicon glyphicon-remove"></i>Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <button type="submit" class="btn btn-primary btn-success">Simpan</button>
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
<script src="https://cdn.tiny.cloud/1/7fjk5pezammwp7ub2oqhsuj5yrbtmya8i6d7nzu9wbk72zs0/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#message',
        plugins: 'image lists paste',
        width: "90%",
        height: "800",
        fix_list_elements: true
        // toolbar: 'numlist bullist'
    });

    $(document).ready(function () {
        $(".btn-success").click(function () {
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click", ".btn-danger", function () {
            console.log($(this).parents(".hdtuto control-group lst "));
            $(this).parents(".hdtuto").remove();
        });
    });
</script>
@stop