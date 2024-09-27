<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $project;
    public $message;

    public function __construct($project, $message)
    {
        $this->project = $project;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Project Notification')
            ->line($this->message)
            ->line('Project Name: ' . $this->project->name)
            ->line('Current Status: ' . $this->project->status)
            ->action('View Projects', route('projects'));
    }
}
