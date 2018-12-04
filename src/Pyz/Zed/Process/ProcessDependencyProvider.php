<?php
/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Pyz\Zed\Process;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Configuration\AkeneoPimConfigurationProfilePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Configuration\DefaultAkeneoPimConfigurationProfilePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Configuration\DefaultConfigurationProfilePlugin;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider as SprykerMiddlewareProcessDependencyProvider;
class ProcessDependencyProvider extends SprykerMiddlewareProcessDependencyProvider
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected function getConfigurationProfilePluginsStack(): array
    {
        $profileStack = parent::getConfigurationProfilePluginsStack();
        $profileStack[] = new DefaultConfigurationProfilePlugin();
        $profileStack[] = new AkeneoPimConfigurationProfilePlugin();
        $profileStack[] = new DefaultAkeneoPimConfigurationProfilePlugin();
        return $profileStack;
    }
}