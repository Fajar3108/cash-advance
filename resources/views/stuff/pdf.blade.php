<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        body {
            font-family: arial;
        }

        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: 16px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        #header {
            text-align: center;
            position: relative;
            padding: 20px 0;
        }

        #header img {
            position: absolute;
            top: 10px;
            left: 0;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        #header-title {
            text-decoration: underline;
            text-transform: uppercase;
            font-size: 18px;
        }

        #header-number {
            margin-top: -10px;
        }

        #header-date time {
            margin-left: 20px;
            margin-bottom: 10px;
        }

        #items-table {
            border: 1px solid #000;
            border-collapse: collapse;
            width: 100%;
        }

        #items-table th,
        #items-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        #items-table thead {
            background-color: #f0f0f0;
        }

        #signature {
            width: 100%;
            text-align: center;
            margin-top: 30px;
        }

        #signature tr:nth-child(3) td {
            position: relative;
        }

        #signature tr:nth-child(2) td {
            height: 75px;
            padding: 10px 0;
        }

        #signature tr:nth-child(2) td img {
            width: 75px;
            height: 75px;
            object-fit: cover;
        }

        #signature tr:nth-child(4) td {
            font-size: 14px;
        }

        #signature tr:nth-child(3) td div {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 1px;
            background-color: #000;
        }
    </style>
</head>

<body>
    <div id="header">
        <img src="{{ public_path('images/logo_hma.png') }}" />
        <h1 id="header-title">PERMINTAAN BARANG DAN ALAT PENDUKUNGNYA</h1>
        <p id="header-number">
            No. {{ $stuff->code }}
        </p>
    </div>
    <p id="header-date">Tgl:<time>{{ Illuminate\Support\Carbon::parse($stuff->date)->format('d/m/Y') }}</time></p>

    <table id="items-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>name</th>
                <th>QTY</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stuff->items as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-right">{{ $item->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td>{!! nl2br($item->note) !!}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="border: 0;"></td>
                <td colspan="3" style="border: 0;">
                    Notes: <br />
                    {{ $stuff->description }}
                </td>
            </tr>
        </tfoot>
    </table>

    <table id="signature">
        <tr>
            <td>Pemohon,</td>
            <td>Menyetujui,</td>
            <td>Menyetujui,</td>
        </tr>
        <tr>
            <td>
                @if ($stuff->is_user_signature_showed)
                <img src="{{ public_path('storage/' . $stuff->user->signature) }}" />
                @endif
            </td>
            <td>
                @if ($stuff->is_admin_signature_showed)
                <img src="{{ public_path('storage/' . $stuff->admin->signature) }}" />
                @endif
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 10px;">
                    {{ $stuff->user->name }}
                </span>
            </td>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 10px;">
                    {{ $stuff->admin->name }}
                </span>
            </td>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 20px;">
                    Ranap Irwar R.
                </span>
            </td>
        </tr>
        <tr>
            <td>{{ $stuff->user->department }}</td>
            <td>{{ $stuff->admin->department }}</td>
            <td>Direktur</td>
        </tr>
    </table>
</body>

</html>