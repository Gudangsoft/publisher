<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Naskah Diperbarui</title>
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
        .status-change {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 25px 0;
            flex-wrap: wrap;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        .status-old {
            background: #e5e7eb;
            color: #6b7280;
        }
        .status-arrow {
            margin: 0 15px;
            font-size: 24px;
            color: #9ca3af;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-in_review { background: #dbeafe; color: #1e40af; }
        .status-revision_required { background: #fed7aa; color: #c2410c; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-in_production { background: #e9d5ff; color: #6b21a8; }
        .status-completed { background: #e5e7eb; color: #374151; }
        .notes-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .notes-box h4 {
            margin: 0 0 10px 0;
            color: #92400e;
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
    </style>
</head>
<body>
    @php
    $statusLabels = [
        'pending' => 'Menunggu Review',
        'in_review' => 'Sedang Direview',
        'revision_required' => 'Perlu Revisi',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'in_production' => 'Dalam Produksi',
        'completed' => 'Selesai',
    ];
    
    $statusMessages = [
        'in_review' => 'Naskah Anda sedang dalam proses review oleh tim editor kami.',
        'revision_required' => 'Naskah Anda memerlukan beberapa revisi. Silakan lihat catatan dari editor di bawah.',
        'approved' => 'Selamat! Naskah Anda telah disetujui untuk diterbitkan. Tim kami akan segera menghubungi Anda untuk langkah selanjutnya.',
        'rejected' => 'Mohon maaf, setelah pertimbangan matang, kami memutuskan untuk tidak dapat melanjutkan proses penerbitan naskah Anda. Silakan lihat alasan penolakan di bawah.',
        'in_production' => 'Naskah Anda saat ini sedang dalam proses produksi/pencetakan.',
        'completed' => 'Proses penerbitan naskah Anda telah selesai. Terima kasih telah mempercayakan naskah Anda kepada kami!',
    ];
    @endphp

    <div class="header">
        <h1>📋 Status Naskah Diperbarui</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $submission->submitter_name }}</strong>,</p>
        
        <p>Status pengajuan naskah Anda telah diperbarui:</p>
        
        <div class="status-change">
            <span class="status-badge status-old">{{ $statusLabels[$oldStatus] ?? ucfirst($oldStatus) }}</span>
            <span class="status-arrow">→</span>
            <span class="status-badge status-{{ $newStatus }}">{{ $statusLabels[$newStatus] ?? ucfirst($newStatus) }}</span>
        </div>

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
            </table>
        </div>

        <p>{{ $statusMessages[$newStatus] ?? 'Status naskah Anda telah diperbarui.' }}</p>

        @if(in_array($newStatus, ['revision_required', 'rejected']) && $submission->revision_notes)
        <div class="notes-box">
            <h4>📝 Catatan dari Editor:</h4>
            <p style="margin: 0;">{{ $submission->revision_notes }}</p>
        </div>
        @endif

        @if($newStatus == 'approved' && $submission->estimated_cost)
        <div class="info-box" style="border-left-color: #10b981;">
            <h4 style="margin: 0 0 10px 0; color: #065f46;">💰 Estimasi Biaya:</h4>
            <p style="margin: 0; font-size: 24px; font-weight: bold; color: #065f46;">
                Rp {{ number_format($submission->estimated_cost, 0, ',', '.') }}
            </p>
            @if($submission->print_quantity)
            <p style="margin: 5px 0 0 0; color: #666;">Untuk cetak {{ $submission->print_quantity }} eksemplar</p>
            @endif
        </div>
        @endif

        @if($submission->admin_notes && $newStatus == 'approved')
        <div class="notes-box" style="background: #d1fae5; border-color: #10b981;">
            <h4 style="color: #065f46;">📝 Catatan Tambahan:</h4>
            <p style="margin: 0;">{{ $submission->admin_notes }}</p>
        </div>
        @endif

        <center>
            <a href="{{ url('/dashboard/submissions/' . $submission->id) }}" class="btn">Lihat Detail Pengajuan</a>
        </center>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
