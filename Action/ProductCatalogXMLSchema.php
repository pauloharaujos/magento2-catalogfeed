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

namespace PHAS\CatalogFeed\Action;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Helper\ImageFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem\Io\File;
use SimpleXMLElement;

class ProductCatalogXMLSchema
{
    private const XML_FILENAME = 'm2_catalog_feed.xml';

    /**
     * @var ImageFactory
     */
    private ImageFactory $imageHelperFactory;

    /**
     * @var Registry
     */
    private Registry $registry;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var CategoryCollectionFactory
     */
    private CategoryCollectionFactory $categoryCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var File
     */
    private File $file;

    /**
     * ProductCatalogXMLSchema constructor.
     * @param StoreManagerInterface $storeManager
     * @param ImageFactory $imageHelperFactory
     * @param CollectionFactory $collectionFactory
     * @param Registry $registry
     * @param File $file
     */
    public function __construct(
        Registry $registry,
        StoreManagerInterface $storeManager,
        ImageFactory $imageHelperFactory,
        CollectionFactory $collectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory,
        File $file
    ) {
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->imageHelperFactory = $imageHelperFactory;
        $this->collectionFactory = $collectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->file = $file;
    }

    public function execute()
    {
        $this->registry->register('isSecureArea', true);
        $filepath = 'pub/media/catalogfeed/' . self::XML_FILENAME;
        $collection = $this->collectionFactory->create()->addAttributeToSelect('*');

        $sxe = new SimpleXMLElement('<?xml version="1.0"?> <Products></Products>');
        $sxe->addAttribute('extractDate', date('d-m-y h:i:s'));

        foreach ($collection as $product) {
            /** @var Product $product */
            $nodeProduct = $sxe->addChild('Product');
            $nodeProduct->addChild('id', htmlspecialchars($product->getId()));
            $nodeProduct->addChild('title', htmlspecialchars($product->getName()));
            $nodeProduct->addChild('link', htmlspecialchars($this->getProductUrl($product)));
            $description = htmlspecialchars(strip_tags($product->getDescription()));
            $description = preg_replace('/[^A-Za-z0-9\-]/', ' ', $description);
            $nodeProduct->addChild('description', $description);
            $nodeProduct->addChild('price', htmlspecialchars($product->getPrice()));
            $nodeProduct->addChild('image_link', htmlspecialchars($this->getImage($product)));
            $nodeProduct->addChild('categories', htmlspecialchars($this->addCategories($product)));
        }

        $this->file->write($filepath, $sxe->asXML());
    }

    /**
     * @param Product $product
     * @return string
     */
    private function addCategories(Product $product): string
    {
        $cats = null;
        if ($categoryIds = $product->getCategoryIds()) {
            $categories = $this->categoryCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('entity_id', $categoryIds);

            foreach ($categories as $category) {
                if ($cats) {
                    $cats .= ', ' . $category->getName();
                } else {
                    $cats = $category->getName();
                }
            }
            return $cats;
        }
        return 'None';
    }

    /**
     * @param Product $product
     * @return string
     * @throws NoSuchEntityException
     */
    private function getProductUrl(Product $product): string
    {
        return $this->getBaseUrl() . $product->getUrlKey() . '.html';
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    private function getBaseUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    /**
     * @param Product $product
     * @return string
     */
    public function getImage(Product $product): string
    {
        return $this->imageHelperFactory->create()
            ->init($product, 'image')
            ->setImageFile($product->getData('image'))
            ->keepFrame(true)
            ->keepTransparency(true)
            ->getUrl();
    }
}
