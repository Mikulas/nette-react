<?php

//namespace App;


class HomepagePresenter extends BasePresenter
{

	/** @persistent */
	public $number;


	public function renderDefault($message = NULL)
	{
		echo "render default\n";
		$this->getHttpResponse()->addHeader('X-Test-' . mt_rand(), mt_rand());
		$this->template->var = mt_rand(1e3, 1e4-1);
		$this->template->number = $this->number;
		$this->template->message = $message;
	}



	public function createComponentTestForm()
	{
		$form = new \Nette\Application\UI\Form();

		$form->addText('text', 'Text');

		$form->addSubmit('send', 'Send');
		$form->onSuccess[] = callback($this, 'onSuccessTestForm');

		return $form;
	}



	public function onSuccessTestForm($form)
	{
		$v = $form->getValues();
		//$this->flashMessage($v['text']); // @TODO add cookie support
		dump($v['text']);
		$this->redirect('this', ['message' => $v['text']]);
	}

}
