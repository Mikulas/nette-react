<?php

namespace ReactNette\Application\UI;


abstract class Presenter extends \Nette\Application\UI\Presenter
{
	public function startup()
	{
		echo "startup\n";
		dump($this->getApplication()->getRouter());
	}

}
