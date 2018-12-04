<?php
/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorFacade as SprykerAkeneoPimMiddlewareConnectorFacade;
/**
 * @method \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorBusinessFactory getFactory()
 */
class AkeneoPimMiddlewareConnectorFacade extends SprykerAkeneoPimMiddlewareConnectorFacade implements AkeneoPimMiddlewareConnectorFacadeInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function importCategories(array $data)
    {
        $this->getFactory()
            ->createCategoryImporter()
            ->import($data);
    }
    /**
     * @param array $data
     *
     * @return void
     */
    public function importAttributes(array $data)
    {
        $this->getFactory()
            ->createAttributeImporter()
            ->import($data);
    }
    /**
     * @param array $data
     *
     * @return void
     */
    public function importProductsConcrete(array $data)
    {
        $this->getFactory()
            ->createProductConcreteImporter()
            ->import($data);
    }
    /**
     * @param array $data
     *
     * @return void
     */
    public function importProductsAbstract(array $data)
    {
        $this->getFactory()
            ->createProductAbstractImporter()
            ->import($data);
    }
    /**
     * @param array $data
     *
     * @return void
     */
    public function importAttributeKeys($data)
    {
        $this->getFactory()
            ->createAttributeKeyImporter()
            ->import($data);
    }
    /**
     * @param $data
     *
     * @return void
     */
    public function importPrices($data)
    {
        $this->getFactory()
            ->createProductPriceImporter()
            ->import($data);
    }
    /**
     * @param $data
     *
     * @return void
     */
    public function importStores($data)
    {
        $this->getFactory()
            ->createProductAbstractStoreImporter()
            ->import($data);
    }
}