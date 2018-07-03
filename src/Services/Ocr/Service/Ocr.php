<?php

namespace PragmaRX\Sdk\Services\Ocr\Service;

use TesseractOCR;

class Ocr
{
    public static function run($file)
    {
        return (new TesseractOCR($file))->tessdataDir(base_path('ocr'))->lang('olx')->run();
    }
}
