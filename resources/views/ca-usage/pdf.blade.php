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
            display: table-cell;
            width: auto;
            height: 75px;
            object-fit: contain;
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
        <h1 id="header-title">Laporan Pemakaian Dana</h1>
        <p id="header-number">No. {{ str_pad($caUsage->no, 3, '0', STR_PAD_LEFT) }}/PCA/IT/{{
            $caUsage->created_at->format('Y') }}
        </p>
    </div>
    @if ($caUsage->cashAdvance)
    <p>
        Ref No: {{ str_pad($caUsage->cashAdvance->no, 3, '0', STR_PAD_LEFT) }}/CA/IT/{{
        $caUsage->cashAdvance->created_at->format('Y') }}
    </p>
    @endif
    <p id="header-date">Tgl:<time>{{ Illuminate\Support\Carbon::parse($caUsage->date)->format('d/m/Y') }}</time> -
        {{ $caUsage->name }}</p>

    <table id="items-table">
        <thead>
            <tr>
                <th>NO</th>
                <th style="width: 100px;">TGL</th>
                <th>Keterangan</th>
                <th>D</th>
                <th>K</th>
            </tr>
        </thead>
        <tbody>
            @php
            $items = $caUsage->items->sortBy('date');
            @endphp
            @foreach ($items->where('type', 'credit') as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->date }}</td>
                <td>{!! nl2br($item->note) !!}</td>
                <td class="text-right">
                    @if ($item->type == 'debit')
                    Rp{{ number_format($item->amount, 0, ',', '.') }}
                    @endif
                </td>
                <td class="text-right">
                    @if ($item->type == 'credit')
                    Rp{{ number_format($item->amount, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            @endforeach
            @foreach ($items->where('type', 'debit') as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->date }}</td>
                <td>{!! nl2br($item->note) !!}</td>
                <td class="text-right">
                    @if ($item->type == 'debit')
                    Rp{{ number_format($item->amount, 0, ',', '.') }}
                    @endif
                </td>
                <td class="text-right">
                    @if ($item->type == 'credit')
                    Rp{{ number_format($item->amount, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th class="text-right">
                    Rp{{ number_format($caUsage->items->where('type', 'debit')->sum('amount'), 0, ',', '.') }}
                </th>
                <th class="text-right">
                    Rp{{ number_format($caUsage->items->where('type', 'credit')->sum('amount'), 0, ',', '.') }}
                </th>
            </tr>
            <tr>
                <th colspan="3">Sisa Saldo</th>
                <th colspan="2" class="text-right">
                    @php
                    $remaining = $caUsage->items->where('type', 'credit')->sum('amount') -
                    $caUsage->items->where('type', 'debit')->sum('amount')
                    @endphp
                    @if ($remaining < 0) -Rp{{ number_format($remaining*-1, 0, ',' , '.' ) }} @else Rp{{
                        number_format($remaining, 0, ',' , '.' ) }} @endif </th>
            </tr>
        </tfoot>
    </table>

    <table id="signature">
        <tr>
            <td>Pemohon,</td>
            <td>Menyetujui,</td>
        </tr>
        <tr>
            <td>
                @if ($caUsage->is_user_signature_showed)
                <img src="{{ public_path('storage/' . $caUsage->user->signature) }}" />
                @endif
            </td>
            <td>
                @if ($caUsage->is_admin_signature_showed)
                <img src="{{ public_path('storage/' . $caUsage->admin->signature) }}" />
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 10px;">
                    {{ $caUsage->user->name }}
                </span>
            </td>
            <td>
                <span style="border-bottom: 1px solid #000; padding: 0 10px;">
                    {{ $caUsage->admin->name ?? '....................' }}
                </span>
            </td>
        </tr>
        <tr>
            <td>{{ $caUsage->user->department }}</td>
            <td>{{ $caUsage->admin->department ?? '....................' }}</td>
        </tr>
    </table>
</body>

</html>