<?php

namespace PragmaRX\SDK\Mailer;

use Mail;

class Mailer {

	public static function send($view, $user, $subject)
	{
		$data = [
			'user' => $user
		];

        Mail::send($view, ['data' => $data], function($message) use ($user, $subject)
        {
            $message->to($user->email);

            $message->subject($subject);
        });
	}

}
