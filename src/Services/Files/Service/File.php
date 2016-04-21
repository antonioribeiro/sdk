<?php

namespace PragmaRX\Sdk\Services\Files\Service;

use App;
use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;

class File
{
	/**
	 * @var Filesystem
	 */
	private $filesystem;

	public function __construct()
	{
		$this->filesystem = App::make('files');
	}

    private function getBaseUrl()
    {
        if ($this->isS3())
        {
            return sprintf('//%s.amazonaws.com/%s/', $this->getS3Region(true), $this->getS3Bucket());
        }

        return '/';
    }

    private function getS3Region($translatedToUrlRegion = false)
    {
        $region = config('filesystems.disks.s3.region');

        if ($translatedToUrlRegion)
        {
            if ($region == 'us-east-1')
            {
                $region = 's3';
            }
        }

        return $region;
    }

    private function getStorage()
    {
        if (! $this->isS3())
        {
            return Storage::disk('local');
        }

        return Storage::disk('s3');
    }

    /**
     * @return bool
     */
    private function isS3()
    {
        return $this->getS3Bucket() && $this->getS3Key();
    }

    public function getS3Bucket()
    {
        return config('filesystems.disks.s3.bucket');
    }

    public function getS3Key()
    {
        return config('filesystems.disks.s3.key');
    }

    /**
     * @param $hashPath
     * @param $fileName
     * @param $uploading
     */
    private function storeUploadedFile($hashPath, $fileName, $uploading)
    {
        $fileName = $hashPath . '/' . $fileName;

        if (! $this->getStorage()->has($fileName))
        {
            $this->getStorage()->put($fileName, file_get_contents($uploading), FilesystemContract::VISIBILITY_PUBLIC);
        }
    }

    public function upload($file)
	{
		return $file;
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(
			array($this->filesystem, $name),
			$arguments
		);
	}

	public function allDirectories($directory)
	{
		$directories = [];

		foreach (Finder::create()->in($directory)->directories() as $dir)
		{
			$directories[] = $dir;
		}

		return $directories;
	}

	public function tempDir()
	{
		$name = 'tempfolder';
		$counter = 0;

		while(file_exists($directory = sys_get_temp_dir()."/{$name}_{$counter}"))
		{
			$counter++;
		}

		mkdir($directory);

		return $directory;
	}

	public function hash($file)
	{
		return sha1_file($file);
	}

	public function moveUploadedFile(UploadedFile $file, $path, $hash)
	{
		$extension = $file->getClientOriginalExtension();

		$deepPath = $this->makeDeepPath($hash);

		$hashPath = $path . $deepPath;

		$fileName = "{$hash}.{$extension}";

        $uploading = $file->getPathname();

        $this->storeUploadedFile($hashPath, $fileName, $uploading);

        $url = $this->getBaseUrl();

        $filSize = $file->getSize();

        $mimeType = $file->getMimeType();

        unlink($file->getPathname());

		return [$file, $deepPath, $filSize, $mimeType, $url];
	}

	private function makeDeepPath($string)
	{
		$path = '';

		for ($x = 0; $x <= min(6, strlen($string)); $x++)
		{
			$path .= '/'.$string[$x];
		}

		return $path;
	}

	private function makeUploadDirectory($hashPath, $int, $true)
	{
		if ( ! $this->exists($hashPath))
		{
			$this->makeDirectory($hashPath, 0775, true); // true = recursive
		}
	}
}
