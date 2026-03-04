<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Submission $submission;
    public string $oldStatus;
    public string $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Submission $submission, string $oldStatus, string $newStatus)
    {
        $this->submission = $submission;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusLabels = [
            'pending' => 'Menunggu Review',
            'in_review' => 'Sedang Direview',
            'revision_required' => 'Perlu Revisi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'in_production' => 'Dalam Produksi',
            'completed' => 'Selesai',
        ];
        
        $statusLabel = $statusLabels[$this->newStatus] ?? ucfirst($this->newStatus);
        
        return new Envelope(
            subject: 'Status Naskah Diperbarui: ' . $statusLabel . ' - ' . $this->submission->submission_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.submission-status-updated',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
