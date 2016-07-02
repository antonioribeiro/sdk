<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class ChatBase extends Presenter
{
    public function makeThumb($mime_type)
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

        if ($mime_type == 'application/doc' || $mime_type == 'application/docx'  || $mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
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

        if ($mime_type == 'application/xls' || $mime_type == 'application/xlsx' || $mime_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
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
}
