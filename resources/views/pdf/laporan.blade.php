<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemeliharaan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 16px; margin: 0; text-transform: uppercase; }
        .header p { font-size: 12px; margin: 5px 0 0; }
        .summary { display: flex; gap: 20px; margin: 20px 0; }
        .summary-box { flex: 1; border: 1px solid #ddd; padding: 10px; text-align: center; }
        .summary-box .value { font-size: 18px; font-weight: bold; }
        .summary-box .label { font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; font-size: 10px; }
        th { background-color: #f5f5f5; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pemeliharaan Kendaraan Dinas</h1>
        <p>Biro Umum Sekretariat Daerah Provinsi Banten</p>
        <p>Periode: {{ isset($filters['date_from']) ? \Carbon\Carbon::parse($filters['date_from'])->format('d/m/Y') : 'Semua' }} - {{ isset($filters['date_to']) ? \Carbon\Carbon::parse($filters['date_to'])->format('d/m/Y') : 'Semua' }}</p>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="value">{{ $summary['total_data'] }}</div>
            <div class="label">Total Data</div>
        </div>
        <div class="summary-box">
            <div class="value">{{ $summary['total_selesai'] }}</div>
            <div class="label">Selesai</div>
        </div>
        <div class="summary-box">
            <div class="value">{{ $summary['total_diproses'] }}</div>
            <div class="label">Diproses</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor SPK</th>
                <th>Kendaraan</th>
                <th>Bengkel</th>
                <th>Tgl Masuk</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->spk->nomor_spk }}</td>
                <td>{{ $item->spk->pengajuanServis->kendaraan->merk }} {{ $item->spk->pengajuanServis->kendaraan->tipe }}</td>
                <td>{{ $item->nama_bengkel }}</td>
                <td>{{ $item->tanggal_masuk->format('d/m/Y') }}</td>
                <td>{{ $item->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $item->label_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
