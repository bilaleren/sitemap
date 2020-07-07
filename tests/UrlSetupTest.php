<?php declare(strict_types=1);

namespace SiteMap\Tests;

use DateTime;
use SiteMap\Entities\Alternate;
use SiteMap\Entities\Url;

class UrlSetupTest extends TestCase
{

    protected $loc = 'http://example.com/path';

    /**
     * @test
     */
    public function testCanItSetLoc()
    {
        $url = new Url($this->loc);

        $this->assertHtmlContains(
            "<loc>$this->loc</loc>",
            $url
        );

        $url->setLoc($this->loc .= '/to');

        $this->assertHtmlContains(
            "<loc>$this->loc</loc>",
            $url
        );
    }

    /**
     * @test
     */
    public function testCanItSetLastMod()
    {
        $url = new Url($this->loc);

        $url->setLastMod($now = new DateTime);

        $this->assertHtmlContains(
            '<lastmod>' . $now->format(DateTime::ATOM) . '</lastmod>',
            $url
        );
    }

    /**
     * @test
     */
    public function testCanItSetChangeFreq()
    {
        $url = new Url($this->loc);

        $this->assertHtmlContains(
            '<changefreq>daily</changefreq>',
            $url
        );

        $url->setChangeFreq('monthly');

        $this->assertHtmlContains(
            '<changefreq>monthly</changefreq>',
            $url
        );
    }

    /**
     * @test
     */
    public function testCanItSetPriority()
    {
        $url = new Url($this->loc);

        $this->assertHtmlContains(
            '<priority>1.0</priority>',
            $url
        );

        $url->setPriority('0.8');

        $this->assertHtmlContains(
            '<priority>0.8</priority>',
            $url
        );
    }

    /**
     * @test
     */
    public function testCanItRegisterAlternate()
    {
        $url = new Url($this->loc);

        $url->registerBasicAlternate($this->loc);
        $url->registerAlternate(new Alternate($this->loc . '/to'));

        $this->assertCount(2, $url->getAlternates());
    }

}