@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container mt-8">

    <div class="row  ">
        <div class="card" style="width: 100%">
            <div class="card-header">
                Edit Document Number
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
                <form method="post" action="{{ route('docno.update', ['docno' => $docno->id]) }}" id="myForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="doc_date">Date</label>
                        <input type="date" name="doc_date" class="form-control" id="date" aria-describedby="date" value="{{ $docno->doc_date }}">
                    </div>
                    <div class="form-group">
                        <label for="doc_type">Document Type</label>
                        <select name="doc_type"  class="form-control" id="doc_type" aria-describedby="doc_type">
                            <option {{  "SED" == $docno->doc_type ? 'selected="selected"' : '' }} value="SED">SED - Surat Edaran</option>
                            <option {{  "SPR" == $docno->doc_type ? 'selected="selected"' : '' }} value="SPR">SPR - Surat Perintah</option>
                            <option {{  "KEP" == $docno->doc_type ? 'selected="selected"' : '' }} value="KEP">KEP - Surat Keputusan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="classification">Classification</label>
                        <select name="classification"  class="form-control" id="classification" aria-describedby="classification">
                            <option value="01.01">01.01 - Pelaksana Tugas</option>
                            <option value="01.02">01.02 - Pelaksana harian</option>
                            <option value="01.03">01.03 - Organisasi dan tatakerja</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" value="{{ $docno->subject}}" name="subject" class="form-control" id="subject" aria-describedby="subject" >
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('docno.index') }}" class="btn btn-link" >Back</a>
                </form>

                <br>

                <div class="form-group">
                    <label for="docno">Document Number</label>
                    <input type="text" disabled name="docno" class="form-control" id="docno" aria-describedby="docno" value="{{ $docno->docno}}" >
                </div>

            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
