<?php
namespace Mahtab2003\Mofh\Message;

class AvailabilityResponse extends AbstractResponse
{

    public function parseResponse()
    {
        $this->data = $this->response;
    }

    public function getMessage()
    {
        return $this->getData();
    }

    public function isSuccessful()
    {
        return $this->data === '1';
    }
}
