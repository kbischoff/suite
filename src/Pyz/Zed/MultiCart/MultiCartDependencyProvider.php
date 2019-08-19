<?php


namespace Pyz\Zed\MultiCart;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MultiCart\MultiCartDependencyProvider as SprykerMultiCartDependencyProvider;


class MultiCartDependencyProvider extends SprykerMultiCartDependencyProvider
{
    public const FACADE_COMPANY = 'MultiCart:FACADE_COMPANY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addCompanyFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY] = function (Container $container) {
            return $container->getLocator()->company()->facade();
        };

        return $container;
    }
}
