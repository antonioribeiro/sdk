<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Presenters;

use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatBase as ChatBasePresenter;

class FacebookMessengerMessage extends ChatBasePresenter
{
    private function defaultSpinner()
    {
        return '<img class="kallzenter-chat-facebook-messenger-photo" src="' . asset('assets/images/chat/spinner.gif') . '" />';
    }

    private function makeDocumentMessage($url)
    {
        $thumb = $this->makeThumb('application/generic');

        $name = 'baixar';

        if ($thumb && $url)
        {
            return '
                <a href="'.$url.'" class="kallzenter-chat-facebook-messenger-document-thumb" download>
                    <img class="kallzenter-chat-facebook-messenger-photo" src="' . $thumb . '" />
                </a>
                
                <p>
                    <a href="'.$url.'" class="kallzenter-chat-facebook-messenger-document-thumb" download>
                        Baixar '.$name.'
                    </a>
                </p>
            ';
        }

        return $this->defaultSpinner();
    }

    private function makeImageMessage($url)
    {
        return '<img class="kallzenter-chat-facebook-messenger-photo" src="' . $url . '" data-image-large="' . $url . '" onclick="showImageModal(this);" />';
    }

    public function message()
    {
        $message = '';

        $message = $this->getTextMessage($message);

        $message = $this->getAttachmentsMessages($message);

        if (! $message)
        {
            return $this->unrecognizedMessage();
        }

        return $message;
    }

    /**
     * @param $message
     * @return string
     */
    private function getAttachmentsMessages($message)
    {
        if ($this->entity->attachments)
        {
            $attachments = json_decode($this->entity->attachments, true);

            foreach ($attachments as $attachment)
            {
                if ($attachment['type'] == 'image')
                {
                    $message .= $this->makeImageMessage($attachment['payload']['url']);
                }
                elseif ($attachment['type'] == 'file')
                {
                    $message .= $this->makeDocumentMessage($attachment['payload']['url']);
                }
            }

            return $message;
        }

        return $message;
    }

    /**
     * @return string
     */
    private function unrecognizedMessage()
    {
        return '<p class="kallzenter-chat-facebook-messenger-warning">(ATENÇÃO: A mensagem recebida não é suportada por este sistema)</p>';
    }
}
