<?php
namespace Custom\HelloWorld\Controller\Index;

class Event extends \Magento\Framework\App\Action\Action
{

	public function execute()
	{
        $textDisplay = new \Magento\Framework\DataObject(array('text' => 'Custom'));
        //observer将通过 `$observer->getData('mp_text')` 获得 $textDisplay的值;
		$this->_eventManager->dispatch('custom_helloworld_display_text', ['mp_text' => $textDisplay]);
		echo 'New: ' . $textDisplay->getText();
		exit;
	}
}