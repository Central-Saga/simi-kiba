<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; color: #1e40af; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 4px 0 0; color: #64748b; font-style: italic; }
        .meta { margin-bottom: 15px; font-size: 10px; color: #475569; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th { background-color: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 8px 6px; text-align: left; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        td { border: 1px solid #cbd5e1; padding: 6px; vertical-align: top; word-wrap: break-word; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; height: 30px; text-align: center; font-size: 9px; color: #94a3b8; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan {{ $title }}</h1>
        <p>SIMI-KIBA - Sistem Informasi Manajemen Inventaris</p>
    </div>

    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}<br>
        <strong>Kriteria:</strong> Semua Data (Hasil Filter Dashboard)
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @foreach($columns as $column)
                        <td>
                            @php
                                $value = data_get($record, $column);
                                // Format dates if they look like dates
                                if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
                                    $value = date('d/m/Y', strtotime($value));
                                }
                                // Format booleans
                                if (is_bool($value)) {
                                    $value = $value ? 'Ya' : 'Tidak';
                                }
                            @endphp
                            {{ $value }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman <span class="page-number"></span> | SIMI-KIBA Inventaris
    </div>
</body>
</html>
