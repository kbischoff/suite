<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Application;

use Spryker\Shared\Application\ServiceProvider\FormFactoryServiceProvider;
use Spryker\Zed\Api\Communication\Plugin\ApiServiceProviderPlugin;
use Spryker\Zed\Api\Communication\Plugin\ServiceProvider\ApiRoutingServiceProvider;
use Spryker\Zed\Application\ApplicationDependencyProvider as SprykerApplicationDependencyProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\SubRequestServiceProvider;
use Spryker\Zed\Assertion\Communication\Plugin\ServiceProvider\AssertionServiceProvider;
use Spryker\Zed\ErrorHandler\Communication\Plugin\Application\ErrorHandlerApplicationPlugin;
use Spryker\Zed\EventDispatcher\Communication\Plugin\Application\EventDispatcherApplicationPlugin;
use Spryker\Zed\Gui\Communication\Plugin\ServiceProvider\FormTypeExtensionServiceProvider;
use Spryker\Zed\Gui\Communication\Plugin\ServiceProvider\GuiTwigExtensionServiceProvider;
use Spryker\Zed\Http\Communication\Plugin\Application\HttpApplicationPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Locale\Communication\Plugin\Application\LocaleApplicationPlugin;
use Spryker\Zed\Messenger\Communication\Plugin\Application\MessengerApplicationPlugin;
use Spryker\Zed\Propel\Communication\Plugin\Application\PropelApplicationPlugin;
use Spryker\Zed\Router\Communication\Plugin\Application\RouterApplicationPlugin;
use Spryker\Zed\Session\Communication\Plugin\Application\SessionApplicationPlugin;
use Spryker\Zed\Translator\Communication\Plugin\Application\TranslatorApplicationPlugin;
use Spryker\Zed\Twig\Communication\Plugin\Application\TwigApplicationPlugin;
use Spryker\Zed\WebProfiler\Communication\Plugin\Application\WebProfilerApplicationPlugin;

class ApplicationDependencyProvider extends SprykerApplicationDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getServiceProviders(Container $container)
    {
        $coreProviders = parent::getServiceProviders($container);

        $providers = [
            new AssertionServiceProvider(),
            new SubRequestServiceProvider(),
            new FormFactoryServiceProvider(),
            new GuiTwigExtensionServiceProvider(),
            new SubRequestServiceProvider(),
            new FormTypeExtensionServiceProvider(),
        ];

        $providers = array_merge($providers, $coreProviders);

        return $providers;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getApiServiceProviders(Container $container)
    {
        $providers = [
            // Add Auth service providers
            new ApiServiceProviderPlugin(),
            new ApiRoutingServiceProvider(),
        ];

        return $providers;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getInternalCallServiceProvidersWithAuthentication(Container $container)
    {
        return [
            new SubRequestServiceProvider(),
        ];
    }

    /**
     * @return \Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface[]
     */
    protected function getApplicationPlugins(): array
    {
        return [
            new TwigApplicationPlugin(),
            new EventDispatcherApplicationPlugin(),
            new LocaleApplicationPlugin(),
            new TranslatorApplicationPlugin(),
            new MessengerApplicationPlugin(),
            new PropelApplicationPlugin(),
            new RouterApplicationPlugin(),
            new WebProfilerApplicationPlugin(),
            new HttpApplicationPlugin(),
            new SessionApplicationPlugin(),
            new ErrorHandlerApplicationPlugin(),
        ];
    }
}
