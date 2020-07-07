<?php declare(strict_types=1);

namespace SiteMap\Tests;

use DateTime;
use SiteMap\SiteMap;
use SiteMap\SiteMapIndex;
use SiteMap\Entities\MapIndex;

class SiteMapIndexSetupTest extends TestCase
{

    /**
     * @test
     */
    public function testCanItRegisterMapIndex()
    {
        $dateTime = new DateTime;
        $siteMapIndex = new SiteMapIndex;

        $siteMapIndex->registerMapIndex(new MapIndex('http://example.com/example.xml', $dateTime));
        $siteMapIndex->registerMapIndex(new MapIndex('http://example.com/example-2.xml', $dateTime));

        $this->assertCount(2, $siteMapIndex->getSiteMaps());
        $this->assertHtmlContains([
            '<loc>http://example.com/example.xml</loc>',
            '<loc>http://example.com/example-2.xml</loc>',
            '<lastmod>' . $dateTime->format(DateTime::ATOM) . '</lastmod>'
        ], $siteMapIndex);
    }

    /**
     * @test
     */
    public function testCanItRegisterSiteMap()
    {
        $siteMap = new SiteMap;
        $siteMapIndex = new SiteMapIndex;

        $siteMap->registerMapIndex(new MapIndex('http://example.com/example.xml'));
        $siteMapIndex->registerSiteMap($siteMap);

        $this->assertHtmlContains(
            '<loc>http://example.com/example.xml</loc>',
            $siteMapIndex
        );
    }

}