<?php

namespace SiteMap;

use DateTime;
use SiteMap\Entities\Url;
use SiteMap\Entities\MapIndex;

class SiteMap implements Stringable
{

    /**
     * @var Url[];
     */
    private $urls;

    /**
     * @var MapIndex|null
     */
    private $mapIndex = null;

    public function __construct(array $urls = [], ?MapIndex $mapIndex = null)
    {
        $this->urls = $urls;
        $this->mapIndex = $mapIndex;
    }

    /**
     * @param Url $url
     * @return self
     */
    public function registerUrl(Url $url): self
    {
        $this->urls[] = $url;

        return $this;
    }

    /**
     * @param string $loc
     * @param DateTime|null $lastMod
     * @return Url
     */
    public function registerBasicUrl(string $loc, ?DateTime $lastMod = null): Url
    {
        return $this->urls[] = new Url($loc, $lastMod);
    }

    /**
     * @param MapIndex $mapIndex
     * @return self
     */
    public function registerMapIndex(MapIndex $mapIndex): self
    {
        $this->mapIndex = $mapIndex;

        return $this;
    }

    /**
     * @param string $loc
     * @param DateTime|null $lastMod
     * @return self
     */
    public function registerBasicMapIndex(string $loc, ?DateTime $lastMod = null): self
    {
        $this->mapIndex = new MapIndex($loc, $lastMod);

        return $this;
    }

    /**
     * @return MapIndex|null
     */
    public function getMapIndex(): ?MapIndex
    {
        return $this->mapIndex;
    }

    /**
     * @return Url[]
     */
    public function getUrls()
    {
        return instance_filter($this->urls, Url::class);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        if (count($this->getUrls()) <= 0) return '';

        $attributes = [
            'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'
        ];

        $xmlString = implode(PHP_EOL, $urls = $this->getUrls());

        $isAlternateAble = array_filter($urls, function (Url $item) {
            return count($item->getAlternates()) > 0;
        });

        if (count($isAlternateAble)) {
            $attributes['xmlns:xhtml'] = 'http://www.w3.org/1999/xhtml';
        }

        return '<?xml version="1.0" encoding="UTF-8"?>' . tag('urlset', $xmlString, $attributes);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

}