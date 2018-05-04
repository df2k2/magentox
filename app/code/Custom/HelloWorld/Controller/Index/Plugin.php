<?php

namespace Custom\HelloWorld\Controller\Index;

class Plugin extends \Magento\Framework\App\Action\Action
{

	protected $title;

	public function execute()
	{
		$this->setTitle('Welcome');
		echo $this->getTitle();
	}

	public function setTitle($title)
	{
        echo __METHOD__ . '<br/>';
		return $this->title = $title;
	}

	public function getTitle()
	{
        echo __METHOD__ . '<br/>';
		return $this->title;
	}
}