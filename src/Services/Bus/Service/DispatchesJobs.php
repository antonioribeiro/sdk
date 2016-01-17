<?php

namespace PragmaRX\Sdk\Services\Bus\Service;

use ArrayAccess;

trait DispatchesJobs
{
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return mixed
     */
    protected function dispatch($job)
    {
        return app('AltThree\Bus\Dispatcher')->dispatch($job);
    }

    /**
     * Marshal a job and dispatch it to its appropriate handler.
     *
     * @param  mixed  $job
     * @param  array  $array
     * @return mixed
     */
    protected function dispatchFromArray($job, array $array)
    {
        return app('AltThree\Bus\Dispatcher')->dispatchFromArray($job, $array);
    }

    /**
     * Marshal a job and dispatch it to its appropriate handler.
     *
     * @param  mixed  $job
     * @param  \ArrayAccess  $source
     * @param  array  $extras
     * @return mixed
     */
    protected function dispatchFrom($job, ArrayAccess $source, $extras = [])
    {
        return app('PragmaRX\Sdk\Services\Bus\Service\Dispatcher')->dispatchFrom($job, $source, $extras);
    }
}
