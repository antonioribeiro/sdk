<?php namespace PragmaRX\Sdk\Services\Accounts\Commands;

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
