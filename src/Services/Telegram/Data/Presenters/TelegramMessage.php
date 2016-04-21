<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class TelegramMessage extends Presenter
{
    private function makeMessage()
    {
        if ($this->entity->photo)
        {
            return $this->makePhotos($this->entity->photo);
        }
    }

    private function makePhotoUrl($photo)
    {
        
    }

    private function makePhotos($photos)
    {
        $photos = json_decode($photos);

        foreach ($photos as $key => $photo)
        {
            $photos[$key]['url'] = $this->makePhotoUrl($photo);
        }
    }

    public function message()
    {
        if ($this->entity->text)
        {
            return $this->entity->text;
        }

        return $this->makeMessage();
    }
}
