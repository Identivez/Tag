<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('pedidos@tagsole.com', 'TAG & SOLE Pedidos')
                    ->subject('Confirmación de Pedido #' . $this->order->OrderId . ' - TAG & SOLE')
                    ->view('emails.order-confirmation')
                    ->with([
                        'order' => $this->order,
                        'fecha' => now()->format('d/m/Y H:i:s')
                    ]);
    }
}
