<?php

namespace Custom\HelloWorld\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Custom\HelloWorld\Model\PostFactory;



class UpgradeData implements UpgradeDataInterface
{
	protected $_postFactory;
	private $eavSetupFactory;

	public function __construct(PostFactory $postFactory, EavSetupFactory $eavSetupFactory, Config $eavConfig)
	{
		$this->_postFactory = $postFactory;
		$this->eavSetupFactory = $eavSetupFactory;
		$this->eavConfig       = $eavConfig;
	}

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{

		if (version_compare($context->getVersion(), '1.3.0', '<')) {
			$data = [
				'name'         => "Magento 2 Events",
				'post_content' => "This article will talk about Events List in Magento 2. As you know, Magento 2 is using the events driven architecture which will help too much to extend the Magento functionality. We can understand this event as a kind of flag that rises when a specific situation happens. We will use an example module Custom_HelloWorld to exercise this lesson.",
				'url_key'      => '/magento-2-module-development/magento-2-events.html',
				'tags'         => 'magento 2,custom helloworld',
				'status'       => 1
			];
			$post = $this->_postFactory->create();
			$post->addData($data)->save();
		}

		if (version_compare($context->getVersion(), '1.4.0', '<')) {
			$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
			$eavSetup->addAttribute(
				\Magento\Customer\Model\Customer::ENTITY,
				'sample_attribute',
				[
					'type'         => 'varchar',
					'label'        => 'Sample Attribute',
					'input'        => 'text',
					'required'     => false,
					'visible'      => true,
					'user_defined' => true,
					'position'     => 999,
					'system'       => 0,
				]
			);
			//删除 customer attr
			// $eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sample_attribute');

			$sampleAttribute = $this->eavConfig->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'sample_attribute');

			// more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
			$sampleAttribute->setData(
				'used_in_forms',
				['adminhtml_customer', 'customer_account_edit']

			);
			$sampleAttribute->save();
		}


		if (version_compare($context->getVersion(), '1.5.0', '<')) {
			$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
			// 添加product attr
			$eavSetup->addAttribute(
				\Magento\Catalog\Model\Product::ENTITY,
				'sample_attribute',
				[
					'type' => 'text',
					'backend' => '',
					'frontend' => '',
					'label' => 'Sample Atrribute',
					'input' => 'text',
					'class' => '',
					'source' => '',
					'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
					'visible' => true,
					'required' => true,
					'user_defined' => false,
					'default' => '',
					'searchable' => false,
					'filterable' => false,
					'comparable' => false,
					'visible_on_front' => false,
					'used_in_product_listing' => true,
					'unique' => false,
					'apply_to' => ''
				]
			);
			//删除 product attr
			// $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'sample_attribute');
		}


		if (version_compare($context->getVersion(), '1.6.0', '<')) {
			$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
			$eavSetup->addAttribute(
				\Magento\Catalog\Model\Category::ENTITY,
				'cs_new_attribute',
				[
					'type'         => 'varchar',
					'label'        => 'Custom Attribute',
					'input'        => 'text',
					'sort_order'   => 100,
					'source'       => '',
					'global'       => 1,
					'visible'      => true,
					'required'     => false,
					'user_defined' => false,
					'default'      => null,
					'group'        => '',
					'backend'      => ''
				]
			);
		}
	}
}
