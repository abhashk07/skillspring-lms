<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EnrollmentStatusNotification extends Notification
{
    use Queueable;

    public $courseTitle;
    public $status;

    public function __construct($courseTitle, $status)
    {
        $this->courseTitle = $courseTitle;
        $this->status = $status;
    }

   public function via($notifiable)
{
    return ['mail', 'database'];
}

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Enrollment Update')
            ->greeting('Hello ' . $notifiable->name)
            ->line("Your enrollment for '{$this->courseTitle}' has been {$this->status}.")
            ->line('Thank you for using our platform.');
    }

    public function toDatabase($notifiable)
{
    return [
        'course' => $this->courseTitle,
        'status' => $this->status,
        'message' => "Your enrollment for {$this->courseTitle} was {$this->status}",
    ];
}

}
