<?php declare(strict_types=1);

namespace SiteMap\Tests;

use function SiteMap\tag;

class FunctionsTest extends TestCase
{

    /**
     * @test
     */
    public function testTagFunction()
    {
        $tag = tag('tag', 'test');

        $this->assertSame('<tag>test</tag>', $tag);

        $tag = tag('tag', null);

        $this->assertNull($tag);

        $tag = tag('tag', 'test', [
            'attr' => 'test'
        ]);

        $this->assertSame('<tag attr="test">test</tag>', $tag);

        $tag = tag('tag', null, [], false);

        $this->assertSame('<tag />', $tag);
    }

}