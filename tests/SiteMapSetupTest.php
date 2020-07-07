<?php declare(strict_types=1);

namespace SiteMap\Tests;

use SiteMap\SiteMap;
use SiteMap\Entities\Url;
use SiteMap\Entities\Alternate;

class SiteMapSetupTest extends TestCase
{

    /**
     * @test
     */
    public function testCanItRegisterUrl()
    {
        $siteMap = new SiteMap;

        $siteMap->registerUrl(new Url('http://example.com/path-1'));
        $siteMap->registerBasicUrl('http://example.com/path-2');

        $this->assertCount(2, $siteMap->getUrls());

        $this->assertHtmlContains([
            '<loc>http://example.com/path-1</loc>',
            '<loc>http://example.com/path-2</loc>',
            '<priority>1.0</priority>',
            '<changefreq>daily</changefreq>'
        ], $siteMap);
    }

    /**
     * @test
     */
    public function testCanItRegisterAlternate()
    {
        $siteMap = new SiteMap;

        $siteMap
            ->registerBasicUrl('http://example.com/path-1')
            ->registerAlternate(new Alternate('http://example.com/tr/path-1', 'tr'));

        $siteMap
            ->registerBasicUrl('http://example.com/path-2')
            ->registerAlternate(new Alternate('http://example.com/en/path-2'));

        $this->assertCount(2, array_map(function (Url $url) {
            return $url->getAlternates();
        }, $siteMap->getUrls()));

        $this->assertHtmlContains([
            '<xhtml:link rel="alternate" href="http://example.com/tr/path-1" hreflang="tr" />',
            '<xhtml:link rel="alternate" href="http://example.com/en/path-2" hreflang="en" />'
        ], $siteMap);
    }

    /**
     * @test
     */
    public function testCanItRegisteredMapIndex()
    {
        $siteMap = new SiteMap;

        $siteMap->registerBasicMapIndex('http://example.com/example.xml');

        $this->assertNotNull($siteMap->getMapIndex());
    }

}