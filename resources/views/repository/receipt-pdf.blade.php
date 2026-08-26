<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bukti Submit {{ $submission->submission_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            padding: 30px;
        }
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #EE6D26;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .header-logo {
            display: table-cell;
            width: 60px;
            vertical-align: middle;
        }
        .header-logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .header .title {
            font-size: 20px;
            font-weight: bold;
            color: #EE6D26;
        }
        .header .subtitle {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        .code-box {
            text-align: center;
            background: #FFF4EC;
            border: 1px solid #EE6D26;
            border-radius: 6px;
            padding: 14px;
            margin-bottom: 20px;
        }
        .code-box .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .code-box .code {
            font-size: 20px;
            font-weight: bold;
            color: #EE6D26;
            letter-spacing: 1px;
        }
        table.info {
            width: 100%;
            margin-bottom: 20px;
        }
        table.info td {
            padding: 6px 0;
            vertical-align: top;
        }
        table.info td.label {
            width: 35%;
            color: #666;
        }
        table.info td.value {
            font-weight: bold;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        table.files {
            width: 100%;
            border-collapse: collapse;
        }
        table.files td {
            padding: 8px 6px;
            border-bottom: 1px solid #eee;
        }
        table.files td.check {
            width: 24px;
            color: #16a34a;
            font-weight: bold;
        }
        .file-name {
            color: #888;
            font-size: 10px;
        }
        .verify-box {
            display: table;
            width: 100%;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }
        .verify-box .qr-cell {
            display: table-cell;
            width: 90px;
            vertical-align: middle;
        }
        .verify-box .qr-cell img {
            width: 80px;
            height: 80px;
        }
        .verify-box .verify-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 15px;
            font-size: 10px;
            color: #666;
        }
        .verify-box .verify-text strong {
            display: block;
            font-size: 11px;
            color: #333;
            margin-bottom: 3px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($logoAbsolutePath)
            <div class="header-logo">
                <img src="{{ $logoAbsolutePath }}" alt="Logo">
            </div>
            @endif
            <div class="header-text">
                <div class="title">TANDA BUKTI PENGUMPULAN SKRIPSI</div>
                <div class="subtitle">{{ \App\Models\Setting::get('site_name', 'Publisher') }} - Repository Skripsi</div>
            </div>
            @if($logoAbsolutePath)
            <div class="header-logo"></div>
            @endif
        </div>

        <div class="code-box">
            <div class="label">Kode Bukti Submit</div>
            <div class="code">{{ $submission->submission_code }}</div>
        </div>

        <table class="info">
            <tr>
                <td class="label">Nama</td>
                <td class="value">: {{ $taruna->name }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Akademik</td>
                <td class="value">: {{ $taruna->academic_number }}</td>
            </tr>
            <tr>
                <td class="label">Korps</td>
                <td class="value">: {{ $taruna->korps }}</td>
            </tr>
            <tr>
                <td class="label">Waktu Submit Terakhir</td>
                <td class="value">: {{ $submission->updated_at->format('d M Y, H:i') }} WIB</td>
            </tr>
        </table>

        <div class="section-title">Berkas yang Dikumpulkan</div>
        <table class="files">
            @foreach(\App\Models\ThesisSubmission::FILE_FIELDS as $field => $label)
            <tr>
                <td class="check">&#10003;</td>
                <td>
                    {{ $label }} {{ $submission->isLink($field) ? '(Tautan)' : '' }}<br>
                    <span class="file-name">{{ $submission->documentLabel($field) }}</span>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="verify-box">
            <div class="qr-cell">
                <img src="{{ $qrDataUri }}" alt="QR Verifikasi">
            </div>
            <div class="verify-text">
                <strong>Verifikasi Keaslian Dokumen</strong>
                Pindai kode QR di samping untuk memastikan kode bukti submit ini terdaftar dan sah di sistem.
            </div>
        </div>

        <div class="footer">
            Dokumen ini dibuat otomatis oleh sistem pada {{ now()->format('d M Y, H:i') }} WIB dan sah tanpa tanda tangan basah.
        </div>
    </div>
</body>
</html>
