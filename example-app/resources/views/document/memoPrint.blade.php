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
            height: 80px;
        }

        .title {
            width: 100%;
            text-align: center;
            font-size: 22pt;
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
            padding-left: 50px;
        }

        .ttd {
            font-weight: bold;
        }
    </style>
</head>
<body>


<page size="A4">
    <div class="">
        <div class="header">
            <div class="title" style="font-size: 14pt">
                MEMO INTERNAL
            </div>
        </div>
        <div class="clear"></div>

        <div class="body content">

            <div class="left">
                <table class="meta">
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $document->number }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ indoDate($document->created_at->format("Y-m-d")) }}</td>
                    </tr>
                    <tr>
                        <td>Kepada</td>
                        <td>:</td>
                        <td>{{ $document->memoDepartment->kepala()->label }}</td>
                    </tr>
                    <tr>
                        <td>Dari</td>
                        <td>:</td>
                        <td>{{ $document->createdBy->jobPosition->department->name }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $document->title }}</td>
                    </tr>

                </table>
            </div>

            <div class="clear"></div>

            <br><br>


            <div>
                {!! $document->content !!}
            </div>

            <br><br>
            <?php
            $prefixSign = "";

            try{

                $kepala = $document->createdBy->jobPosition->jobParent->user->name;

                $prefixSign = strtoupper(substr($kepala, 0, 2));

            }catch (Exception $e){

            }

            ?>
            @foreach($digSign as $d)
            <div class="ttd">
                <span class="text-bold"> {{ $d->label }}</span>
                <br><br>
                {{ QrCode::size(100)->generate(URL::to('/sign/'.$d->data)) }}
                <br><br>
                {{ $d->signed_by_name }} <br>
                {{ $d->departement }}
            </div>
            @endforeach
            <br>
            <?php
            // create classification code format
            $prefixCreator = strtoupper(substr($document->createdBy->name, 0, 2));

            $cc = $prefixSign . "/" . $prefixCreator . "/" .$document->classification_code;

            ?>
            {{ $cc }}


        </div>


    </div>

</page>

<page size="A4">

    <div class="header">
        <div class="title">
            Catatan Disposisi
        </div>

    </div>
    <div class="clear"></div>

    <div class="body content">
        <?php
        $notes = [];
        foreach ($docAct as $dc) {
            if ($dc->note == "") continue;
            $notes[$dc->note][] = $dc->user->name;
        }

        ?>


        @foreach($notes as $note => $tos)
        <table style="border:1px solid #000; width: 90%">
            <tr>
                <td style="font-weight: bold">
                    Kepada
                    <br>

                </td>
                <td>:</td>
                <td>
                    @foreach($tos as $idx => $to)
                    {{ $to }}@if( count($tos)-1 > $idx),@endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold">
                    Catatan
                </td>
                <td>:</td>
                <td>{{ $note }}</td>
            </tr>
        </table>

        @endforeach


    </div>
</page>


</body>
</html>
