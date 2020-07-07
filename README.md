## PHP Sitemap Generator

Sitemaps are an easy way for webmasters to inform search engines about pages on their sites that are available for crawling. In its simplest form, a Sitemap is an XML file that lists URLs for a site along with additional metadata about each URL (when it was last updated, how often it usually changes, and how important it is, relative to other URLs in the site) so that search engines can more intelligently crawl the site.

## Installation

```
composer require bilaleren/sitemap
```

## Create Sitemap

```php
header('Content-Type: application/xml; charset=utf-8');

require 'vendor/autoload.php';

use SiteMap\SiteMap;
use SiteMap\Entities\Url;
use SiteMap\Entities\Alternate;

$siteMap = new SiteMap([
    new Url('http://example.com/example-1')
]);

// with alternate
$siteMap
    ->registerBasicUrl('http://exampe.com/path-1')
    ->registerAlternate(new Alternate('http://exampe.com/tr/path-1', 'tr'));

$siteMap->registerBasicUrl('http://exampe.com/path-2');

$siteMap->registerUrl(new Url('http://example.com/example-2'));
$siteMap->registerBasicUrl('http://example.com/example-3');

$siteMap
    ->registerBasicUrl('http://example.com/example-4');

// save as sitemap.xml
$siteMap->writeToFile('sitemap.xml');

echo $siteMap;
```

### Create Sitemap Index

You can provide multiple Sitemap files, but each Sitemap file that you provide must have no more than 50,000 URLs and must be no larger than 50MB (52,428,800 bytes). If you would like, you may compress your Sitemap files using gzip to reduce your bandwidth requirement; however the sitemap file once uncompressed must be no larger than 50MB. If you want to list more than 50,000 URLs, you must create multiple Sitemap files.

```php
header('Content-Type: application/xml; charset=utf-8');

require 'vendor/autoload.php';

use SiteMap\SiteMap;
use SiteMap\SiteMapIndex;
use SiteMap\Entities\MapIndex;

$siteMap = new SiteMap;

$siteMap->registerBasicUrl('http://example.com/example');
$siteMap->registerBasicMapIndex('http://site.com/sitemap-1.xml');

$siteMapIndex = (new SiteMapIndex)
    ->registerSiteMap($siteMap)
    ->registerMapIndex(new MapIndex('http://site.com/sitemap-2.xml'))
    ->registerMapIndex(new MapIndex('http://site.com/sitemap-3.xml', new DateTime));

// save as sitemap.xml
$siteMapIndex->writeToFile('sitemap.xml');

echo $siteMapIndex;
```