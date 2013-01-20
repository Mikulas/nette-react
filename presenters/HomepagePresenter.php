<?php

//namespace App;


class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->var = mt_rand(1e3, 1e4-1);
	}

}
