<?php
namespace Custom\HelloWorld\Controller\Test;

class Forward extends \Magento\Framework\App\Action\Action
{
	public function execute()
	{
        //_forward($action, $controller = null, $module = null, array $params = null)
	    $this->_forward('index', 'index', 'helloworld', null);
	}
}