<?php
namespace Mahtab2003\Mofh\Message;

class SuspendRequest extends AbstractRequest
{
    public function getReason()
    {
        return $this->getParameter('reason');
    }

    public function setReason($reason)
    {
        return $this->setParameter('reason', $reason);
    }

    public function getLinked()
    {
        return $this->getParameter('linked');
    }

    public function setLinked($linked)
    {
        return $this->setParameter('linked', $linked);
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('suspendacct', $data);

        return $this->response = new SuspendResponse($this, $httpResponse);
    }

    public function getData()
    {
        $this->validate('apiUsername', 'apiPassword', 'apiUrl', 'username', 'reason');

        return [
            'api_user' => $this->getApiUsername(),
            'api_key' => $this->getApiPassword(),
            'user' => $this->getUsername(),
            'reason' => $this->getReason(),
            'linked' => $this->getLinked() ? '1' : '0',
        ];
    }
}