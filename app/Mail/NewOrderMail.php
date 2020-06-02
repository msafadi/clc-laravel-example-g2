<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, Order $order)
    {
        $this->name = $name;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('New Order');
        $this->from('x@example.com', 'X Store');
        return $this->view('mails.neworder', [
            'name' => $this->name,
            'order' => $this->order,
        ]);
    }
}
