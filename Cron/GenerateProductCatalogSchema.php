<?php

/**
 * Catalog Feed Extension by Paulo Henrique Araujo da Silva
 *
 * @category  PHAS
 * @package   PHAS_CatalogFeed
 * @author    Paulo Henrique Araujo da Silva <pauloharaujos@gmail.com>
 * @copyright Copyright (c) 2022 Paulo Henrique Araujo da Silva (https://github.com/pauloharaujos)
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace PHAS\CatalogFeed\Cron;

use PHAS\CatalogFeed\Action\ProductCatalogXMLSchema;

class GenerateProductCatalogSchema
{
    /**
     * @var ProductCatalogXMLSchema
     */
    private ProductCatalogXMLSchema $catalogXMLExport;

    /**
     * GenerateProductCatalogSchema constructor.
     * @param ProductCatalogXMLSchema $catalogXMLExport
     */
    public function __construct(
        ProductCatalogXMLSchema $catalogXMLExport
    ) {
        $this->catalogXMLExport = $catalogXMLExport;
    }

    /**
     * @return void
     */
    public function execute() : void
    {
        $this->catalogXMLExport->execute();
    }
}
