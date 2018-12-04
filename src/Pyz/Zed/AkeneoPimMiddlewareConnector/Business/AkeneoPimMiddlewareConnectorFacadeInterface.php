<?php
/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Business;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorFacadeInterface as SprykerAkeneoPimMiddlewareConnectorFacadeInterface;
interface AkeneoPimMiddlewareConnectorFacadeInterface extends SprykerAkeneoPimMiddlewareConnectorFacadeInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function importCategories(array $data);
    /**
     * @param array $data
     *
     * @return void
     */
    public function importAttributes(array $data);
    /**
     * @param array $data
     *
     * @return void
     */
    public function importProductsConcrete(array $data);
    /**
     * @param array $data
     *
     * @return void
     */
    public function importProductsAbstract(array $data);
    /**
     * @param array $data
     *
     * @return void
     */
    public function importAttributeKeys($data);
    /**
     * @param $data
     *
     * @return void
     */
    public function importPrices($data);
    /**
     * @param $data
     *
     * @return void
     */
    public function importStores($data);
}