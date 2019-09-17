<?php

namespace Elastomatic\SortCatalogWidget\Plugin;

use \Magento\Framework\DB\Select;

class AfterCreateCollection
{
    public function aftercreateCollection($subject, $result)
    {
        /**
         * @var \Magento\Catalog\Model\ResourceModel\Product\Collection $result
         * @var \Magento\CatalogWidget\Block\Product\ProductsList $subject
         */

        // reset any previous sortings
        $result->getSelect()->reset(\Zend_Db_Select::ORDER);

        // if there's a sort_by attribute defined, add a sort to the collection
        if ($subject->hasData('sort_by')) {

            // if there's a direction given, check and use that otherwise  use the default
            $direction = strtoupper($subject->getData('sort_direction'));
            if (!in_array($direction, [Select::SQL_DESC, Select::SQL_ASC])) {
                $direction = Select::SQL_DESC;
            }

            $result->setOrder($subject->getData('sort_by'), $direction)->load();
        }

        // additionally sort by created at after attribute/position
        $result->getSelect()->order('created_at ' . Select::SQL_DESC);

        return $result;
    }
}