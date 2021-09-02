<!DOCTYPE html>
<html>
<head>
    <style>
        body {

        }

        page {
            background: white;
            margin: 0 auto;
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

        .page-break {
            page-break-after: always;
        }
        page[size="A4"] {
            width: 21cm;
            height: 20cm;
        }
    </style>
</head>
<body>


<page size="A4">

    <div style="padding:20px 90px 20px 10px">

        <?php

        $prefixSign = "";

        try {

            $kepala = $document->createdBy->jobPosition->jobParent->user->name;

            $prefixSign = strtoupper(substr($kepala, 0, 2));

        } catch (Exception $e) {

        }

        $ttd = "";
        foreach ($digSign as $d) {
            $ttd .= '<div class="ttd" style="width: 230px;float: left">
                <img src="data:image/png;base64, ' . base64_encode(QrCode::format('png')->size(100)->generate($d->data)) . '">.
                <br><br>
                ' . $d->signed_by_name . '<br>
                ' . $d->departement . '
            </div>';
        }

        $prefixCreator = strtoupper(substr($document->createdBy->name, 0, 2));

        $cc = "";
        if ($prefixSign) {
            $cc .= $prefixSign . "/";
        }

        $cc .= $prefixCreator . "/" . $document->classification_code;


        if (count($digSign) > 0) {
            $ttd .= "<div class='clear'></div> <div>" . $cc . "</div>";
        }

        $jumlahLampiran = "";
        if ($document->files()->count() > 0) {
            $jumlahLampiran = '<p><span style="font-weight: 400;">Lampiran</span><span style="font-weight: 400;"> </span><span
                style="font-weight: 400;">&nbsp;&nbsp;&nbsp;&nbsp;: ' . $document->files()->count() . ' </span></p>';
        }

        $penerima = $document->surat_keluar_name ?? "";

        ?>

        <?php
        echo renderBlade($document->content, [
            "tanda_tangan" => $ttd,
            "nomor_surat" => $document->number,
            "tanggal_surat" => indoDate($document->created_at->format("Y-m-d")),
            "jumlah_lampiran" => $jumlahLampiran,
            "perihal" => $document->title,
            "nama_penerima" => $penerima,
        ])
        ?>



    </div>

</page>
<!--<div class="page-break"></div>-->

</body>
</html>
