<?php

namespace ReactNette\Http;


class UrlScript extends \Nette\Http\UrlScript
{

	/** @var React\Http\Request */
	public $req;



	public function __construct(\React\Http\Request $req)
	{
		$this->req = $req;

		// @TODO read from something
		$this->host = '127.0.0.1';
		$this->port = 1337;
		$this->scheme = 'http';
		$this->path = $this->req->getPath();
		$this->query = $this->req->getQuery();
	}



	public function getUser()
	{
		throw new \Nette\NotSupportedException();
	}



	public function getPassword()
	{
		throw new \Nette\NotSupportedException();
	}

}
