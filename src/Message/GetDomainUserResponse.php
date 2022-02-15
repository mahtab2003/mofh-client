<?php
namespace Mahtab2003\Mofh\Message;

class GetDomainUserResponse extends AbstractResponse
{
    protected $status = null;
    protected $domain = null;
    protected $documentRoot = null;
    protected $username = null;

    public function parseResponse()
    {
        $responseBody = $this->response->getBody();

        if (strpos($responseBody, '[') === 0) {
            $this->data = json_decode($responseBody, true);

            if ($this->data && count($this->data) == 4) {
                list($this->status, $this->domain, $this->documentRoot, $this->username) = $this->data;
            }
        } elseif ($responseBody === 'null') {
            $this->data = null;
        } else {
            $this->data = $responseBody;
        }
    }

    public function getMessage()
    {
        return $this->isSuccessful() ? null : $this->getData();
    }

    public function isSuccessful()
    {
        return $this->data === null || is_array($this->data);
    }

    public function isFound()
    {
        return $this->data != null;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDocumentRoot()
    {
        return $this->documentRoot;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
}
