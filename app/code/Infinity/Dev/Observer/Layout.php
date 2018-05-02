<?php
namespace Infinity\Dev\Observer;

use Magento\Framework\Event\ObserverInterface;

class Layout implements ObserverInterface
{
    protected $_logger;

    public function __construct ( \Psr\Log\LoggerInterface $logger) {
        $this->_logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(isset($_GET['debug']) && $_GET['debug'] == 'layout') {
            /* @var $layout \Magento\Framework\View\Layout */
            $layout = $observer->getEvent()->getLayout();
            $xml = $layout->getXmlString();
            //unlink(BP . '/var/log/layout_block.xml');
            header('Content-Disposition: attachment; filename="layout.xml"');
            echo $xml;
            exit;
        }
        return $this;
    }
}