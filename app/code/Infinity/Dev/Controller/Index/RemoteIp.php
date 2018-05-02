<?php

namespace Infinity\Dev\Controller\Index;

class RemoteIp extends \Magento\Framework\App\Action\Action {

    public function execute()
    {
        /* @var $remoteAddress \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress */
        $remoteAddress = $this->_objectManager->get( 'Magento\Framework\HTTP\PhpEnvironment\RemoteAddress' );
        exit( $remoteAddress->getRemoteAddress() );
    }

}
