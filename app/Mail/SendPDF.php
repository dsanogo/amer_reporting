<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPDF extends Mailable
{
    use Queueable, SerializesModels;
    public $pdfFile;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, $email)
    {
        $this->pdfFile = $pdf;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = config('email')['from'];

        return $this->view('admin.emails.sendpdf')
                    ->to($this->email)
                    ->from($from)
                    ->subject('Amer reporting system - pdf')
                    ->attachData($this->pdfFile, 'report.pdf');
    }
}
