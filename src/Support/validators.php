<?php

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new PragmaRX\Sdk\Core\Validation\Resolver($translator, $data, $rules, $messages);
});
