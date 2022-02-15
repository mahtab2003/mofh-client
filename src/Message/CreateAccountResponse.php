<?php
namespace Mahtab2003\Mofh\Message;

class CreateAccountResponse extends AbstractResponse
{
    public function getVpUsername()
    {
        if (isset($this->getData()['result']['options']['vpusername'])) {
            return $this->getData()['result']['options']['vpusername'];
        } else {
            return null;
        }
    }
}