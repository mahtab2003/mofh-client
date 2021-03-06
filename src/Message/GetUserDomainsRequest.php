<?php
namespace Mahtab2003\Mofh\Message;

class GetUserDomainsRequest extends AbstractRequest
{
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('getuserdomains', $data);

        return $this->response = new GetUserDomainsResponse($this, $httpResponse);
    }

    public function getData()
    {
        $this->validate('apiUsername', 'apiPassword', 'apiUrl', 'username');

        return [
            'api_user' => $this->getApiUsername(),
            'api_key' => $this->getApiPassword(),
            'username' => $this->getUsername(),
        ];
    }
}
