<?php

namespace PragmaRX\Sdk\Services\Markdown\Service;

use League\CommonMark\CommonMarkConverter;

class Markdown
{
	/**
	 * @var CommonMarkConverter
	 */
	private $converter;

	public function __construct()
	{
		$this->converter = new CommonMarkConverter();
	}

	public function toHtml($markdown)
	{
		return $this->converter->convertToHtml($markdown);
	}
}
