<?php declare(strict_types=1);

namespace SiteMap\Tests;

use SiteMap\Stringable;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * @param string|array $expectations
     * @param Stringable $object
     * @return self
     */
    protected function assertHtmlContains($expectations, Stringable $object): self
    {
        if (!is_array($expectations)) {
            $expectations = [$expectations];
        }

        $html = $object->toString();

        foreach ($expectations as $expected) {
            $this->assertStringContainsString($expected, $html);
        }

        return $this;
    }

    /**
     * @param string|array $expectations
     * @param Stringable $object
     * @return self
     */
    protected function assertHtmlSame($expectations, Stringable $object): self
    {
        if (!is_array($expectations)) {
            $expectations = [$expectations];
        }

        $html = $object->toString();

        foreach ($expectations as $expected) {
            $this->assertSame($expected, $html);
        }

        return $this;
    }

}