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

                </table>

                <hr>
                <br>
                @if($document->content)
                {!! $document->content !!}
                @endif

                <hr>
                <h3>Approval dan Tanda Tangan</h3>
                <table class="table table-condensed">
                    <thead>
                    <th>Nama</th>
                    <th>Aksi</th>
                    <th>Selesai</th>
                    </thead>
                    <tbody>
                    @foreach($docAct as $da)
                    <tr>
                        <td>{{ $da->user->name }} <br> {{ $da->user->jobPosition->department->name }}</td>
                        <td>
                            {{ $da->action_need }}
                        </td>
                        <td>
                            @if($da->is_done)
                            Ya
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

                            <form method="post" action="{{ route('document.memo.disposisi', $document->id) }}" id="myForm"
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

                            <form method="post" action="{{ route('document.suratMasuk.disposisi', $document->id) }}" id="myForm"
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
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
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
</script>
@stop
