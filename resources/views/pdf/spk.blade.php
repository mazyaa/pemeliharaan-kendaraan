<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SPK {{ $spk->nomor_spk }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* =========================
           KOP SURAT
        ========================== */

        .kop-surat {
            width: 100%;
            border-bottom: 4px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 110px;
            vertical-align: middle;
            text-align: center;
        }

        .logo-cell img {
            width: 85px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .text-cell {
            text-align: center;
            vertical-align: middle;
            padding-right: 40px;
        }

        .title1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .title2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .alamat {
            font-size: 13px;
            line-height: 1.5;
        }

        /* =========================
           CONTENT
        ========================== */

        .content {
            padding: 0 20px;
            line-height: 1.6;
        }

        .judul-spk {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 25px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .meta-table td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 13px;
        }

        .meta-table .label {
            width: 180px;
            font-weight: bold;
        }

        .detail-section {
            margin-top: 20px;
        }

        .detail-section h3 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .detail-item {
            padding: 2px 0;
            font-size: 13px;
        }

        /* =========================
           TTD
        ========================== */

        .signature {
            width: 300px;
            margin-left: auto;
            margin-top: 50px;
            text-align: center;
        }

        .signature .name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="logo-cell">
                    {{-- Gunakan PNG, jangan SVG --}}
                    <img src="{{ public_path('logo-banten.png') }}" alt="Logo Banten">
                </td>

                <td class="text-cell">
                    <div class="title1">
                        PEMERINTAH PROVINSI BANTEN
                    </div>

                    <div class="title2">
                        SEKRETARIAT DAERAH
                    </div>

                    <div class="alamat">
                        Kawasan Pusat Pemerintahan Provinsi Banten (KP3B)
                    </div>

                    <div class="alamat">
                        Jl. Syech Nawawi Al-Bantani, Curug, Palima,
                        Kota Serang – Banten
                    </div>

                    <div class="alamat">
                        Laman setda.bantenprov.go.id,
                        Pos-el sekretariatdaerah@bantenprov.go.id,
                        Kode Pos 42171
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="judul-spk">
            SURAT PERINTAH KERJA
        </div>

        <table class="meta-table">
            <tr>
                <td class="label">Nomor SPK</td>
                <td>: {{ $spk->nomor_spk }}</td>
            </tr>

            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $spk->tanggal_spk->format('d F Y') }}</td>
            </tr>

            <tr>
                <td class="label">Nomor Pengajuan</td>
                <td>: {{ $spk->pengajuanServis->nomor_pengajuan }}</td>
            </tr>
        </table>

        <p>
            Dengan ini dikeluarkan Surat Perintah Kerja untuk
            pelaksanaan pemeliharaan kendaraan dinas sebagai berikut:
        </p>

        <table class="meta-table">
            <tr>
                <td class="label">Kode Kendaraan</td>
                <td>: {{ $spk->pengajuanServis->kendaraan->kode_kendaraan }}</td>
            </tr>

            <tr>
                <td class="label">Plat Nomor</td>
                <td>: {{ $spk->pengajuanServis->kendaraan->plat_nomor }}</td>
            </tr>

            <tr>
                <td class="label">Merk / Tipe</td>
                <td>:
                    {{ $spk->pengajuanServis->kendaraan->merk }}
                    {{ $spk->pengajuanServis->kendaraan->tipe }}
                </td>
            </tr>

            <tr>
                <td class="label">Tahun</td>
                <td>: {{ $spk->pengajuanServis->kendaraan->tahun }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pengaju</td>
                <td>: {{ $spk->pengajuanServis->pengaju->name }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td>: {{ $spk->pengajuanServis->pengaju->nip }}</td>
            </tr>
        </table>

        <div class="detail-section">
            <h3>Jenis Pemeliharaan</h3>

            @forelse($spk->pengajuanServis->details as $detail)
                <div class="detail-item">
                    • {{ $detail->jenisPemeliharaan->nama }}
                    ({{ $detail->jenisPemeliharaan->kategori }})
                </div>
            @empty
                <div class="detail-item">
                    Tidak ada jenis pemeliharaan.
                </div>
            @endforelse
        </div>

        @if($spk->keterangan)
            <div style="margin-top:20px;">
                <strong>Keterangan :</strong>
                {{ $spk->keterangan }}
            </div>
        @endif

        <!-- TTD -->
        @php
            $kabiroApproval = $spk->pengajuanServis->approvalHistories()
                ->where('approval_level', 2)
                ->whereIn('status', ['approved', 'disposed'])
                ->latest('approved_at')
                ->first();
            $kabiro = $kabiroApproval?->approver;
        @endphp
        <div class="signature">
            <div>Dikeluarkan di : Serang</div>
            <div>Pada tanggal : {{ $spk->tanggal_spk->format('d F Y') }}</div>

            <div style="margin-top:60px;">
                Kepala Biro Umum
            </div>

            <div class="name">
                {{ $kabiro?->name ?? $spk->pengajuanServis->pengaju->name }}
            </div>
            <div>{{ $kabiro?->nip ?? '' }}</div>
        </div>

    </div>

</body>

</html>
