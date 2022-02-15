<?php 
namespace Mahtab2003\Mofh\Message;

class DeleteAccountRequest extends AbstractRequest
{
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('removeacct', $data);
        return $this->response = new DeleteAccountResponse($this, $httpResponse);
    }
    public function getData()
    {
        $this->validate('apiUsername', 'apiPassword', 'apiUrl', 'username');

        return [
            'api_user' => $this->getApiUsername(),
            'api_key' => $this->getApiPassword(),
            'user' => $this->getUsername(),
        ];
    }
}
?>