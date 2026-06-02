<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SPK {{ $spk->nomor_spk }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 16px; margin: 0; text-transform: uppercase; letter-spacing: 2px; }
        .header h2 { font-size: 14px; margin: 5px 0 0; font-weight: normal; }
        .meta-table { width: 100%; margin-bottom: 20px; }
        .meta-table td { padding: 4px 0; vertical-align: top; }
        .meta-table td:first-child { width: 150px; font-weight: bold; }
        .content { margin: 20px 0; line-height: 1.8; }
        .table-data { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .table-data th, .table-data td { border: 1px solid #999; padding: 8px 12px; text-align: left; }
        .table-data th { background-color: #f0f0f0; }
        .footer { margin-top: 40px; text-align: right; }
        .signature { margin-top: 50px; text-align: right; }
        .signature .name { font-weight: bold; text-decoration: underline; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Surat Perintah Kerja</h1>
        <h2>Biro Umum Sekretariat Daerah Provinsi Banten</h2>
    </div>

    <table class="meta-table">
        <tr><td>Nomor SPK</td><td>: {{ $spk->nomor_spk }}</td></tr>
        <tr><td>Tanggal</td><td>: {{ $spk->tanggal_spk->format('d F Y') }}</td></tr>
        <tr><td>Nomor Pengajuan</td><td>: {{ $spk->pengajuanServis->nomor_pengajuan }}</td></tr>
    </table>

    <div class="content">
        <p>Dengan ini dikeluarkan Surat Perintah Kerja untuk pemeliharaan kendaraan:</p>

        <table class="table-data">
            <tr><th>Kode Kendaraan</th><td>{{ $spk->pengajuanServis->kendaraan->kode_kendaraan }}</td></tr>
            <tr><th>Plat Nomor</th><td>{{ $spk->pengajuanServis->kendaraan->plat_nomor }}</td></tr>
            <tr><th>Merk/Tipe</th><td>{{ $spk->pengajuanServis->kendaraan->merk }} {{ $spk->pengajuanServis->kendaraan->tipe }}</td></tr>
            <tr><th>Tahun</th><td>{{ $spk->pengajuanServis->kendaraan->tahun }}</td></tr>
            <tr><th>Keluhan</th><td>{{ $spk->pengajuanServis->keluhan }}</td></tr>
        </table>

        @if($spk->keterangan)
        <p><strong>Keterangan:</strong> {{ $spk->keterangan }}</p>
        @endif
    </div>

    <div class="signature">
        <p>Dikeluarkan di : Serang</p>
        <p>Pada tanggal : {{ $spk->tanggal_spk->format('d F Y') }}</p>
        <br><br>
        <p style="margin-bottom: 0;">Kepala Biro Umum</p>
        <div class="name">{{ $spk->pengajuanServis->pengaju->name }}</div>
    </div>
</body>
</html>
