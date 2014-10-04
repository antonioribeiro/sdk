<?php

namespace PragmaRX\Sdk\Services\Mailer\Service;

use Mail;

class Mailer {

	public static function send($view, $user, $subject, $data = [])
	{
		$data = array_merge(
			['user' => $user],
			$data
		);

        Mail::send($view, $data, function($message) use ($user, $subject)
        {
            $message->to($user->email);

            $message->subject($subject);
        });
	}

}
