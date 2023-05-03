<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class Invitation extends Mailable
{
    public $name;
    public $invitationLink;

    public function __construct($name, $invitationLink)
    {
        $this->name = $name;
        $this->invitationLink = $invitationLink;
    }

    public function build()
    {
        return $this->view('invitation')
            ->subject('Invitation to Join Our Website')
            ->with([
                'name' => $this->name,
                'invitationLink' => $this->invitationLink,
                'title' => 'Invitation to Join Our Website',
            ]);
    }
}
