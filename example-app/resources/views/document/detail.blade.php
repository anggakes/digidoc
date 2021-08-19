@extends('adminlte::page')

@section('title', 'Create New Memo')

@section('content_header')

@stop

@section('plugins.Select2', true)

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                {{ strtoupper($document->type) }}
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

                @if ($success = Session::get('success'))
                <div class="alert alert-success">
                    {{ $success }}
                </div>
                @endif

                @if($document->type=="memo")
                <a href="{{ route('document.memo.print', $document->id) }}" target="_blank" class="btn btn-primary">Lihat
                    Dokumen Cetak</a>
                @endif

                @if($document->type=="berita acara")
                <a href="{{ route('document.beritaAcara.print', $document->id) }}" target="_blank"
                   class="btn btn-primary">Lihat
                    Dokumen Cetak</a>
                @endif


                @if($document->type=="surat keluar")
                <a href="{{ route('document.suratKeluar.print', $document->id) }}" target="_blank"
                   class="btn btn-primary">Lihat
                    Dokumen Cetak</a>
                @endif

                <br>

                <table class="table table-borderless">
                    <tr>
                        <td>Tipe Dokumen</td>
                        <td>:</td>
                        <td>{{ $document->type }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Dokumen</td>
                        <td>:</td>
                        <td>{{ $document->number }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $document->title }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ $document->created_at->format("d M Y") }}</td>
                    </tr>
                    <tr>
                        <td>Di Buat Oleh</td>
                        <td>:</td>
                        <td>{{ $document->createdBy->name }} <br> ({{ $document->createdBy->nip }})</td>
                    </tr>

                    @if($document->type=="memo")
                    <tr>
                        <td>Kepada</td>
                        <td>:</td>
                        <td>{{ $document->memoDepartment->name }}</td>
                    </tr>
                    <tr>
                        <td>Dari</td>
                        <td>:</td>
                        <td>{{ $document->createdBy->jobPosition->department->name }}</td>
                    </tr>
                    @endif

                    @if($document->type=="berita acara")
                    <tr>
                        <td>Departemen</td>
                        <td>:</td>
                        <td>{{ $document->beritaAcaraDepartment->name }}</td>
                    </tr>
                    @endif

                    @if($document->type=="surat masuk")
                    <tr>
                        <td>Jumlah File</td>
                        <td>:</td>
                        <td>{{ $document->files()->count() }}</td>
                    </tr>
                    @endif

                    @if($document->type=="surat keluar")
                    <tr>
                        <td>Jumlah File</td>
                        <td>:</td>
                        <td>{{ $document->files()->count() }}</td>
                    </tr>
                    <tr>
                        <td>Tipe surat</td>
                        <td>:</td>
                        <td>{{ $document->surat_keluar_type }}</td>
                    </tr>
                    <tr>
                        <?php
                        $exRecipient = $document->externalRecipient;
                        ?>
                        <td>Tujuan</td>
                        <td>:</td>
                        <td>
                            <span style="font-weight: bold">{{ $exRecipient->name}}</span> <br>
                            {{ $exRecipient->email}} <br>
                            {{ $exRecipient->phone}} <br>
                            {{ $exRecipient->address}} <br>
                        </td>
                    </tr>
                    @endif

                </table>

                <hr>
                <br>
                @if($document->content)
                {!! $document->content !!}
                @endif

                @if($document->files()->count() > 0)
                <hr>
                @foreach($document->files as $file)
                @if( isImage($file->path))
                <img src="{{ asset($file->path) }}">
                @endif
                <a href="{{  asset($file->path) }}">{{ $file->path }}</a>
                @endforeach

                @endif

                <hr>
                <h3>Approval dan Tanda Tangan</h3>
                <br>
                <div class="col-12">
                    @foreach($docAct as $da)

                    <div class="card">
                        <div class="card-header
                        @if($da->is_done)
                                 bg-green
                            @else
                                 bg-red
                            @endif
                       ">
                            {{ $da->action_need }} -
                            @if($da->is_done)
                            Selesai
                            @else
                            Belum
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-condensed table-borderless">
                                <tr>
                                    <td>Nama</td>
                                    <td>{{ $da->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>{{ $da->user->jobPosition->label }}</td>
                                </tr>
                                @if($da->note != "")
                                <tr>
                                    <td>Catatan</td>
                                    <td> {{$da->note}}</td>
                                </tr>
                                @endif
                            </table>

                            @if($da->is_done)

                            @else
                            @if($document->type=="memo")
                            @if($da->user->id == Auth::user()->id)
                            @if($da->action_need=="Tanda Tangan")
                            <a href="{{ route('document.memo.sign', $document->id) }}" class="btn btn-primary">Tandatangani</a>
                            @endif
                            @if($da->action_need=="Baca")
                            <a href="{{ route('document.memo.view', $document->id) }}" class="btn btn-primary">Tandai
                                Sudah Dibaca</a>
                            @endif
                            @if($da->action_need=="Disposisi")

                            <form method="post" action="{{ route('document.memo.disposisi', $document->id) }}"
                                  id="myForm"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="note">Catatan</label>
                                        <textarea name="note" class="form-control" id="subject"
                                                  aria-describedby="note"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name">Departemen Tujuan</label>
                                    <div class="input-group hdtuto control-group lst increment">

                                        <div class="row">
                                            <div class="col-10">
                                                <x-adminlte-select2 name="dep_ids[]" class="form-control"
                                                                    data-placeholder="Dikirim ke...">
                                                    <option value="">Dikirim ke...</option>
                                                    @foreach ($department as $dep)
                                                    @if( $dep->id == Auth::user()->jobPosition->department->id)
                                                    @continue
                                                    @endif
                                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>

                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                            <div class="col-2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-success add" type="button"><i
                                                            class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clone hide">
                                        <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                            <div class="row">
                                                <div class="col-10">
                                                    <x-adminlte-select2 name="dep_ids[]" class="form-control"
                                                                        data-placeholder="Dikirim ke...">
                                                        <option value="">Dikirim ke...</option>
                                                        @foreach ($department as $dep)
                                                        @if( $dep->id == Auth::user()->jobPosition->department->id)
                                                        @continue
                                                        @endif
                                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>

                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <div class="col-2">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-danger" type="button"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>

                            </form>
                            @endif
                            @else

                            @endif
                            @endif

                            <!--                            Berita acara -->
                            @if($document->type=="berita acara")
                            @if($da->user->id == Auth::user()->id)
                            @if($da->action_need=="Tanda Tangan")
                            <a href="{{ route('document.beritaAcara.sign', $document->id) }}" class="btn btn-primary">Tandatangani</a>
                            @endif
                            @if($da->action_need=="Baca")
                            <a href="{{ route('document.beritaAcara.view', $document->id) }}" class="btn btn-primary">Tandai
                                Sudah Dibaca</a>
                            @endif
                            @else
                            Belum
                            @endif
                            @endif


                            <!--                            Surat Masuk -->
                            @if($document->type=="surat masuk")
                            @if($da->user->id == Auth::user()->id)
                            @if($da->action_need=="Baca")
                            <a href="{{ route('document.suratMasuk.view', $document->id) }}" class="btn btn-primary">Tandai
                                Sudah Dibaca</a>
                            @endif
                            @if($da->action_need=="Disposisi")

                            <form method="post" action="{{ route('document.suratMasuk.disposisi', $document->id) }}"
                                  id="myForm"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Departemen Tujuan</label>
                                    <x-adminlte-select2 name="dep_ids[]" class="form-control"
                                                        data-placeholder="Dikirim ke...">
                                        <option value="">Dikirim ke...</option>
                                        @foreach ($department as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>

                                        @endforeach
                                    </x-adminlte-select2>
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>

                            </form>
                            @endif
                            @else
                            Belum
                            @endif
                            @endif


                            @endif
                        </div>
                    </div>

                    @endforeach
                </div>

            </div>

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
    // tinymce.init({
    //     selector: '#message',
    //     plugins: 'image',
    // });

    $(document).ready(function () {
        $(".add").click(function () {
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
