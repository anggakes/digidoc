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
                Buat Surat Keluar
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

                @if ($error = Session::get('error'))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endif


                <form method="post" action="{{ route('document.suratKeluar.store') }}" id="myForm"
                      enctype="multipart/form-data">
                    @csrf

                    <input type="text" hidden name="surat_keluar_type" class="form-control" id="title"
                           aria-describedby="title" value="{{ $suratKeluarType }}">

                    <div class="form-group">
                        <label for="title">Perihal</label>
                        <input type="text" name="title" class="form-control" id="title" aria-describedby="title">
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
                        <label for="title">Nama Penerima</label>
                        <input type="text" name="surat_keluar_name" class="form-control" id="title" aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="title">Email Penerima</label>
                        <input type="text" name="surat_keluar_email" class="form-control" id="title" aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="title">Nomor Telepon Penerima</label>
                        <input type="text" name="surat_keluar_phone" class="form-control" id="title" aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="title">Alamat Penerima</label>
                        <input type="text" name="surat_keluar_address" class="form-control" id="title" aria-describedby="title">
                    </div>

                    <div class="form-group">
                        <label for="title">CC Email</label>
                        <div class="input-group hdtuto_cc control-group lst_cc increment_cc">
                            <input type="email" name="email_cc[]" class="form-control" id="title"
                                   aria-describedby="title">
                            <div class="input-group-btn">
                                <button class="btn btn-success add_cc" type="button"><i
                                        class="fldemo_cc glyphicon glyphicon-plus"></i>Add
                                </button>
                            </div>
                        </div>

                        <div class="clone_cc hide">
                            <div class="hdtuto_cc control-group lst_cc input-group" style="margin-top:10px">
                                <input type="email" name="email_cc[]" class="form-control" id="title"
                                       aria-describedby="title">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-danger-cc" type="button"><i
                                            class="fldemo_cc glyphicon glyphicon-remove"></i>Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="name">Isi Pesan</label>
                        <textarea name="message" label="Pesan" rows=5
                                  igroup-size="sm" placeholder="Isi Pesan" id="message"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="title">File</label>
                        <div class="input-group hdtuto control-group lst increment">
                            <input type="file" name="filenames[]" class="myfrm form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success add" type="button"><i
                                        class="fldemo glyphicon glyphicon-plus"></i>Add
                                </button>
                            </div>
                        </div>

                        <div class="clone hide">
                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                <input type="file" name="filenames[]" class="myfrm form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-danger-file" type="button"><i
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

<div style="display:none">
    @foreach ($documentTemplate as $dt)
    <div id="doctemplate-{{ $dt->id }}">
        {!! $dt->stub !!}
    </div>
    @endforeach
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .select2 {
        hdtuto_cc control-group lst_cc input-group
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
        $('#template').on('select2:select', function (e) {
            var data = e.params.data;
            var doctemplate = "doctemplate-" + data.id;
            tinymce.get("message").setContent($("#" + doctemplate).html(), {format: 'html'});
        });

        $(".add").click(function () {
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click", ".btn-danger-file", function () {
            console.log($(this).parents(".hdtuto control-group lst "));
            $(this).parents(".hdtuto").remove();
        });


        $(".add_cc").click(function () {
            var lsthmtl = $(".clone_cc").html();
            $(".increment_cc").after(lsthmtl);
        });
        $("body").on("click", ".btn-danger-cc", function () {
            console.log($(this).parents(".hdtuto_cc").html());
            console.log("aha");
            $(this).parents(".hdtuto_cc").remove();
        });


    });
</script>
@stop
