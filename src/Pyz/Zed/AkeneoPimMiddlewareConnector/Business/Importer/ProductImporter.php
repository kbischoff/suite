<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business\Importer;

use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\EventBehavior\EventBehaviorConfig;

class ProductImporter implements ImporterInterface
{
    /**
     * @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    private $dataSetStepBroker;
    /**
     * @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface
     */
    private $dataSet;

    /**
     * @var DataSetWriterInterface
     */
    protected $dataSetWriter;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface $dataSetStepBroker
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface $dataSetWriter
     */
    public function __construct(
        DataSetStepBrokerInterface $dataSetStepBroker,
        DataSetInterface $dataSet,
        DataSetWriterInterface $dataSetWriter
    ) {
        $this->dataSetStepBroker = $dataSetStepBroker;
        $this->dataSet = $dataSet;
        $this->dataSetWriter = $dataSetWriter;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        EventBehaviorConfig::disableEvent();
        foreach ($data as $item) {
            $this->dataSet->exchangeArray($item);
            $this->dataSetStepBroker->execute($this->dataSet);
            $this->dataSetWriter->write($this->dataSet);
        }
        $this->dataSetWriter->flush();
        EventBehaviorConfig::enableEvent();
    }
}