<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris - {{ date('Y-m-d') }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px double #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; border: none; }
        .info td { padding: 2px 0; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .data-table th, .data-table td { border: 1px solid #333; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { float: right; width: 250px; text-align: center; margin-top: 50px; }
        .footer p { margin-bottom: 80px; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        @media print {
            .no-print { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Komisi Informasi Provinsi Bali</h1>
        <p>Gedung Dinas Komunikasi Informatika dan Statistik Prov. Bali</p>
        <p>Jl. Pandjaitan No. 7, Sumerta Kelod, Denpasar Tim., Kota Denpasar, Bali 80234</p>
    </div>

    <div class="text-center" style="margin-bottom: 20px;">
        <h2 style="margin: 0; text-decoration: underline;">LAPORAN INVENTARIS ASET</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120">Tanggal Cetak</td>
                <td width="10">:</td>
                <td class="font-bold">{{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>:</td>
                <td>{{ $filters['category'] }}</td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>:</td>
                <td>{{ $filters['location'] }}</td>
            </tr>
            <tr>
                <td>Kondisi</td>
                <td>:</td>
                <td>{{ $filters['condition'] }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th width="100">Kode Aset</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th width="60" class="text-center">Jumlah</th>
                <th width="80" class="text-center">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $index => $asset)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold">{{ $asset->asset_code }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->category }}</td>
                <td>{{ $asset->location->name }}</td>
                <td class="text-center">{{ $asset->quantity }} {{ $asset->unit }}</td>
                <td class="text-center uppercase" style="font-size: 10px;">{{ $asset->condition }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Denpasar, {{ date('d F Y') }}<br>Administrator SIMI-KIBA</p>
        <div class="font-bold">( __________________________ )</div>
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4f46e5; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Cetak Lagi</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-left: 10px;">Tutup</button>
    </div>
</body>
</html>
