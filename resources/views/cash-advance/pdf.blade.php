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
            font-size: 20px;
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

        #items-table thead,
        #items-table tfoot {
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
        <h1 id="header-title">Pengajuan Dana</h1>
        <p>No. {{ str_pad($cashAdvance->no, 3, '0', STR_PAD_LEFT) }}/CA/IT/{{ $cashAdvance->created_at->format('Y') }}
        </p>
        <p id="header-company">PT. Hanatekindo Mulia Abadi</p>
    </div>
    <p id="header-date">Tgl:<time>{{ Illuminate\Support\Carbon::parse($cashAdvance->date)->format('d/m/Y') }}</time></p>

    <table id="items-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Keterangan</th>
                <th>QTY</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cashAdvance->items as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{!! nl2br($item->note) !!}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th class="text-right">
                    Rp {{
                    number_format(
                    $cashAdvance->items->sum(function($t){
                    return $t->quantity * $t->price;
                    }), 0, ',', '.'
                    );
                    }}
                </th>
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
                @if ($cashAdvance->is_user_signature_showed)
                <img src="{{ public_path('storage/' . $cashAdvance->user->signature) }}" />
                @endif
            </td>
            <td>
                @if ($cashAdvance->is_admin_signature_showed)
                <img src="{{ public_path('storage/' . $cashAdvance->admin->signature) }}" />
                @endif
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 10px;">
                    {{ $cashAdvance->user->name }}
                </span>
            </td>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 10px;">
                    {{ $cashAdvance->admin->name }}
                </span>
            </td>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 20px;">
                    Ranap Irwar R.
                </span>
            </td>
        </tr>
        <tr>
            <td>{{ $cashAdvance->user->department }}</td>
            <td>{{ $cashAdvance->admin->department }}</td>
            <td>Direktur</td>
        </tr>
    </table>
</body>

</html>
