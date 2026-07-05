<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>

    <style>
        body{
            font-family: Arial, sans-serif;
        }

        h2{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid black;
        }

        th, td{
            padding:8px;
            text-align:left;
        }

        th{
            background:#f2f2f2;
        }
    </style>

</head>
<body>

<h2>LAPORAN BARANG MASUK</h2>

<table>

    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>

    <tbody>

        @forelse($barangMasuks as $item)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->barang->nama_barang }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->keterangan }}</td>
        </tr>

        @empty
        <tr>
            <td colspan="5" style="text-align:center;">Tidak ada data barang masuk</td>
        </tr>
        @endforelse

    </tbody>

</table>

</body>
</html>