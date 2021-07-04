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
                <form method="post" action="{{ route('document.beritaAcara.store') }}" id="myForm" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Perihal</label>
                        <input type="text" name="title" class="form-control" id="title" aria-describedby="title" >
                    </div>

                    <div class="form-group">
                        <label for="name">Kode Klasifikasi</label>
                        <x-adminlte-select2 name="doc_class_code" class="form-control"
                                            data-placeholder="Pilih Kode Klasifikasi...">
                            <option value="">Pilih Kode Klasifikasi...</option>
                            @foreach ($docClass as $dc)
                            <option value="{{ $dc->code }}">{{ $dc->code }} - {{ $dc->archive_type }}</option>

                            @endforeach
                        </x-adminlte-select2>
                    </div>

                    <div class="form-group">
                        <label for="name">Isi Pesan</label>
                        <textarea name="message" label="Pesan" rows=5
                                  igroup-size="sm" placeholder="Isi Pesan" id="message"></textarea>
                    </div>


                    <button type="submit" class="btn btn-primary">Simpan</button>
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
