<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCanceled extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $products;
    public $totalPrice;

    public function __construct($order, $products, $totalPrice)
    {
        $this->order = $order;
        $this->products = $products;
        $this->totalPrice = $totalPrice;
    }

    public function build()
    {
        return $this->view('emails.order-canceled')
                    ->subject('Ваш заказ отменен');
    }
} 