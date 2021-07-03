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
            height: 160px;
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
    </style>
</head>
<body>

</body>
</html>
<page size="A4">
    <div class="">
        <div class="header">
            <div class="title">
                Nota Dinas
                <br>
                <div style="font-weight: bold;font-size: 12pt; margin-top: 10px"> No : {{ $document->number }}</div>
            </div>
            <br>
            <div class="flex-container">
                <table class="meta">
                    <tr>
                        <td>Kepada Yth</td>
                        <td>:</td>
                        <td>{{ $letter->to->attr ? strtoupper($letter->to->attr->position) : "" }}</td>
                    </tr>
                    <tr>
                        <td>Dari</td>
                        <td>:</td>
                        <td>{{ $letter->from->attr ? strtoupper($letter->from->attr->position) : "" }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $letter->docno ? $letter->docno->subject : "" }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="clear"></div>
        <hr>
        <div class="body">

            <div class="left" style="padding-left: 50px">
                <div> Dengan Hormat,</div>
            </div>

            <div class="right" style="padding-right: 50px">
                @if($letter->status == "draft")
                Tangerang, {{ $letter->created_at->format("d M Y") }}
                <br><br>
                {{ $letter->from->attr ? strtoupper($letter->from->attr->position) : "" }}
                @endif
            </div>

            <div class="clear"></div>
            <br><br>
            @if($letter->status == "draft")
            <div class="left" style="padding-left: 50px">
                <div> Tembusan Yth,</div>
                <div> {{ $letter->draftTo->attr ? strtoupper($letter->draftTo->attr->position) : "" }}</div>
            </div>
            @endif
            <div class="clear"></div>

            <br><br>

            @if($letter->status == "draft")
            <div style="text-align: center; font-weight: bold"> Historical Document</div>
            <br><br>
            <div class="flex-container">

                <table id='hd' style="width: 80%" border="1">
                    <tr style="background: #c0c0c0;">
                        <td>Employee Name</td>
                        <td>Date</td>
                        <td>Message</td>
                    </tr>
                    <tr>
                        <td>{{ $letter->from->name }}</td>
                        <td>{{ $letter->created_at->format("d M Y") }}</td>
                        <td>{{ $letter->message }}</td>
                    </tr>
                </table>
            </div>
            @endif

            @if($letter->status == "sent")
            <div style="padding-left:50px">
                {{ $letter->message }}
            </div>
            @endif

        </div>
        <br><br><br>
        @if($letter->status=="sent")
        <div class="right" style="padding-right: 80px;text-align: center">
            Tangerang, {{ $letter->created_at->format("d M Y") }}
            <br><br>
            {{ $letter->from->attr ? strtoupper($letter->from->attr->position) : "" }}
            <br><br>
            <div class="qrcode">

                {{ QrCode::size(100)->generate($letter->draft_to_id) }}
            </div>
            <br>
            {{ $letter->from->name }}
        </div>
        @endif
    </div>

</page>

