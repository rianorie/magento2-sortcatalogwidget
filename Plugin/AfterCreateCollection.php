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

        // if there's a sort_by attribute defined, add a sort to the collection
        if ($subject->hasData('sort_by')) {

            // if there's a direction given, check and use that otherwise  use the default
            $direction = strtoupper($subject->getData('sort_direction'));
            if (!in_array($direction, [Select::SQL_DESC, Select::SQL_ASC])) {
                $direction = Select::SQL_DESC;
            }

            $result->setOrder($subject->getData('sort_by'), $direction);
        }

        return $result;
    }
}