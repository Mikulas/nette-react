<?php

namespace ReactNette\Http;

use ReactNette\Http\UrlScript;


class Request extends \Nette\Object implements \Nette\Http\IRequest
{

	/** @var \React\Http\Request */
	protected $req;

	/** @var mixed[] */
	protected $post;



	public function setRequest(\React\Http\Request $request)
	{
		$this->req = $request;
	}

	public function getUrl()
	{
		return new UrlScript($this->req);
	}

	public function getQuery($key = NULL, $default = NULL)
	{
		return $this->req->getQuery($key, $default);
	}

	public function getPostData()
	{
		// @TODO check if POST else NULL
		return $this->req->postData;
	}

	public function getPost($key = NULL, $default = NULL)
	{
		if ($this->post === NULL) {
			$this->post = [];
			parse_str($this->req->postData, $this->post);
		}

		if (func_num_args() === 0) {
			return $this->post;

		} elseif (isset($this->post[$key])) {
			return $this->post[$key];

		} else {
			return $default;
		}
	}

	public function getFile($key)
	{
		// @TODO implement
	}

	public function getFiles()
	{
		// @TODO implement
		return [];
	}

	public function getCookie($key, $default = NULL)
	{

		// @TODO implement
	}

	public function getCookies()
	{
		// @TODO implement
	}

	public function getMethod()
	{
		return strToLower($this->req->getMethod());
	}

	public function isMethod($method)
	{
		return $this->getMethod() === strToLower($method);
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
