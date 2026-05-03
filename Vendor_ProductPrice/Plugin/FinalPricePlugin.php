<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Vendor\ProductPrice\Plugin;

class FinalPricePlugin
{

    public function afterAfterGetValue(
        \FinalPricePlugin $subject,
        $result,
        //$functionParam
    ) {
        //Your plugin code
        return $result;
    }
}

