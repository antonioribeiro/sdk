<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramPhoto;

class TelegramMessage extends Presenter
{
    private function makeMessage()
    {
        if ($this->entity->photo)
        {
            $photos = $this->makePhotos($this->entity->photo);

            $thumb = $this->selectPhoto($photos, 'medium')['url'];
            $big = $this->selectPhoto($photos, 'large')['url'];

            return '<img class="kallzenter-chat-telegram-photo" src="'.$thumb.'" data-image-large="'.$big.'" />';
        }
    }

    private function makePhotoUrl($photo)
    {
        $photo = TelegramPhoto::find($photo['id']);

        $fileName = $photo->fileName;

        return $fileName->file->url;
    }

    private function makePhotos($photos)
    {
        $photos = json_decode($photos, true);

        foreach ($photos as $key => $photo)
        {
            $photos[$key]['url'] = $this->makePhotoUrl($photo);
        }

        return $photos;
    }

    public function message()
    {
        if ($this->entity->text)
        {
            return $this->entity->text;
        }

        $message = $this->makeMessage();

        return $message;
    }

    private function selectPhoto($photos, $size)
    {
        usort(
            $photos,
            function($a, $b)
            {
                return $a['width'] - $b['width'];
            }
        );

        $sizes['small'] = 0;
        $sizes['medium'] = 0;
        $sizes['large'] = 0;

        if (count($photos) > 1)
        {
            $sizes['medium'] = 1;
            $sizes['large'] = 1;
        }

        if (count($photos) > 2)
        {
            $sizes['large'] = 2;
        }

        $photo = $photos[$sizes[$size]];

        return $photo;
    }
}
