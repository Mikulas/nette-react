<?php

//namespace App;


class HomepagePresenter extends BasePresenter
{

	/** @persistent */
	public $number;


	public function renderDefault()
	{
		echo "render default\n";
		$this->getHttpResponse()->addHeader('X-Test-' . mt_rand(), mt_rand());
		$this->template->var = mt_rand(1e3, 1e4-1);
		$this->template->number = $this->number;
	}

}
