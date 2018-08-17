<?php
namespace Custom\HelloWorld\Controller\Test;

class Redirect extends \Magento\Framework\App\Action\Action
{
	public function execute()
	{
        // "*/*/index"
        $this->_redirect('helloworld/index/index');
	}
}