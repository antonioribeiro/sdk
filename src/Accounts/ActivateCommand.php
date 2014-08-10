<?php namespace PragmaRX\SDK\Accounts;

class ActivateCommand {

	public $email;

	public $token;

    /**
     * Constructor
     *
     */
    public function __construct($email, $token)
    {
	    $this->email = $email;

	    $this->token = $token;
    }

}
