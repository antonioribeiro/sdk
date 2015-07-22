<?php

namespace PragmaRX\Sdk\Services\Markdown\Service;

use League\CommonMark\CommonMarkConverter;

class Markdown
{
	/**
	 * @var CommonMarkConverter
	 */
	private $converter;

	public function __construct(CommonMarkConverter $converter)
	{
		$this->converter = $converter;
	}

	public function toHtml($markdown)
	{
		return $this->converter->convertToHtml($markdown);
	}
}
