<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $products;

    public function __construct($order, $products)
    {
        $this->order = $order;
        $this->products = $products;
    }

    public function build()
    {
        return $this->view('emails.order-created')
                    ->subject('Ваш заказ успешно сформирован');
    }
} 