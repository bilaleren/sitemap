<?php declare(strict_types=1);

namespace SiteMap\Tests;

use SiteMap\Entities\Alternate;

class AlternateSetupTest extends TestCase
{

    /**
     * @test
     */
    public function testCanItSetHref()
    {
        $alternate = new Alternate('http://example.com/en/path');

        $this->assertHtmlSame(
            '<xhtml:link rel="alternate" href="http://example.com/en/path" hreflang="en" />',
            $alternate
        );

        $alternate->setHref('http://example.com/en/example-url-2');

        $this->assertHtmlSame(
            '<xhtml:link rel="alternate" href="http://example.com/en/example-url-2" hreflang="en" />',
            $alternate
        );
    }

    /**
     * @test
     */
    public function testCanItSetLang()
    {
        $alternate = new Alternate($href = 'http://example.com/example-url');

        $this->assertHtmlSame(
            '<xhtml:link rel="alternate" href="' . $href . '" hreflang="en" />',
            $alternate
        );

        $alternate->setLang('tr');

        $this->assertHtmlSame(
            '<xhtml:link rel="alternate" href="' . $href . '" hreflang="tr" />',
            $alternate
        );
    }

}