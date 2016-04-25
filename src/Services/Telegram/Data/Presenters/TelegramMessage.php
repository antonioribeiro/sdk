<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramPhoto;

class TelegramMessage extends Presenter
{
    /**
     * @return string
     */
    private function defaultSpinner()
    {
        return '<img class="kallzenter-chat-telegram-photo" src="' . config('chat.spinner') . '" />';
    }

    private function makeDocumentMessage()
    {
        try
        {
            $url = $this->entity->document->fileName->file->url;
            $thumb = $this->entity->document->thumb->fileName->file->url;
            $name = $this->entity->document->file_name;
        }
        catch (\Exception $e)
        {
            $thumb = null;
            $url = null;
        }

        if ($thumb)
        {
            return '
                <a href="'.$url.'" class="kallzenter-chat-telegram-document-thumb" download>
                    <img class="kallzenter-chat-telegram-photo" src="' . $thumb . '" />
                </a>
                
                <p>
                    <a href="'.$url.'" class="kallzenter-chat-telegram-document-name" download>
                        Baixar '.$name.'
                    </a>
                </p>
            ';
        }

        return $this->defaultSpinner();
    }

    /**
     * @return string
     */
    private function makePhotoMessage()
    {
        $photos = $this->makePhotos($this->entity->photo);

        $thumb = $this->selectPhoto($photos, 'md')['url'];
        $big = $this->selectPhoto($photos, 'lg')['url'];

        if ($thumb)
        {
            return '<img class="kallzenter-chat-telegram-photo" src="' . $thumb . '" data-image-large="' . $big . '" onclick="showImageModal(this)" />';
        }

        return $this->defaultSpinner();
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
            return '<p class="kallzenter-chat-telegram-text">'.$this->entity->text.'</p>';
        }

        if (json_decode($this->entity->photo))
        {
            return $this->makePhotoMessage();
        }

        if (json_decode($this->entity->document))
        {
            return $this->makeDocumentMessage();
        }

        return '<p class="kallzenter-chat-telegram-warning">(ATENÇÃO: A mensagem recebida não é suportada por este sistema)</p>';
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
            $sizes['lg'] = 2;
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
