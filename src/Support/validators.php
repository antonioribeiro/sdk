<?php

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new PragmaRX\Sdk\Core\Validation\Custom\Phone($translator, $data, $rules, $messages);
});

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new PragmaRX\Sdk\Core\Validation\Custom\Zip($translator, $data, $rules, $messages);
});
