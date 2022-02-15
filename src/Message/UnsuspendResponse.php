<?php
namespace Mahtab2003\Mofh\Message;

class UnsuspendResponse extends AbstractResponse
{
    protected $status;

    protected function parseResponse()
    {
        parent::parseResponse();

        $matches = [];

        if (!$this->isSuccessful()) {
            if (preg_match('/account is NOT currently suspended \(status : (\w*) \)/', $this->getMessage(), $matches)) {
                if (trim($matches[1]) == '') {
                    $this->status = 'd';
                } else {
                    $this->status = trim($matches[1]);
                }
            }
        }
    }

    public function getStatus()
    {
        return $this->status;
    }
}