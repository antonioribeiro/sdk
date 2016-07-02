<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use ChatBase as ChatBasePresenter;

class Chat extends ChatBasePresenter
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
