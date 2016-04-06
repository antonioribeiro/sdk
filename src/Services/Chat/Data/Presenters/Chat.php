<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class Chat extends Presenter
{
    public function lastMessageAt()
    {
        if ($this->entity->last_message_at)
        {
            return $this->entity->last_message_at->format($this->humanDateFormat());
        }
    }

    public function openedAt()
    {
        if ($this->entity->opened_at)
        {
            return $this->entity->opened_at->format($this->humanDateFormat());
        }
    }

    public function closedAt()
    {
        if ($this->entity->closed_at)
        {
            return $this->entity->closed_at->format($this->humanDateFormat());
        }
    }
}
