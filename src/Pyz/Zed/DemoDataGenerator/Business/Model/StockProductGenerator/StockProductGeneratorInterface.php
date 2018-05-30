<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DemoDataGenerator\Business\Model\StockProductGenerator;

interface StockProductGeneratorInterface
{
    /**
     * @return void
     */
    public function createStockProductCsvDemoData(): void;
}
