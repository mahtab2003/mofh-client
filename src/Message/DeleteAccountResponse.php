<?php
namespace Mahtab2003\Mofh\Message;

class DeleteAccountResponse extends AbstractResponse
{

    public function parseResponse()
    {
        $this->data = $this->response;
    }

    public function getMessage()
    {
        return $this->isSuccessful() ? null : $this->getData();
    }

    public function isSuccessful()
    {
        if($this->getData() == 'This account is not currently suspended.  To terminate an account it must be firstly suspended. .')
        {
            return null;
        }
        elseif(strpos($this->getData(), '<') === 0)
        {
            return $this->getData();
        }
        else
        {
            return null;
        }
    }
}
