<?php
namespace Mahtab2003\Mofh\Message;

class PasswordResponse extends AbstractResponse
{
    protected $status;

    protected function parseResponse()
    {
        parent::parseResponse();

        if (!$this->isSuccessful()) {
            $matches = [];
            if (preg_match('/the account must be active to change the password\s+\((.+)\)/', $this->getMessage(), $matches)) {
                $this->status = $matches[1];
            }
        }
    }

    public function getMessage()
    {
        if ($this->getData() && isset($this->getData()['passwd']['statusmsg'])) {
            return trim($this->getData()['passwd']['statusmsg']);
        } else {
            return trim($this->response->getBody());
        }
    }

    public function isSuccessful()
    {
        if ($this->getData() && isset($this->getData()['passwd']['status']) && $this->getData()['passwd']['status'] == 1) {
            return true;
        } elseif (strpos($this->getMessage(), 'error occured changing this password') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function getStatus()
    {
        return $this->status;
    }
}