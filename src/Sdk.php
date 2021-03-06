<?php

namespace PragmaRX\Sdk;

class Sdk
{
    protected $sdk;

    protected $bootedCallbacks;

    protected $booted = false;

    public function boot() {
        if ($this->booted) {
            return;
        }

        $this->booted = true;

        $this->fireAppCallbacks($this->bootedCallbacks);
    }

    public function booted($callback) {
        $this->bootedCallbacks[] = $callback;

        if ($this->isBooted()) {
            $this->fireAppCallbacks([$callback]);
        }
    }

    protected function fireAppCallbacks(array $callbacks) {
        foreach ($callbacks as $callback) {
            call_user_func($callback, $this);
        }
    }

    protected function isBooted() {
        return $this->booted;
    }
}
