<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramPhoto;

class TelegramMessage extends Presenter
{
    /**
     * @return string
     */
    private function makePhotoMessage()
    {
        $photos = $this->makePhotos($this->entity->photo);

        $thumb = $this->selectPhoto($photos, 'md')['url'];
        $big = $this->selectPhoto($photos, 'lg')['url'];

        if ($thumb) {
            return '<img class="kallzenter-chat-telegram-photo" src="' . $thumb . '" data-image-large="' . $big . '" />';
        }

        return '<img class="kallzenter-chat-telegram-photo" src="https://www.cirruseo.com/statics/images/spinner.gif" />';
    }

    private function makePhotoUrl($photo)
    {
        try
        {
            return TelegramPhoto::find($photo['id'])->fileName->file->url;
        }
        catch (\Exception $e)
        {
            return null;
        }
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

        if ($this->entity->photo)
        {
            return $this->makePhotoMessage();
        }

        return 'A mensagem recebida não é suportada por este sistema.';
    }

    private function selectPhoto($photos, $size)
    {
        if (! $photos)
        {
            return null;
        }

        usort(
            $photos,
            function($a, $b)
            {
                return $a['width'] - $b['width'];
            }
        );

        $sizes['sm'] = 0;
        $sizes['md'] = 0;
        $sizes['lg'] = 0;
        $sizes['xl'] = 0;

        if (count($photos) > 1)
        {
            $sizes['md'] = 1;
            $sizes['lg'] = 1;
            $sizes['xl'] = 1;
        }

        if (count($photos) > 2)
        {
            $sizes['large'] = 2;
            $sizes['xl'] = 2;
        }

        if (count($photos) > 3)
        {
            $sizes['xl'] = 3;
        }

        $photo = $photos[$sizes[$size]];

        return $photo;
    }
}
