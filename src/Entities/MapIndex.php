<?php

namespace SiteMap\Entities;

use DateTime;
use SiteMap\Stringable;
use function SiteMap\tag;
use function SiteMap\escape;

final class MapIndex implements Stringable
{

    /**
     * @var string
     */
    private $loc;

    /**
     * @var string|null
     */
    private $lastMod = null;

    public function __construct(string $loc, ?DateTime $lastMod = null)
    {
        $this->setLoc($loc);
        $this->setLastMod($lastMod);
    }

    /**
     * @return string|null
     */
    public function getLoc(): ?string
    {
        return tag('loc', $this->loc);
    }

    /**
     * @param string $loc
     * @return self
     */
    public function setLoc(string $loc): self
    {
        $this->loc = escape($loc);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastMod(): ?string
    {
        return tag('lastmod', $this->lastMod);
    }

    /**
     * @param DateTime|null $lastMod
     * @return self
     */
    public function setLastMod(?DateTime $lastMod): self
    {
        if ($lastMod instanceof DateTime) {
            $this->lastMod = $lastMod->format(DateTime::ATOM);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return tag('sitemap', [
            $this->getLoc(),
            $this->getLastMod()
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