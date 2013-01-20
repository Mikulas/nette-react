<?php

namespace ReactNette\Http;

use Nette\Http\UrlScript;


class Request extends \Nette\Object implements \Nette\Http\IRequest
{

	/** @var \React\Http\Request */
	protected $req;



	public function __construct(\React\Http\Request $request)
	{
		$this->req = $request;
	}

	public function getUrl()
	{
		return new Url($this->req);
	}

	public function getQuery($key = NULL, $default = NULL)
	{
		return $this->req->getQuery($key, $default);
	}

	public function getPost($key = NULL, $default = NULL)
	{
		return []; // @TODO implement
	}

	public function getFile($key)
	{
		
	}

	public function getFiles()
	{
		return []; // @TODO implement
	}

	public function getCookie($key, $default = NULL)
	{
		
	}

	public function getCookies()
	{
		
	}

	public function getMethod()
	{
		return $this->req->getMethod();
	}

	public function isMethod($method)
	{
		return strToLower($this->getMethod()) === strToLower($method);
	}

	public function getHeader($header, $default = NULL)
	{
		$headers = $this->getHeaders();

		if ($default) {
			return isset($headers[$header]) ? $headers[$header] : $default;
		} else {
			return $headers[$header];
		}
	}

	public function getHeaders()
	{
		return $this->req->getHeaders();
	}

	public function isSecured()
	{
		
	}

	public function isAjax()
	{
		
	}

	public function getRemoteAddress()
	{
		
	}

	public function getRemoteHost()
	{
		
	}

}
