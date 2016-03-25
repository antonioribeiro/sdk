<?php

namespace PragmaRX\Sdk\Services\Backup\Service;

use BackupManager\Manager;
use BackupManager\Filesystems\Destination;
use Carbon\Carbon;

class Backup
{
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
	}

    public function backup() 
    {
        $connection = 'postgresql';

        $database = config('database.connections.'.$connection.'.database');

        $this->manager->makeBackup()->run(
            $connection,
            $this->makeDestinations($database, $connection),
            'gzip'
        );
    }

    private function makeDestinations($database, $connection)
    {
        $domain = $_SERVER['SERVER_NAME'];

        $carbon = Carbon::now();

        $now = $carbon->format('Y-m-d@H:m:s');

        $file = sprintf('%s-%s-%s-%s.backup.gz', $domain, $database, $now, $connection);

        $path = sprintf(
            'domains/%s/backup/databases/%s/%s/%s/%s/%s',
            $domain,
            $database,
            $carbon->year,
            $carbon->month,
            $carbon->day,
            $file
        );

        return [
            new Destination(
                'dropbox',
                $path
            )
        ];
    }
}
