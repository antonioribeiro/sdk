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
        return '<img class="kallzenter-chat-telegram-photo" src="' . asset('assets/images/chat/spiner.gif') . '" />';
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

    private function makeThumb($mime_type)
    {
        if ($mime_type == 'application/pdf')
        {
            return asset('assets/images/chat/pdf.png');
        }

        if ($mime_type == 'application/avi')
        {
            return asset('assets/images/chat/avi.png');
        }

        if ($mime_type == 'application/css')
        {
            return asset('assets/images/chat/css.png');
        }

        if ($mime_type == 'application/doc' || $mime_type == 'application/docx')
        {
            return asset('assets/images/chat/doc.png');
        }

        if ($mime_type == 'application/eps')
        {
            return asset('assets/images/chat/eps.png');
        }

        if ($mime_type == 'application/fla')
        {
            return asset('assets/images/chat/fla.png');
        }

        if ($mime_type == 'application/flv')
        {
            return asset('assets/images/chat/flv.png');
        }

        if ($mime_type == 'application/gif')
        {
            return asset('assets/images/chat/gif.png');
        }

        if ($mime_type == 'application/html')
        {
            return asset('assets/images/chat/html.png');
        }

        if ($mime_type == 'application/jpg')
        {
            return asset('assets/images/chat/jpg.png');
        }

        if ($mime_type == 'application/mdb')
        {
            return asset('assets/images/chat/mdb.png');
        }

        if ($mime_type == 'application/mid')
        {
            return asset('assets/images/chat/mid.png');
        }

        if ($mime_type == 'application/mov')
        {
            return asset('assets/images/chat/mov.png');
        }

        if ($mime_type == 'application/mp3')
        {
            return asset('assets/images/chat/mp3.png');
        }

        if ($mime_type == 'application/mpg')
        {
            return asset('assets/images/chat/mpg.png');
        }

        if ($mime_type == 'application/ogg')
        {
            return asset('assets/images/chat/ogg.png');
        }

        if ($mime_type == 'application/pdf')
        {
            return asset('assets/images/chat/pdf.png');
        }

        if ($mime_type == 'application/pdf')
        {
            return asset('assets/images/chat/pdf.png');
        }

        if ($mime_type == 'application/php')
        {
            return asset('assets/images/chat/php.png');
        }

        if ($mime_type == 'application/ppt')
        {
            return asset('assets/images/chat/ppt.png');
        }

        if ($mime_type == 'application/psd')
        {
            return asset('assets/images/chat/psd.png');
        }

        if ($mime_type == 'application/txt')
        {
            return asset('assets/images/chat/txt.png');
        }

        if ($mime_type == 'application/wav')
        {
            return asset('assets/images/chat/wav.png');
        }

        if ($mime_type == 'application/wmv')
        {
            return asset('assets/images/chat/wmv.png');
        }

        if ($mime_type == 'application/xls' || $mime_type == 'application/xlsx')
        {
            return asset('assets/images/chat/xls.png');
        }

        if ($mime_type == 'application/xml')
        {
            return asset('assets/images/chat/xml.png');
        }

        if ($mime_type == 'application/zip')
        {
            return asset('assets/images/chat/zip.png');
        }

        return asset('assets/images/chat/file.png');
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
