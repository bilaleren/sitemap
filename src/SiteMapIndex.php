<?php

namespace SiteMap;

use DateTime;
use SiteMap\Entities\MapIndex;

class SiteMapIndex implements Stringable
{

    /**
     * @var MapIndex[]
     */
    private $siteMaps = [];

    public function __construct(array $siteMaps = [])
    {
        $this->siteMaps = $siteMaps;
    }

    /**
     * @param MapIndex $siteMap
     * @return self
     */
    public function registerMapIndex(MapIndex $siteMap): self
    {
        $this->siteMaps[] = $siteMap;

        return $this;
    }

    /**
     * @param string $loc
     * @param DateTime|null $lastMod
     * @return self
     */
    public function registerBasicMapIndex(string $loc, ?DateTime $lastMod = null): self
    {
        $this->siteMaps[] = new MapIndex($loc, $lastMod);

        return $this;
    }

    /**
     * @param SiteMap $siteMap
     * @return self
     */
    public function registerSiteMap(SiteMap $siteMap): self
    {
        $this->siteMaps[] = $siteMap->getMapIndex();

        return $this;
    }

    /**
     * @return MapIndex[]
     */
    public function getSiteMaps()
    {
        return instance_filter($this->siteMaps, MapIndex::class);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        if (count($siteMaps = $this->getSiteMaps()) <= 0) return '';

        return tag('sitemapindex', $siteMaps, [
            'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'
        ]);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

}