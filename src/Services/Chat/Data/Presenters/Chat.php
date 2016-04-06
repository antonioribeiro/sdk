<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class Chat extends Presenter
{
    public function lastMessageAt()
    {
        return $this->entity->last_message_at->format($this->humanDateFormat());
    }

    public function openedAt()
    {
        return $this->entity->opened_at->format($this->humanDateFormat());
    }

    public function closedAt()
    {
        return $this->entity->closed_at->format($this->humanDateFormat());
    }

    public function humanDateFormat()
    {
        return 'd/m/Y H:m:s';
    }
}
