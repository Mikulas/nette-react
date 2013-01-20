<?php

namespace ReactNette\Http;

class Response extends \Nette\Object implements \Nette\Http\IResponse
{

	protected $res;

	protected $headers = [];

	protected $code = 200;



	public function setResponse($res)
	{
		$this->headers = []; // reset
		$this->res = $res;
	}

	public function setCode($code)
	{
		switch ($code) {
			case 100: $s = 'Continue'; break;
			case 101: $s = 'Switching Protocols'; break;
			case 200: $s = 'OK'; break;
			case 201: $s = 'Created'; break;
			case 202: $s = 'Accepted'; break;
			case 203: $s = 'Non-Authoritative Information'; break;
			case 204: $s = 'No Content'; break;
			case 205: $s = 'Reset Content'; break;
			case 206: $s = 'Partial Content'; break;
			case 300: $s = 'Multiple Choices'; break;
			case 301: $s = 'Moved Permanently'; break;
			case 302: $s = 'Moved Temporarily'; break;
			case 303: $s = 'See Other'; break;
			case 304: $s = 'Not Modified'; break;
			case 305: $s = 'Use Proxy'; break;
			case 400: $s = 'Bad Request'; break;
			case 401: $s = 'Unauthorized'; break;
			case 402: $s = 'Payment Required'; break;
			case 403: $s = 'Forbidden'; break;
			case 404: $s = 'Not Found'; break;
			case 405: $s = 'Method Not Allowed'; break;
			case 406: $s = 'Not Acceptable'; break;
			case 407: $s = 'Proxy Authentication Required'; break;
			case 408: $s = 'Request Time-out'; break;
			case 409: $s = 'Conflict'; break;
			case 410: $s = 'Gone'; break;
			case 411: $s = 'Length Required'; break;
			case 412: $s = 'Precondition Failed'; break;
			case 413: $s = 'Request Entity Too Large'; break;
			case 414: $s = 'Request-URI Too Large'; break;
			case 415: $s = 'Unsupported Media Type'; break;
			case 500: $s = 'Internal Server Error'; break;
			case 501: $s = 'Not Implemented'; break;
			case 502: $s = 'Bad Gateway'; break;
			case 503: $s = 'Service Unavailable'; break;
			case 504: $s = 'Gateway Time-out'; break;
			case 505: $s = 'HTTP Version not supported'; break;
			default: throw new InvalidArgumentException('Unknown http status code `$code`.');
		}
		$this->code = $code;
		$this->setHeader('Status', "$code $s");
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setHeader($name, $value)
	{
		$this->headers[$name] = $value;
	}

	public function addHeader($name, $value)
	{
		$this->setHeader($name, $value);
	}

	public function setContentType($type, $charset = NULL)
	{
		$this->setHeader('Content-Type', $charset ? "$type; charset=$charset" : $type);
	}

	public function redirect($url, $code = Nette\Http\IResponse::S302_FOUND)
	{
		$this->setHeader("Location", $url);
		if ($code) {
			$this->setCode($code);
		}
	}

	public function setExpiration($seconds)
	{
		
	}

	public function isSent()
	{
		
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function setCookie($name, $value, $expire, $path = NULL, $domain = NULL, $secure = NULL, $httpOnly = NULL)
	{
		
	}

	public function deleteCookie($name, $path = NULL, $domain = NULL, $secure = NULL)
	{
		
	}

	public function removeDuplicateCookies()
	{
		// @TODO implement
	}

}
