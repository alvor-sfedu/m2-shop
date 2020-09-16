<?php
namespace Alvor\Shop\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->createCustomerConfirmationTable($setup);
        $setup->endSetup();
    }

    protected function createCustomerConfirmationTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable('shop'))
            ->addColumn('entity_id', Table::TYPE_INTEGER, null, [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true
            ], 'Entity Id')
            ->addColumn('text', Table::TYPE_TEXT, 100, [
                'nullable' => true,
                'unsigned' => true
            ], 'Shop text')
            ->addColumn('type', Table::TYPE_TEXT, 100, [
                'nullable' => false,
                'unsigned' => true
            ], 'Shop type')
            ->setComment('Shop');

        $setup->getConnection()->createTable($table);
    }
}
