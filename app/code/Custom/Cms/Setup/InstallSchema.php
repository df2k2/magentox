<?php

namespace Cusom\Cms\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        $connection->addColumn($installer->getTable( 'cms_page' ), 'page_css', ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'comment' => 'Page Css']);
        $connection->addColumn($installer->getTable( 'cms_page' ), 'page_js', ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 'comment' => 'Page Js']);
    }

}
