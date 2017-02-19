<?php

use PragmaRX\Sdk\Core\Validation\Resolver;

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new Resolver($translator, $data, $rules, $messages);
});
