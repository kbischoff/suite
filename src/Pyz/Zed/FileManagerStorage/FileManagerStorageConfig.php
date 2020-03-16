<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\FileManagerStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\FileManagerStorage\FileManagerStorageConfig as SprykerFileManagerStorageConfig;

class FileManagerStorageConfig extends SprykerFileManagerStorageConfig
{
    /**
     * @return string|null
     */
    public function getFileManagerSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getFileManagerEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
