<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Naskah Diterima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #EE6D26, #f39c12);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #EE6D26;
            padding: 15px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #666;
        }
        .info-value {
            color: #333;
        }
        .status-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }
        .btn {
            display: inline-block;
            background: #EE6D26;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn:hover {
            background: #d35400;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Pengajuan Naskah Diterima</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $submission->submitter_name }}</strong>,</p>
        
        <p>Terima kasih telah mengajukan naskah Anda ke {{ config('app.name') }}. Kami telah menerima pengajuan naskah Anda dengan detail sebagai berikut:</p>
        
        <div class="info-box">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">No. Pengajuan:</td>
                    <td style="padding: 8px 0;">{{ $submission->submission_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Judul Naskah:</td>
                    <td style="padding: 8px 0;">{{ $submission->title }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Jenis:</td>
                    <td style="padding: 8px 0;">{{ ucfirst($submission->type) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Est. Halaman:</td>
                    <td style="padding: 8px 0;">{{ $submission->estimated_pages ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Tanggal:</td>
                    <td style="padding: 8px 0;">{{ $submission->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #666; font-weight: bold;">Status:</td>
                    <td style="padding: 8px 0;">
                        <span class="status-badge">Menunggu Review</span>
                    </td>
                </tr>
            </table>
        </div>

        <h3>Apa selanjutnya?</h3>
        <ol>
            <li>Tim editor kami akan mereview naskah Anda dalam 3-7 hari kerja.</li>
            <li>Anda akan menerima email pemberitahuan ketika status naskah berubah.</li>
            <li>Jika ada pertanyaan atau hal yang perlu diklarifikasi, kami akan menghubungi Anda.</li>
        </ol>

        <p>Anda dapat memantau status pengajuan Anda dengan login ke akun Anda:</p>
        
        <center>
            <a href="{{ url('/dashboard/submissions/' . $submission->id) }}" class="btn">Lihat Status Pengajuan</a>
        </center>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
