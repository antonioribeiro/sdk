<?php

namespace PragmaRX\Sdk\Services\Files\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class UploadPathNotSet extends HttpResponseException {

	protected $message = 'paragraphs.upload-path-not-set';

}
