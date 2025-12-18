<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perbaikan Forklift</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            color: #333;
        }

        .header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #0d6efd;
        }

        .header small {
            color: #666;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 4px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report th,
        table.report td {
            border: 1px solid #999;
            padding: 6px;
            vertical-align: top;
        }

        table.report th {
            background-color: #f1f5f9;
            text-align: center;
            font-weight: bold;
        }

        table.report td {
            font-size: 10.5px;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            color: #fff;
        }

        .badge-success {
            background-color: #198754;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }

        .signature {
            margin-top: 50px;
            width: 100%;
        }

        .signature td {
            width: 33%;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- ================= HEADER ================= --}}
<div class="header">
    <h2>LAPORAN PERBAIKAN FORKLIFT</h2>
    <small>Sistem Informasi Maintenance Perbaikan Forklift (SIMPF)</small>
</div>

{{-- ================= INFO REPORT ================= --}}
<table class="info-table">
    <tr>
        <td width="20%"><strong>Periode</strong></td>
        <td width="30%">
            :
            {{ $bulan ? date('F Y', mktime(0,0,0,$bulan,1)) : 'Semua Periode' }}
        </td>

        <td width="20%"><strong>Tanggal Cetak</strong></td>
        <td width="30%">: {{ now()->format('d M Y H:i') }}</td>
    </tr>
    <tr>
        <td><strong>Total Data</strong></td>
        <td>: {{ count($data) }} Perbaikan</td>

        <td><strong>Status</strong></td>
        <td>: SELESAI</td>
    </tr>
</table>

{{-- ================= TABLE ================= --}}
<table class="report">
    <thead>
        <tr>
            <th width="3%">No</th>
            <th width="10%">Tanggal</th>
            <th width="25%">Forklift</th>
            <th width="15%">Teknisi</th>
            <th width="37%">Hasil Perbaikan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $r)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">
                {{ $r->created_at->format('d M Y') }}
            </td>
            <td>
                {{ $r->forklift->merk ?? '-' }}
                <small>{{ $r->forklift->tipe ?? '' }}</small>
            </td>
            <td>{{ $r->technician->name ?? '-' }}</td>
            <td>{{ $r->hasil_perbaikan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= FOOTER ================= --}}
<div class="footer">
    <p>
        Laporan ini dihasilkan secara otomatis oleh sistem SIMPF dan
        digunakan sebagai dokumentasi resmi kegiatan perbaikan forklift.
    </p>
</div>

{{-- ================= TANDA TANGAN ================= --}}
<table class="signature">
    <tr>
        <td>
            Mengetahui,<br>
            Supervisor
            <br><br><br>
            ( __________________ )
        </td>
        <td>
            Diperiksa Oleh,<br>
            Koordinator
            <br><br><br>
            ( __________________ )
        </td>
        <td>
            Dibuat Oleh,<br>
            Admin
            <br><br><br>
            ( __________________ )
        </td>
    </tr>
</table>

</body>
</html>
