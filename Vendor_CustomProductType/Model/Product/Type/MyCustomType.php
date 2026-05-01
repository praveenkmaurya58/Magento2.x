<?php
namespace Vendor\CustomProductType\Model\Product\Type;

use Magento\Catalog\Model\Product\Type\AbstractType;

class MyCustomType extends AbstractType
{
    /**
     * Product type code
     */
    const TYPE_CODE = 'my_custom_product';

    /**
     * Delete data specific for this product type
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return void
     */
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
        // Add any specific logic needed when a product of this type is deleted.
        // For a basic product type, this can remain empty.
    }
}