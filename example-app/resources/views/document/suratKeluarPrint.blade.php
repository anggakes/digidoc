<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background: rgb(204, 204, 204);
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
    <div style="padding:3cm">

        <?php

        $prefixSign = "";

        try {

            $kepala = $document->createdBy->jobPosition->jobParent->user->name;

            $prefixSign = strtoupper(substr($kepala, 0, 2));

        } catch (Exception $e) {

        }

        $ttd = "";
        foreach ($digSign as $d) {
            $ttd .= '<div class="ttd">
                <span class="text-bold">' . $d->label . '</span>
                <br><br>
                ' . QrCode::size(100)->generate(URL::to('/sign/' . $d->data)) . '
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
            $ttd .= "<br>" . $cc;
        }

        $jumlahLampiran = "";
        if ($document->files()->count() > 0) {
            $jumlahLampiran = $document->files()->count();
        }

        ?>

        <?php echo renderBlade($document->content, [
            "tanda_tangan" => $ttd,
            "nomor_surat" => $document->number,
            "tanggal_surat" => indoDate($document->created_at->format("Y-m-d")),
            "jumlah_lampiran" => $jumlahLampiran,
            "perihal" => $document->title,
            "nama_penerima" => $document->surat_keluar_name,
        ]) ?>
    </div>

</page>

</body>
</html>
