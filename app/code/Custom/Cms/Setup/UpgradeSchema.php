<?php
namespace Custom\Cms\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;

		$installer->startSetup();

		if(version_compare($context->getVersion(), '1.0.1', '<')) {

			$connection = $installer->getConnection();

			$connection->addColumn($installer->getTable( 'cms_page' ), 'page_css', ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'comment' => 'Page Css']);
			$connection->addColumn($installer->getTable( 'cms_page' ), 'page_js', ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'comment' => 'Page Js']);
		}



		$installer->endSetup();
	}
}