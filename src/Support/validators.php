<?php

use PragmaRX\Sdk\Core\Validation\Resolver;

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return app()->make(Resolver::class, [$translator, $data, $rules, $messages]);
});
