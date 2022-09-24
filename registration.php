<?php

/**
 * Catalog Feed Extension by Paulo Henrique Araujo da Silva
 *
 * @category  PHAS
 * @package   PHAS_CatalogFeed
 * @author    Paulo Henrique Araujo da Silva <paulo@imaginationmedia.com>
 * @copyright Copyright (c) 2022 Paulo Henrique Araujo da Silva (https://github.com/pauloharaujos)
 * @license https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'PHAS_CatalogFeed',
    __DIR__
);
