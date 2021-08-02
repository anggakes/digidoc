@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Selamat datang di e-let co.</p>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "d4de6a7c-fb5b-4b11-b0d0-dfa7c6265306",
        });
        OneSignal.setExternalUserId("{{ Auth::user()->id }}");
    });
</script>
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
