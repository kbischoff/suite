<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductCategoryFilterStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductCategoryFilterStorage\ProductCategoryFilterStorageConfig as SprykerProductCategoryFilterStorageConfig;

class ProductCategoryFilterStorageConfig extends SprykerProductCategoryFilterStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductCategoryFilterSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getProductCategoryFilterEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
