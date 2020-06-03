<?php

namespace App\Notifications;

use App\Channels\TweetSms;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [/*'mail',*/ 'database', /*'broadcast', 'nexmo',*/ TweetSms::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Order')
                    ->from('msafadi@pnina.ps', 'Mohammed Safadi')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('A new order has been created Order #' . $this->order->id)
                    ->action('View your order', route('orders'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the notification data.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new order has been created Order #' . $this->order->id,
            'action' => route('orders'),
            'icon' => '',
        ];
    }

    /**
     * Get the notification data.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'A new order has been created Order #' . $this->order->id,
            'action' => route('orders'),
            'icon' => '',
        ]);
    }

    /**
     * Get the notification data.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toNexmo($notifiable)
    {
        $message = new NexmoMessage();
        $message->content('New Order #' . $this->order->id);
        return $message;
    }
    
    public function toTweetSms($notifiable)
    {
        return 'New Order #' . $this->order->id;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
