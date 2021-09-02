@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

<div class="row">
    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.memo") }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-cyan"><i class="fa fa-sticky-note"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Memo Internal</span>
                <span>Memo internal adalah memo yang diberikan dari satu departemen ke departemen lain</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>
    <!-- /.info-box -->

    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.beritaAcara") }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-keyboard"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Berita Acara</span>
                <span>Berita acara adalah dokumen yang di buat setelah rapat</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>

    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.suratKeluar", ["suratKeluarType" => "Biasa"]) }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-purple"><i class="fa fa-envelope-square"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Surat Keluar Biasa</span>
                <span>Surat untuk instansi lain atau cabang lainnya dengan kepentingan biasa</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>
    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.suratKeluar", ["suratKeluarType" => "Keterangan"]) }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-purple"><i class="fa fa-envelope-square"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Surat Keterangan</span>
                <span>Surat keluar yang digunakan sebagai keterangan</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>

    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.suratKeluar", ["suratKeluarType" => "Perintah"]) }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-purple"><i class="fa fa-envelope-square"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Surat Perintah</span>
                <span>Surat keluar yang digunakan sebagai perintah</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>

    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.suratKeluar", ["suratKeluarType" => "Tugas"]) }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-purple"><i class="fa fa-envelope-square"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Surat Tugas</span>
                <span>Surat keluar yang digunakan sebagai penugasan</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>


    <div class="col-sm-4 col-xs-12">
        <a href='{{ route("document.suratMasuk") }}' class="info-box">

            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-purple"><i class="fa fa-envelope-square"></i></span>
            <div class="info-box-content">
                <span class="info-box-text info-box-title">Buat Disposisi Kepala Unit</span>
                <span>Surat masuk ke dari instansi luar</span>
            </div>
            <!-- /.info-box-content -->
        </a>
    </div>

</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .info-box {
        color: #212529;
    }

    .info-box-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .info-box {
        height: 120px;
    }

</style>
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
