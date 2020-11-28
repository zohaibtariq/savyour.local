<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Models\User;

class SendEmailController extends Controller
{
    public function sendEmailToUsers()
    {
    	$this->dispatchEmailToUsers();
    	return view('emails.queued-success');
    }

    public function dispatchEmailToUsers()
    {
    	optional(User::all()->whereNotNull('email'))->each(function ($user) {
	    	dispatch(new SendEmailJob([
				'to_name'       => $user->name,
				'to_email'      => $user->email,
			]));
    	});
    }
}
