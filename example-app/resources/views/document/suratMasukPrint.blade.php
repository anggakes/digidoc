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

    <div class="header">
        <div class="title" style="font-size: 14pt">
            LEMBAR DISPOSISI
        </div>

    </div>
    <div class="clear"></div>

    <div class="body content">
        <table style="border:1px solid #000; width: 92%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Dari</td>
                            <td>:</td>
                            <td>{{ $document->surat_masuk_from }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Surat</td>
                            <td>:</td>
                            <td>{{ indoDate($document->surat_masuk_date) }}</td>

                        </tr>

                        <tr>
                            <td>Nomor K.K</td>
                            <td>:</td>
                            <td>{{ $document->classification_code }}</td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td>{{ $document->number }}</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table>
                        <tr>
                            <td>Tanggal Dibuat</td>
                            <td>:</td>
                            <td>{{ indoDate($document->created_at->format("Y-m-d")) }}</td>
                        </tr>

                        <tr>
                            <td>Jumlah File</td>
                            <td>:</td>
                            <td>{{ $document->files()->count() }}</td>
                        </tr>
                        <tr>
                            <td>Perihal</td>
                            <td>:</td>
                            <td>{{ $document->title }}</td>
                        </tr>
                    </table>

                </td>
            </tr>


        </table>
        <?php
        $notes = [];
        foreach ($docAct as $dc) {
            if ($dc->note == "") continue;

            $from = "";
            if ($dc->action_from != "") {
                $from = $dc->from->name;
            }

            $notes[$dc->note]["to"][] = $dc->user->name;
            $notes[$dc->note]["from"] = $from;
            $notes[$dc->note]["date"] = indoDate($dc->created_at->format("Y-m-d"));

        }

        ?>

        <br><br>
        @foreach($notes as $note => $tos)
        <table style="border:1px solid #000; width: 92%">
            @if($tos["from"])
            <tr>
                <td style="width:120px;font-weight: bold;border-right:1px solid #000;">
                    Dari
                    <br>

                </td>
                <td style="padding-left: 10px;">
                    {{ $tos["from"] }}
                </td>
            </tr>
            @endif
            <tr>
                <td style="font-weight: bold;border-right:1px solid #000;">
                    Kepada
                    <br>

                </td>
                <td style="padding-left: 10px;">
                    @foreach($tos["to"] as $idx => $to)
                    {{ $to }}@if( count($tos["to"])-1 > $idx),@endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;border-right:1px solid #000;">Tanggal</td>

                <td style="padding-left: 10px;">{{ $tos["date"] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border-right:1px solid #000;">
                    Catatan
                </td>
                <td style="padding-left: 10px;">{{ $note }}</td>
            </tr>
        </table>
        <br>
        @endforeach


    </div>
</page>


</body>
</html>
