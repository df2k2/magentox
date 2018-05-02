<?php

namespace Infinity\Dev\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Psr\Log\LoggerInterface;

class Index extends Action {

    protected $_logger;
    protected $_productResource;

    public function __construct( ProductResource $productResource, LoggerInterface $logger, Context $context )
    {
        parent::__construct( $context );

        $this->_logger = $logger;
        $this->_productResource = $productResource;
    }

    protected function _traceResource( $function )
    {
        $startTime = microtime( true );
        $memory = memory_get_usage( false );

        $function();

        $usedTime = microtime( true ) - $startTime;
        $usedMemory = ( microtime( true ) - $memory ) / 1024;

        $this->_logger->alert( sprintf( 'Used time: %.3f s', $usedTime ) );
        $this->_logger->alert( sprintf( 'Used memory: %.3f k', $usedMemory ) );
        $this->_logger->alert( '' );
    }

    public function execute()
    {
        $this->_traceResource( function() {
            $products = $this->_objectManager->create( 'Magento\Catalog\Model\ResourceModel\Product\Collection' )->addAttributeToSelect( 'category_ids' );
            foreach ( $products as $product ) {
                $categoryIds = $this->_productResource->getCategoryIds( $product );
                if ( empty( $categoryIds ) ) {
                    continue;
                }
            }
        } );

        exit;
    }

}
