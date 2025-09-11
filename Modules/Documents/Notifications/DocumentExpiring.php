<?php

namespace Modules\Documents\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Documents\Models\Document;

class DocumentExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Document $document, public int $days)
    {
    }

    public function via($notifiable): array
    {
        return ['mail','database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('documents::documents.documents'))
            ->line(__('documents::documents.type').': '.$this->document->type)
            ->line(__('documents::documents.expire_at').': '.$this->document->expire_at?->format('Y-m-d'))
            ->line(__('documents::documents.expire_at')." in {$this->days} days");
    }

    public function toArray($notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'type' => $this->document->type,
            'expire_at' => $this->document->expire_at,
            'days' => $this->days,
        ];
    }
}
