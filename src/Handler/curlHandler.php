<?php 
namespace Mahtab2003\Mofh\Handler;
use Mahtab2003\Mofh\Exception\InvalidRequestException;

class curlHandler
{
	protected $ch;
	protected $raw;
	protected $code;
	protected $errNo;
	protected $errMsg;
	protected $result;

	public function prepare(string $uri, string $type = 'POST', array $data)
	{
		$this->ch = curl_init();
		if(strtolower($type) == 'post')
		{
			curl_setopt($this->ch, CURLOPT_URL, $uri);
			curl_setopt($this->ch, CURLOPT_POST, true);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
		}
		else
		{
			curl_setopt($this->ch, CURLOPT_URL, $uri.'?'.http_build_query($data));
			curl_setopt($this->ch, CURLOPT_POST, false);
		}
		curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/1.0 (PHP '.phpversion().')');
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
	}

	public function auth(string $username, string $password)
	{
		if(isset($this->ch))
		{
			curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($this->ch, CURLOPT_USERPWD, $username.':'.$password);
		}
		else
		{
			throw new InvalidRequestException("curl request is not set yet!", 1);
		}
	}

	public function verifyPeer(bool $status = true)
	{
		if(isset($this->ch))
		{
			if($status == false)
			{
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
			}
			else
			{
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, true);
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, true);
			}
		}
		else
		{
			throw new InvalidRequestException("curl request is not set yet!", 1);
		}
	}

	public function run()
	{
		if(isset($this->ch))
		{
			$this->result = curl_exec($this->ch);
			$this->errNo = curl_errno($this->ch);
			$this->errMsg = curl_error($this->ch);
			$this->raw = curl_getinfo($this->ch);
			$this->code = $this->raw['http_code'];
			curl_close($this->ch);
			return $this->result;
		}
		else
		{
			throw new InvalidRequestException("curl request is not set yet!", 1);
		}
	}

	public function getRawResponse()
	{
		if(isset($this->raw))
		{
			return $this->raw;
		}
		else
		{
			throw new InvalidRequestException("curl request is not sent!", 1);
		}
	}

	public function getResponseCode()
	{
		if(isset($this->code))
		{
			return $this->code;
		}
		else
		{
			throw new InvalidRequestException("curl request is not sent!", 1);
		}
	}

	public function getErrorMessage()
	{
		if(isset($this->errMsg))
		{
			return $this->errMsg;
		}
		else
		{
			throw new InvalidRequestException("curl request is not sent!", 1);
		}
	}

	public function getErrorCode()
	{
		if(isset($this->errNo))
		{
			return $this->errNo;
		}
		else
		{
			throw new InvalidRequestException("curl request is not sent!", 1);
		}
	}
}
?>
