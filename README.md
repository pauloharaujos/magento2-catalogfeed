<h1 align="center">
  <br>
    <img src="https://i.imgur.com/d8QEHRb.png" alt="Magento 2 Catalog Feed" width="128" height="128" title="Magento2 quicklink"/>
  <br>
  Magento 2 Catalog Feed Extension
  <br>
  <a href="https://packagist.org/packages/pauloharaujos/magento2-catalogfeed"><img src="https://img.shields.io/packagist/v/pauloharaujos/magento2-catalogfeed.svg" alt="Magento 2 Catalog Feed Stable Version"/></a>
  <a href="https://packagist.org/packages/pauloharaujos/magento2-catalogfeed"><img src="https://img.shields.io/packagist/dt/pauloharaujos/magento2-catalogfeed.svg" alt="Magento 2 Catalog Feed Stable Version"/></a>
</h1>


## How does it works?

Export your catalog to a XML file and use it to integrate with other platforms.
You can find the file exported on the following directory: pub/media/catalogfeed/m2_catalog_feed.xml

## Install

### Via Composer

Install using [Composer](https://getcomposer.org).

```
composer require pauloharaujos/magento2-catalogfeed
php bin/magento module:enable PHAS_CatalogFeed
php bin/magento setup:upgrade
```

## How to use

```
php bin/magento phas:export_catalog_feed
```

[Paulo Henrique Araujo da Silva](https://github.com/pauloharaujos)
