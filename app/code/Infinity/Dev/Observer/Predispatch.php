<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 2016/12/17
 * Time: 13:40
 */

namespace Infinity\Dev\Observer;


class Predispatch implements \Magento\Framework\Event\ObserverInterface
{
    private $eventManager;

    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager
    ) {
        $this->eventManager = $eventManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        if(isset($_GET['debug']) && $_GET['debug'] == 'mail') {
            $this->testMail();
        }

        if(isset($_GET['debug']) && $_GET['debug'] == 'route') {
            $request = $observer->getEvent()->getData('request');
            if($request instanceof \Magento\Framework\App\RequestInterface) {
                echo 'Module: ';
                echo $request->getModuleName();
                echo '<br/>';
                echo 'Controller: ';
                echo $request->getControllerName();
                echo '<br/>';
                echo 'Action: ';
                echo $request->getActionName();
                exit();
            }
        }
    }

    private function testMail() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /* @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);
        $storeId = !empty($_GET['store_id']) ? $_GET['store_id']:$storeManager->getStore()->getId();
        $emailIdentity = $_GET['email_identity'];
        $customerId = !empty($_GET['customer_id']) ? $_GET['customer_id']:20;
        $orderId = !empty($_GET['order_id']) ? $_GET['order_id']:170;

        $this->_storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
        /* @var \Magento\Sales\Model\Order $order */
        $order = $objectManager->get('Magento\Sales\Model\Order');
        $this->_scopeConfig = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');

        $vars = [];
        $addressRenderer = $objectManager->get('Magento\Sales\Model\Order\Address\Renderer');

        // order mail (order_id)
        if(in_array($emailIdentity, [
            'sales_email_order_template',
            'sales_email_order_guest_template'
        ])) {
            $order->load($orderId);
            $paymentHelper = $objectManager->get('Magento\Payment\Helper\Data');
            $vars = [
                'order' => $order,
                'billing' => $order->getBillingAddress(),
                'payment_html' => $paymentHelper->getInfoBlockHtml(
                    $order->getPayment(),
                    $storeId
                ),
                'store' => $order->getStore(),
                'formattedShippingAddress' => $addressRenderer->format($order->getShippingAddress(), 'html'),
                'formattedBillingAddress' => $addressRenderer->format($order->getBillingAddress(), 'html'),
            ];
            $transport = new \Magento\Framework\DataObject($vars);

            $this->eventManager->dispatch(
                'email_order_set_template_vars_before',
                ['sender' => $this, 'transport' => $transport]
            );
            $vars = $transport->getData();
        }

        // shipment mail
        if(in_array($emailIdentity, [
            'sales_email_shipment_template',
            'sales_email_shipment_guest_template',
            'sales_email_shipment_comment_template',
            'sales_email_shipment_comment_guest_template'
        ])) {
            $order->load($orderId);
            $paymentHelper = $objectManager->get('Magento\Payment\Helper\Data');
            foreach($order->getShipmentsCollection() as $shipment) {
                $vars = [
                    'order' => $order,
                    'shipment' => $shipment,
                    'comment' => $shipment->getCustomerNoteNotify() ? $shipment->getCustomerNote() : '',
                    'billing' => $order->getBillingAddress(),
                    'payment_html' => $paymentHelper->getInfoBlockHtml(
                        $order->getPayment(),
                        $this->_storeManager->getStore()->getId()
                    ),
                    'store' => $order->getStore(),
                    'formattedShippingAddress' => $addressRenderer->format($order->getShippingAddress(), 'html'),
                    'formattedBillingAddress' => $addressRenderer->format($order->getBillingAddress(), 'html'),
                ];
            }
        }

        // customer mail
        if(in_array($emailIdentity, ['customer_password_forgot_email_template'])) {
            $this->customerRegistry = $objectManager->get('Magento\Customer\Model\CustomerRegistry');
            $this->customerViewHelper = $objectManager->get('Magento\Customer\Helper\View');
            $this->dataProcessor = $objectManager->get('Magento\Framework\Reflection\DataObjectProcessor');
            $customerModel = $objectManager->get('Magento\Customer\Model\Customer');
            $customerModel->load($customerId);
            $customer = $customerModel->getDataModel();
            $mergedCustomerData = $this->customerRegistry->retrieveSecureData($customer->getId());
            $customerData = $this->dataProcessor
                ->buildOutputDataArray($customer, \Magento\Customer\Api\Data\CustomerInterface::class);
            $mergedCustomerData->addData($customerData);
            $mergedCustomerData->setData('name', $this->customerViewHelper->getCustomerName($customer));
            $vars = ['customer' => $mergedCustomerData, 'store' => $this->_storeManager->getStore()];
        }


        $fromBackendPath = preg_replace('/^([^_]+)_([^_]+)_(.*)$/', '$1/$2/$3', $emailIdentity);
        $fromBackendTemplate = $this->_scopeConfig->getValue($fromBackendPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
        if($fromBackendTemplate) {
            $emailIdentity = $fromBackendTemplate;
        } else {
            $fromBackendPath = preg_replace('/^([^_]+_[^_]+)_([^_]+)_([^_]+)_(.*)$/', '$1/$2/$3_$4', $emailIdentity);
            $fromBackendTemplate = $this->_scopeConfig->getValue($fromBackendPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
            if($fromBackendTemplate) {
                $emailIdentity = $fromBackendTemplate;
            }
        }
        echo 'email: '.$emailIdentity.'<br/>';
        $templateFactory = $objectManager->create(
            'Magento\Framework\Mail\TemplateInterface',
            ['data' => ['template_id' => $emailIdentity]]
        );
        $templateFactory->setOptions([
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $storeId,
        ]);
        $templateFactory->setVars($vars);
        echo $templateFactory->processTemplate();
        exit();
    }
}