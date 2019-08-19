<?php


namespace Pyz\Zed\MultiCart\Business\ResponseExpander;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\MultiCart\Business\ResponseExpander\QuoteResponseExpander as SprykerQuoteResponseExpander;
use Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToQuoteFacadeInterface;


class QuoteResponseExpander extends SprykerQuoteResponseExpander
{
    /**
     * @var \Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \Spryker\Zed\MultiCart\Dependency\Facade\MultiCartToQuoteFacadeInterface $quoteFacade
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     */
    public function __construct(
        MultiCartToQuoteFacadeInterface $quoteFacade,
        CompanyFacadeInterface $companyFacade
    ) {
        parent::__construct($quoteFacade);

        $this->companyFacade = $companyFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected function findCustomerQuotes(CustomerTransfer $customerTransfer): QuoteCollectionTransfer
    {
        $quoteCollectionTransfer = parent::findCustomerQuotes($customerTransfer);

        foreach ($quoteCollectionTransfer->getQuotes() as $quote) {
            $companyTransfer = $this->getCompanyTransfer($quote);
            $company = $this->companyFacade->getCompanyById($companyTransfer);
            $quote->setCompanyName($company->getName());
        }

        return $quoteCollectionTransfer;
    }

    protected function getCompanyTransfer(QuoteTransfer $quote)
    {
        $companyId = $quote->getCustomer()->getCompanyUserTransfer()->getFkCompany();

        return (new CompanyTransfer())
            ->setIdCompany($companyId);
    }
}
