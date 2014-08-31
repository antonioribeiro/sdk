<?php

$validator = new Illuminate\Validation\Factory(app()['translator'], app());

$validator->extend('validatePhone', 'PragmaRX\Sdk\Core\Validation\Custom\Phone');
