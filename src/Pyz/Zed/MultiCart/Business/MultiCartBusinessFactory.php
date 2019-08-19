<?php


namespace Pyz\Zed\MultiCart\Business;
use Pyz\Zed\MultiCart\Business\ResponseExpander\QuoteResponseExpander;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\MultiCart\Business\MultiCartBusinessFactory as SprykerMultiCartBusinessFactory;
use Spryker\Zed\MultiCart\Business\ResponseExpander\QuoteResponseExpanderInterface;
use Pyz\Zed\MultiCart\MultiCartDependencyProvider;

class MultiCartBusinessFactory extends SprykerMultiCartBusinessFactory
{
    /**
     * @return \Spryker\Zed\MultiCart\Business\ResponseExpander\QuoteResponseExpanderInterface
     */
    public function createQuoteResponseExpander(): QuoteResponseExpanderInterface
    {
        return new QuoteResponseExpander(
            $this->getQuoteFacade(),
            $this->getCompanyFacade()
        );
    }

    /**
     * @return \Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyFacadeInterface
    {
        return $this->getProvidedDependency(MultiCartDependencyProvider::FACADE_COMPANY);
    }
}
