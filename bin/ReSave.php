<?php

use Magento\Framework\App\Bootstrap;

include 'app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('adminhtml');

$collection = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection');
$messanger = $objectManager->get('\Symfony\Component\Console\Output\ConsoleOutput');
$collection->addAttributeToFilter(
    'essenz_eigenmarke',
    [
        1, 2, 3
    ]
);
$ids = $collection->getAllIds();
$collectionForInsert = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection');
$collectionForInsert->addFieldToFilter(
    'entity_id',
    [
        'nin' => $ids
    ]
);
unset($ids);
$ids = $collectionForInsert->getAllIds();
$count = count($ids);
$connection = $objectManager->get('\Magento\Framework\App\ResourceConnection');
$connection = $connection->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
$table = $connection->getTableName('catalog_product_entity_int');
foreach ($ids as $id) {
    try {
        $connection->beginTransaction();
        $data = [
            'attribute_id' => 136,
            'store_id' => 0,
            'entity_id' => $id,
            'value' => 0,
        ];
        $connection->insert($table, $data);
        $connection->commit();
        $messanger->writeln('Product saved - ' . $id . PHP_EOL .  $count-- . ' left');
    } catch (\Exception $e) {
        $connection->rollBack();
        $messanger->writeln('ERROR IN  - ' . $id . PHP_EOL .  $count-- . ' left');
    }
}
