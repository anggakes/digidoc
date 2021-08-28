<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background: rgb(204, 204, 204);
            font-family: Arial, Helvetica, sans-serif;
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }

        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }

        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }

        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }

        @media print {
            body, page {
                margin: 0;
                box-shadow: 0;
            }
        }

        .flex-container {
            justify-content: center;
            display: flex;
        }

        .qrcode {

        }

        .header {
            padding-top: 100px;
            /*height: 100px;*/
            margin-bottom: 10px;
        }

        .title {
            width: 100%;
            text-align: center;
            font-size: 20pt;
        }

        .subtitle {
            width: 100%;
            text-align: center;
            font-size: 12pt;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        .clear {
            clear: both;
        }

        .meta {
            text-align: left;
            height: 80px;
        }

        #hd td {
            padding: 10px;
        }

        .content {
            padding: 50px;
        }

        .ttd {
            /*font-weight: bold;*/
            margin-bottom: 20px;
        }

        .text-bold{
            font-weight: bold;
        }
    </style>
</head>
<body>

</body>
</html>
<page size="A4">
    <div class="">
        <div class="header">
            <div class="title" style="font-size: 18pt">
                BERITA ACARA<br>
            </div>
            <div class="subtitle">
                NOMOR: {{ $document->number }}
                <br><br>
                TENTANG <br>
                {{ strtoupper($document->title) }}
            </div>
        </div>

<!--        <div class="clear"></div>-->

        <div class="body content">

            <div class="clear"></div>


            <div>
                {!! $document->content !!}
            </div>

            <br><br>

            <div style=" margin-bottom: 20px">
                Tangerang, {{ indoDate($document->created_at->format("Y-m-d")) }}
            </div>
            @foreach($digSign as $d)
            <div class="ttd" style="width: 230px;float: left">
                <span class="text-bold"> {{ $d->label }}</span>
                <br><br>
                {{ QrCode::size(100)->generate(URL::to('/sign/'.$d->data)) }}
                <br><br>
                {{ $d->signed_by_name }} <br>
                @if($d->departement == "Kepala Kantor Cabang")
                Kepala
                @else
                {{ $d->departement }}
                @endif
            </div>
            @endforeach
            <div style="clear: both"></div>
            <br>
            {{ $document->classification_code}}
        </div>


    </div>

</page>

