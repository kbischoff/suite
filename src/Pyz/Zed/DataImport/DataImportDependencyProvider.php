<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport;

use Pyz\Zed\DataImport\Communication\Plugin\ProductAbstract\ProductAbstractBulkPdoWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductConcrete\ProductConcreteBulkPdoWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductConcrete\ProductConcretePropelWriterPlugin;
use Spryker\Zed\CategoryDataImport\Communication\Plugin\CategoryDataImportPlugin;
use Spryker\Zed\CompanyBusinessUnitDataImport\Communication\Plugin\CompanyBusinessUnitDataImportPlugin;
use Spryker\Zed\CompanyDataImport\Communication\Plugin\CompanyDataImportPlugin;
use Spryker\Zed\CompanyUnitAddressDataImport\Communication\Plugin\CompanyUnitAddressDataImportPlugin;
use Spryker\Zed\CompanyUnitAddressLabelDataImport\Communication\Plugin\CompanyUnitAddressLabelDataImportPlugin;
use Spryker\Zed\CompanyUnitAddressLabelDataImport\Communication\Plugin\CompanyUnitAddressLabelRelationDataImportPlugin;
use Spryker\Zed\DataImport\Communication\Plugin\DataImportEventBehaviorPlugin;
use Spryker\Zed\DataImport\Communication\Plugin\DataImportPublisherPlugin;
use Spryker\Zed\DataImport\DataImportDependencyProvider as SprykerDataImportDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DataImportDependencyProvider extends SprykerDataImportDependencyProvider
{
    const FACADE_AVAILABILITY = 'availability facade';
    const FACADE_CATEGORY = 'category facade';
    const FACADE_PRODUCT_BUNDLE = 'product bundle facade';
    const FACADE_PRODUCT_RELATION = 'product relation facade';
    const FACADE_PRODUCT_SEARCH = 'product search facade';
    const DATA_IMPORT_PRODUCT_ABSTRACT_WRITER_PLUGINS = 'DATA_IMPORT_PRODUCT_ABSTRACT_WRITER_PLUGINS';
    const DATA_IMPORT_PRODUCT_CONCRETE_WRITER_PLUGINS = 'DATA_IMPORT_PRODUCT_CONCRETE_WRITER_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addAvailabilityFacade($container);
        $container = $this->addCategoryFacade($container);
        $container = $this->addProductBundleFacade($container);
        $container = $this->addProductRelationFacade($container);
        $container = $this->addProductSearchFacade($container);
        $container = $this->addDataImportProductAbstractWriterPlugins($container);
        $container = $this->addDataImportProductConcreteWriterPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAvailabilityFacade(Container $container)
    {
        $container[static::FACADE_AVAILABILITY] = function (Container $container) {
            return $container->getLocator()->availability()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryFacade(Container $container)
    {
        $container[static::FACADE_CATEGORY] = function (Container $container) {
            return $container->getLocator()->category()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductBundleFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT_BUNDLE] = function (Container $container) {
            return $container->getLocator()->productBundle()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductSearchFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT_SEARCH] = function (Container $container) {
            return $container->getLocator()->productSearch()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductRelationFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT_RELATION] = function (Container $container) {
            return $container->getLocator()->productRelation()->facade();
        };

        return $container;
    }

    /**
     * @return array
     */
    protected function getDataImporterPlugins(): array
    {
        return [
            [new CategoryDataImportPlugin(), DataImportConfig::IMPORT_TYPE_CATEGORY_TEMPLATE],
            new CompanyDataImportPlugin(),
            new CompanyBusinessUnitDataImportPlugin(),
            new CompanyUnitAddressDataImportPlugin(),
            new CompanyUnitAddressLabelDataImportPlugin(),
            new CompanyUnitAddressLabelRelationDataImportPlugin(),
        ];
    }

    /**
     * @return array
     */
    protected function getDataImportBeforeImportHookPlugins(): array
    {
        return [
            new DataImportEventBehaviorPlugin(),
        ];
    }

    /**
     * @return array
     */
    protected function getDataImportAfterImportHookPlugins(): array
    {
        return [
            new DataImportEventBehaviorPlugin(),
            new DataImportPublisherPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDataImportProductAbstractWriterPlugins(Container $container): Container
    {
        $container[static::DATA_IMPORT_PRODUCT_ABSTRACT_WRITER_PLUGINS] = function () {
            return $this->getDataImportProductAbstractWriterPlugins();
        };

        return $container;
    }

    /**
     * @return \Spryker\Zed\DataImport\Dependency\Plugin\DataImportWriterPluginInterface|\Spryker\Zed\DataImport\Dependency\Plugin\DataImportFlushPluginInterface[]
     */
    protected function getDataImportProductAbstractWriterPlugins(): array
    {
        return [
            new ProductAbstractBulkPdoWriterPlugin(),
//            new ProductAbstractPropelWriterPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDataImportProductConcreteWriterPlugins(Container $container): Container
    {
        $container[static::DATA_IMPORT_PRODUCT_CONCRETE_WRITER_PLUGINS] = function () {
            return $this->getDataImportProductConcreteWriterPlugins();
        };

        return $container;
    }

    /**
     * @return \Spryker\Zed\DataImport\Dependency\Plugin\DataImportWriterPluginInterface|\Spryker\Zed\DataImport\Dependency\Plugin\DataImportFlushPluginInterface[]
     */
    protected function getDataImportProductConcreteWriterPlugins(): array
    {
        return [
            new ProductConcreteBulkPdoWriterPlugin(),
//            new ProductConcretePropelWriterPlugin(),
        ];
    }
}
