<?php
/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Pyz\Zed\AkeneoPimMiddlewareConnector\Communication\Plugin;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\AkeneoPimMiddlewareConnector\Dependency\Plugin\DataImporterPluginInterface;
/**
 * @method \Pyz\Zed\AkeneoPimMiddlewareConnector\Business\AkeneoPimMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductConcreteDataImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()
            ->importProductsConcrete($data);
    }
}
