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

namespace PHAS\CatalogFeed\Console;

use PHAS\CatalogFeed\Action\ProductCatalogXMLSchema;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductCatalogFeedExport extends Command
{
    /**
     * @var ProductCatalogXMLSchema
     */
    private ProductCatalogXMLSchema $catalogXMLExport;

    /**
     * @var State
     */
    private State $appState;

    /**
     * Import constructor.
     * @param ProductCatalogXMLSchema $catalogXMLExport
     * @param State $appState
     */
    public function __construct(ProductCatalogXMLSchema $catalogXMLExport, State $appState)
    {
        $this->catalogXMLExport = $catalogXMLExport;
        $this->appState = $appState;
        parent::__construct();
    }

    /**
     * Configure cli command
     */
    protected function configure()
    {
        $this->setName('phas:export_catalog_feed');
        $this->setDescription('Export the Catalog Feed.');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->areaCodeFix();
        $output->writeln("Starting the export...");

        $this->catalogXMLExport->execute();

        $output->writeln("Export finished...");
    }

    /**
     * @throws LocalizedException
     */
    protected function areaCodeFix()
    {
        try {
            $this->appState->getAreaCode();
        } catch (\Exception $exception) {
            $this->appState->setAreaCode(Area::AREA_GLOBAL);
        }
    }
}
