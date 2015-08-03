<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName as File;
use PragmaRX\Sdk\Services\Files\Data\Repositories\File as FileRepository;

class ClippingFile extends Model
{
	protected $table = 'clipping_files';

	protected $fillable = [
		'clipping_id',
		'is_main',
		'is_snapshot',
		'file_name_id',
		'file_type_id',
		'url',
	];

	public function createFor($clipping, $isMain, $isSnapshot, $url, $fileType)
	{
		$repository = new FileRepository();

		$fileNameModel = $this->isValidFile($url)
							? $repository->downloadFile($url)
							: null;

		return static::create([
			'clipping_id' => $clipping->id,
			'is_main' => $isMain && $fileNameModel,
			'is_snapshot' => $isSnapshot && $fileNameModel,
			'file_name_id' => $fileNameModel ? $fileNameModel->id : null,
			'file_type_id' => $fileType->id,
			'url' => $url
		]);
	}

	private function isValidFile($url)
	{
		$info = pathinfo($url);

		return ! empty($info['extension']) &&
				! in_array($info['extension'], ['htm', 'html', 'php']);
	}

	public function file()
	{
		return $this->belongsTo(File::class, 'file_name_id');
	}
}
