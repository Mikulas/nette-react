<?php

namespace ReactNette\Http;


class Url extends \Nette\Http\Url
{

	/** @var React\Http\Request */
	public $req;



	public function __construct(\React\Http\Request $req)
	{
		$this->req = $req;
	}



	public function getPath()
	{
		return $this->req->getPath();
	}



	public function getScheme()
	{
		throw new \Nette\NotSupportedException();
	}



	public function getUser()
	{
		throw new \Nette\NotSupportedException();
	}



	public function getPassword()
	{
		throw new \Nette\NotSupportedException();
	}



	public function getHost()
	{
		throw new \Nette\NotSupportedException();
	}



	public function getPort()
	{
		throw new \Nette\NotSupportedException();
	}

}
