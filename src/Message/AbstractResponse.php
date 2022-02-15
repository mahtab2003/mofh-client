<?php 
namespace Mahtab2003\Mofh\Message;

abstract class AbstractResponse
{
    protected $request;
    protected $data;
    protected $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->parseResponse();
    }

    protected function parseResponse()
    {
        $data = (string)$this->response;

        if(strpos(trim($data), '<') !== 0){
            $this->data = null;
        } else {
            $this->data = $this->xmlToArray((array)simplexml_load_string($data));
        }
    }

    public function getData()
    {
        return $this->data;
    }

    protected function xmlToArray($input)
    {
        foreach ($input as $key => $value) {
            if ($value instanceof \SimpleXMLElement) {
                $value = (array)$value;
            }

            if (is_array($value)) {
                $input[$key] = $this->xmlToArray($value);
            }
        }

        return $input;
    }

    public function getMessage()
    {
        if ($this->getData() && isset($this->getData()['result']['statusmsg'])) {
            return trim($this->getData()['result']['statusmsg']);
        } else {
            return (string)trim($this->response->getBody());
        }
    }

    public function isSuccessful()
    {
        if ($this->getData() && isset($this->getData()['result']['status'])) {
            return $this->getData()['result']['status'] == 1;
        } else {
            return false;
        }
    }
}
?>