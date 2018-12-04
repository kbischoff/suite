<?php
/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Pyz\Zed\AkeneoPimMiddlewareConnector;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\CategoryDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductAbstractDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductAbstractStoreImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductConcreteDataImporterPlugin;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductPriceDataImporterPlugin;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\AkeneoPimMiddlewareConnectorDependencyProvider as SprykerEcoAkeneoPimMiddlewareConnectorDependencyProvider;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeMapMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeMapPreparationMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\AttributeMapTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\CategoryImportTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\CategoryMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\DefaultProductImportValidatorStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\LocaleMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductImportTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductModelImportMapperStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\ProductModelImportTranslationStagePlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\AttributeAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\AttributeWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\CategoryAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\CategoryWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\JsonObjectWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\LocaleStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductAbstractWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductConcreteWriteStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\ProductModelAkeneoApiStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\Stream\TaxSetStreamPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin\TaxSetMapperStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonRowInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonRowOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
use SprykerMiddleware\Zed\Report\Communication\Plugin\Hook\ReportPostProcessorHookPlugin;
class AkeneoPimMiddlewareConnectorDependencyProvider extends SprykerEcoAkeneoPimMiddlewareConnectorDependencyProvider
{
    const FACADE_EVENT = 'FACADE_EVENT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addEventFacade($container);
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container)
    {
        $container[static::FACADE_EVENT] = function (Container $container) {
            return $container->getLocator()->event()->facade();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_CATEGORY_IMPORTER_PLUGIN] = function () {
            return new CategoryDataImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAttributeDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_ATTRIBUTE_IMPORTER_PLUGIN] = function () {
            return new AttributeDataImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_ABSTRACT_IMPORTER_PLUGIN] = function () {
            return new ProductAbstractDataImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductPriceDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_PRICE_IMPORTER_PLUGIN] = function () {
            return new ProductPriceDataImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractStoresDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_ABSTRACT_STORES_IMPORTER_PLUGIN] = function () {
            return new ProductAbstractStoreImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductConcreteDataImporterPlugin(Container $container): Container
    {
        $container[static::AKENEO_PIM_MIDDLEWARE_PRODUCT_CONCRETE_IMPORTER_PLUGIN] = function () {
            return new ProductConcreteDataImporterPlugin();
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleMapImportProcessPlugins(Container $container): Container
    {
        $container[static::LOCALE_MAP_IMPORT_INPUT_STREAM_PLUGIN] = function () {
            return new LocaleStreamPlugin();
        };
        $container[static::LOCALE_MAP_IMPORT_OUTPUT_STREAM_PLUGIN] = function () {
            return new JsonObjectWriteStreamPlugin();
        };
        $container[static::LOCALE_MAP_IMPORT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::LOCALE_MAP_IMPORT_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new LocaleMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::LOCALE_MAP_IMPORT_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::LOCALE_MAP_IMPORT_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAttributeImportProcessPlugins(Container $container): Container
    {
        $container[static::ATTRIBUTE_IMPORT_INPUT_STREAM_PLUGIN] = function () {
            return new AttributeAkeneoApiStreamPlugin();
        };
        $container[static::ATTRIBUTE_IMPORT_OUTPUT_STREAM_PLUGIN] = function () {
            return new AttributeWriteStreamPlugin();
        };
        $container[static::ATTRIBUTE_IMPORT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::ATTRIBUTE_IMPORT_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new AttributeMapPreparationMapperStagePlugin(),
                new AttributeMapTranslationStagePlugin(),
                new AttributeMapMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::ATTRIBUTE_IMPORT_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::ATTRIBUTE_IMPORT_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAttributeMapProcessPlugins(Container $container): Container
    {
        $container[static::ATTRIBUTE_MAP_INPUT_STREAM_PLUGIN] = function () {
            return new AttributeAkeneoApiStreamPlugin();
        };
        $container[static::ATTRIBUTE_MAP_OUTPUT_STREAM_PLUGIN] = function () {
            return new JsonOutputStreamPlugin();
        };
        $container[static::ATTRIBUTE_MAP_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::ATTRIBUTE_MAP_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new AttributeMapPreparationMapperStagePlugin(),
                new AttributeMapTranslationStagePlugin(),
                new AttributeMapMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::ATTRIBUTE_MAP_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::ATTRIBUTE_MAP_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCategoryImportProcessPlugins(Container $container): Container
    {
        $container[static::CATEGORY_IMPORT_INPUT_STREAM_PLUGIN] = function () {
            return new CategoryAkeneoApiStreamPlugin();
        };
        $container[static::CATEGORY_IMPORT_OUTPUT_STREAM_PLUGIN] = function () {
            return new CategoryWriteStreamPlugin();
        };
        $container[static::CATEGORY_IMPORT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::CATEGORY_IMPORT_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new CategoryMapperStagePlugin(),
                new CategoryImportTranslationStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::CATEGORY_IMPORT_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::CATEGORY_IMPORT_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductImportProcessPlugins(Container $container): Container
    {
        $container[static::PRODUCT_IMPORT_INPUT_STREAM_PLUGIN] = function () {
            return new JsonRowInputStreamPlugin();
        };
        $container[static::PRODUCT_IMPORT_OUTPUT_STREAM_PLUGIN] = function () {
            return new ProductConcreteWriteStreamPlugin();
        };
        $container[static::PRODUCT_IMPORT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::PRODUCT_IMPORT_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new DefaultProductImportValidatorStagePlugin(),
                new ProductImportTranslationStagePlugin(),
                new ProductMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::PRODUCT_IMPORT_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::PRODUCT_IMPORT_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductModelImportProcessPlugins(Container $container): Container
    {
        $container[static::PRODUCT_MODEL_IMPORT_INPUT_STREAM_PLUGIN] = function () {
            return new JsonInputStreamPlugin();
        };
        $container[static::PRODUCT_MODEL_IMPORT_OUTPUT_STREAM_PLUGIN] = function () {
            return new ProductAbstractWriteStreamPlugin();
        };
        $container[static::PRODUCT_MODEL_IMPORT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::PRODUCT_MODEL_IMPORT_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new ProductModelImportTranslationStagePlugin(),
                new ProductModelImportMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::PRODUCT_MODEL_IMPORT_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::PRODUCT_MODEL_IMPORT_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductPreparationProcessPlugins(Container $container): Container
    {
        $container[static::PRODUCT_PREPARATION_INPUT_STREAM_PLUGIN] = function () {
            return new ProductAkeneoApiStreamPlugin();
        };
        $container[static::PRODUCT_PREPARATION_OUTPUT_STREAM_PLUGIN] = function () {
            return new JsonRowOutputStreamPlugin();
        };
        $container[static::PRODUCT_PREPARATION_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::PRODUCT_PREPARATION_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::PRODUCT_PREPARATION_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::PRODUCT_PREPARATION_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductModelPreparationProcessPlugins(Container $container): Container
    {
        $container[static::PRODUCT_MODEL_PREPARATION_INPUT_STREAM_PLUGIN] = function () {
            return new ProductModelAkeneoApiStreamPlugin();
        };
        $container[static::PRODUCT_MODEL_PREPARATION_OUTPUT_STREAM_PLUGIN] = function () {
            return new JsonOutputStreamPlugin();
        };
        $container[static::PRODUCT_MODEL_PREPARATION_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::PRODUCT_MODEL_PREPARATION_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::PRODUCT_MODEL_PREPARATION_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::PRODUCT_MODEL_PREPARATION_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addTaxSetMapImportProcessPlugins(Container $container): Container
    {
        $container[static::TAX_SET_MAP_IMPORT_INPUT_STREAM_PLUGIN] = function () {
            return new TaxSetStreamPlugin();
        };
        $container[static::TAX_SET_MAP_IMPORT_OUTPUT_STREAM_PLUGIN] = function () {
            return new JsonObjectWriteStreamPlugin();
        };
        $container[static::TAX_SET_MAP_IMPORT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::TAX_SET_MAP_IMPORT_STAGE_PLUGINS] = function () {
            return [
                new StreamReaderStagePlugin(),
                new TaxSetMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::TAX_SET_MAP_IMPORT_PRE_PROCESSOR_PLUGINS] = function () {
            return [];
        };
        $container[static::TAX_SET_MAP_IMPORT_POST_PROCESSOR_PLUGINS] = function () {
            return [
            ];
        };
        return $container;
    }
}
