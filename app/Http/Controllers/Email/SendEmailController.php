<?php

namespace App\Http\Controllers\Email;

use App\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;

class SendEmailController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendEmailToUsers()
    {
    	$this->dispatchEmailToUsers();
    	return view('emails.queued-success');
    }

    public function dispatchEmailToUsers()
    {
    	optional($this->userRepository->allWhereNotNull('email'))->each(function ($user) {
	    	dispatch(new SendEmailJob([
				'to_name'       => $user->name,
				'to_email'      => $user->email,
			]));
    	});
    }
}
