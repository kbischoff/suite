<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business;

use Pyz\Zed\AkeneoPimMiddlewareConnector\AkeneoPimMiddlewareConnectorDependencyProvider;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\Importer;
use Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ProductImporter;
use Pyz\Zed\DataImport\Business\Model\CmsBlock\Category\Repository\CategoryRepository;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddCategoryKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer\ProductAbstractPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer\ProductAbstractStorePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\ProductAttributeKeyWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\ProductConcretePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementAttributeWriter;
use Pyz\Zed\DataImport\Business\Model\ProductPrice\ProductPriceWriterStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep;
use Spryker\Zed\CategoryDataImport\Business\Model\CategoryWriterStep;
use Spryker\Zed\CategoryDataImport\Business\Model\Reader\CategoryReader;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSet;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBroker;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterCollection;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\DataImport\Dependency\Facade\DataImportToEventBridge;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorBusinessFactory as SprykerAkeneoPimMiddlewareConnectorBusinessFactory;

class AkeneoPimMiddlewareConnectorBusinessFactory extends SprykerAkeneoPimMiddlewareConnectorBusinessFactory
{
    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createCategoryImporter()
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createCategoryImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createAttributeImporter()
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createAttributeImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createAttributeKeyImporter()
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createAttributeKeysDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createProductPriceImporter()
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createProductPriceImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createProductAbstractStoreImporter()
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createProductAbstractStoresImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createProductAbstractImporter()
    {
        return new ProductImporter(
            $this->createProductAbstractImportDataSetStepBroker(),
            $this->createDataSet(),
            $this->createProductAbstractDataSetWriter()
        );
    }

    /**
     * @return \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer\ImporterInterface
     */
    public function createProductConcreteImporter()
    {
        return new ProductImporter(
            $this->createProductConcreteImportDataSetStepBroker(),
            $this->createDataSet(),
            $this->createProductConcreteDataSetWriter()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher
     */
    protected function createDataImporterPublisher()
    {
        return new DataImporterPublisher($this->createDataImportToEventBridge());
    }

    /**
     * @return \Spryker\Zed\DataImport\Dependency\Facade\DataImportToEventBridge
     */
    protected function createDataImportToEventBridge()
    {
        return new DataImportToEventBridge($this->getEventFacade());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createCategoryImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        $dataSetStepBroker->addStep($this->createCategoryWriteStep());
        return $dataSetStepBroker;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createAttributeImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        $dataSetStepBroker->addStep($this->createAddProductAttributeKeysStep());
        $dataSetStepBroker->addStep($this->createProductManagementAttributeWriter());
        return $dataSetStepBroker;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep
     */
    protected function createAddProductAttributeKeysStep()
    {
        return new AddProductAttributeKeysStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementAttributeWriter
     */
    protected function createProductManagementAttributeWriter()
    {
        return new ProductManagementAttributeWriter();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createAttributeKeysDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        $dataSetStepBroker->addStep($this->createProductAttributeKeyWriter());
        return $dataSetStepBroker;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createProductAbstractImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        $dataSetStepBroker->addStep($this->createNewAddCategoryKeysStep());
        $dataSetStepBroker->addStep($this->createTaxSetNameToIdTaxSetStep());
        $dataSetStepBroker->addStep(new ProductAbstractHydratorStep());
//        $dataSetStepBroker->addStep(new ProductAbstractStoreHydratorStep());

        return $dataSetStepBroker;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddCategoryKeysStep
     */
    protected function createNewAddCategoryKeysStep()
    {
        return new AddCategoryKeysStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep
     */
    protected function createTaxSetNameToIdTaxSetStep()
    {
        return new TaxSetNameToIdTaxSetStep(TaxSetNameToIdTaxSetStep::KEY_SOURCE, TaxSetNameToIdTaxSetStep::KEY_TARGET);
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractWriterStep
     */
    protected function createProductAbstractWriterStep()
    {
        return new ProductAbstractWriterStep($this->createProductRepository());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductAbstractDataSetWriter(): DataSetWriterInterface
    {
        return new DataSetWriterCollection([
            new ProductAbstractPropelDataSetWriter($this->createProductRepository()),
//            new ProductAbstractStorePropelDataSetWriter(),
        ]);
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductConcreteDataSetWriter(): DataSetWriterInterface
    {
        return new ProductConcretePropelDataSetWriter(
            $this->createProductRepository()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createProductConcreteImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        $dataSetStepBroker->addStep(new ProductConcreteHydratorStep(
            $this->createProductRepository()
        ));

        return $dataSetStepBroker;
    }
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createProductPriceImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        return $dataSetStepBroker;
    }
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createProductAbstractStoresImportDataSetStepBroker()
    {
        $dataSetStepBroker = new DataSetStepBroker();
        return $dataSetStepBroker;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository
     */
    protected function createProductRepository()
    {
        return new ProductRepository();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface
     */
    protected function createDataSet()
    {
        return new DataSet();
    }

    /**
     * @return \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(AkeneoPimMiddlewareConnectorDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createCategoryWriteStep()
    {
        return new CategoryWriterStep($this->createCategoryReader());
    }

    /**
     * @return \Spryker\Zed\CategoryDataImport\Business\Model\Reader\CategoryReader
     */
    protected function createCategoryReader(): CategoryReader
    {
        return new CategoryReader();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\CmsBlock\Category\Repository\CategoryRepository
     */
    protected function createCategoryRepository()
    {
        return new CategoryRepository();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createProductAttributeKeyWriter()
    {
        return new ProductAttributeKeyWriter();
    }
}
