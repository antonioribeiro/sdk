<?php

namespace PragmaRX\Sdk\Services\CpfCnpj\Validators;

use PragmaRX\Support\CpfCnpj\Cpf;
use PragmaRX\Support\CpfCnpj\Cnpj;
use Illuminate\Validation\Validator;

class CpfCnpj extends Validator
{
    public function validate_cpf($attribute, $value, $parameters)
    {
        return Cpf::validar($value);
    }

    public function validate_cnpj($attribute, $value, $parameters)
    {
        return Cnpj::validar($value);
    }
}
