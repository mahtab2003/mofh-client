<?php
namespace Mahtab2003\Mofh\Message;

class SuspendResponse extends AbstractResponse
{
    protected $info;

    protected function parseResponse()
    {
        parent::parseResponse();

        if (!$this->isSuccessful()) {
            $matches = [];
            if (preg_match('/account is not active so can not be suspended\s+\((.+)\)/', $this->getMessage(), $matches)) {
                list($fullMatch, $infoString) = $matches;
                $attributes = explode(',', $infoString, 3);
                $this->info = [];

                foreach ($attributes as $attribute) {
                    list($key, $value) = explode(':', $attribute, 2);
                    $this->info[trim($key)] = trim($value);
                }
            }
        }
    }

    public function getStatus()
    {
        return isset($this->info['status']) ? $this->info['status'] : null;
    }

    public function getVpUsername()
    {
        return isset($this->info['vPuser']) ? $this->info['vPuser'] : null;
    }
    
    public function getReason()
    {
        return isset($this->info['reason']) ? $this->info['reason'] : null;
    }
}