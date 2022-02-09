<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeliveryPlanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $dataset;

    public function __construct($obj)
    {
        $this->dataset = $obj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->dataset['fromemail'], $this->dataset['fromname'])->view('emails.ftdeliveryplan', ['dataset' => $this->dataset])->subject($this->dataset['subject']);
    }
}
