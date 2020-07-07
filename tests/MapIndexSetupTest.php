<?php declare(strict_types=1);

namespace SiteMap\Tests;

use DateTime;
use SiteMap\Entities\MapIndex;

class MapIndexSetupTest extends TestCase
{

    /**
     * @test
     */
    public function testCanItSetLoc()
    {
        $mapIndex = new MapIndex($loc = 'http://example.com/sitemap.xml');

        $this->assertHtmlContains(
            "<loc>$loc</loc>",
            $mapIndex
        );

        $mapIndex->setLoc($loc = 'http://example.com/sitemap-2.xml');

        $this->assertHtmlContains(
            "<loc>$loc</loc>",
            $mapIndex
        );
    }

    /**
     * @test
     */
    public function testCanItSetLastMod()
    {
        $mapIndex = new MapIndex('http://example.com/sitemap.xml');

        $this->assertNull($mapIndex->getLastMod());

        $mapIndex->setLastMod($now = new DateTime);

        $this->assertNotNull($mapIndex->getLastMod());
    }

}