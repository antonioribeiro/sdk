<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramPhoto;
use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatBase as ChatBasePresenter;

class TelegramMessage extends ChatBasePresenter
{
    /**
     * @return string
     */
    private function defaultSpinner()
    {
        return '<img class="kallzenter-chat-telegram-photo" src="' . asset('assets/images/chat/spinner.gif') . '" />';
    }

    private function makeAudioMessage()
    {
        return '<img class="kallzenter-chat-telegram-photo" src="' . asset('assets/images/chat/wav.png') . '" />';
    }

    private function makeVideoMessage()
    {
        try
        {
            $thumb = $this->entity->video->thumb->fileName->file->url;
        }
        catch (\Exception $e)
        {
            $thumb = $this->makeThumb('application/mov');
        }

        try
        {
            $url = $this->entity->video->fileName->file->url;
        }
        catch (\Exception $e)
        {
            $url = null;
        }

        if ($url)
        {
            return '
                <video width="320" height="240" controls>
                    <source src="'.$url.'" type="video/mp4">
                    <source src="'.$url.'" type="video/ogg">
                    O seu browser não tem suporte a vídeo.
                </video>
                                
                <p>
                    <a href="#" class="kallzenter-chat-telegram-audio-name" onclick="downloadFile(\''.$url. '\', \'video_'.str_random(8).'.mp4\')">
                        Baixar video.mp4
                    </a>
                </p>
            ';
        }

        return $this->defaultSpinner();
    }

    private function makeVoiceMessage()
    {
        try
        {
            $url = $this->entity->voice->fileName->file->url;
        }
        catch (\Exception $e)
        {
            $url = null;
        }

        if ($url)
        {
            return '
                <audio controls>
                    <source src="'.$url.'" type="audio/ogg">
                    O seu browser não tem suporte a áudio.
                </audio>
                
                <p>
                    <a href="#" class="kallzenter-chat-telegram-audio-name" onclick="downloadFile(\''.$url. '\', \'audio_'.str_random(8).'.ogg\')">
                        Baixar audio.ogg
                    </a>
                </p>
            ';
        }

        return $this->defaultSpinner();
    }

    private function makeDocumentMessage()
    {
        try
        {
            $thumb = $this->entity->document->thumb->fileName->file->url;
        }
        catch (\Exception $e)
        {
            $thumb = $this->makeThumb($this->entity->document->mime_type);
        }

        try
        {
            $url = $this->entity->document->fileName->file->url;
            $name = $this->entity->document->file_name;
        }
        catch (\Exception $e)
        {
            $url = null;
        }

        if ($thumb && $url)
        {
            return '
                <a href="#" class="kallzenter-chat-telegram-document-thumb" onclick="downloadFile(\''.$url. '\', \''.$name.'\')">
                    <img class="kallzenter-chat-telegram-photo" src="' . $thumb . '" />
                </a>
                
                <p>
                    <a href="#" class="kallzenter-chat-telegram-document-name" onclick="downloadFile(\''.$url. '\', \''.$name.'\')">
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
            return '<img class="kallzenter-chat-telegram-photo" src="' . $thumb . '" data-image-large="' . $big . '" onclick="showImageModal(this);" />';
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
        if (! is_empty_or_null($this->entity->text))
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

        if (json_decode($this->entity->audio))
        {
            return $this->makeAudioMessage();
        }

        if (json_decode($this->entity->voice))
        {
            return $this->makeVoiceMessage();
        }

        if (json_decode($this->entity->video))
        {
            return $this->makeVideoMessage();
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
