<?php

namespace SiteMap\Entities;

use DateTime;
use SiteMap\Stringable;
use function SiteMap\tag;
use function SiteMap\escape;
use function SiteMap\instance_filter;

final class Url implements Stringable
{

    const CHANGE_FREQUENCY_ALWAYS = 'always';
    const CHANGE_FREQUENCY_HOURLY = 'hourly';
    const CHANGE_FREQUENCY_DAILY = 'daily';
    const CHANGE_FREQUENCY_WEEKLY = 'weekly';
    const CHANGE_FREQUENCY_MONTHLY = 'monthly';
    const CHANGE_FREQUENCY_YEARLY = 'yearly';
    const CHANGE_FREQUENCY_NEVER = 'never';

    /**
     * @var string
     */
    private $loc;

    /**
     * @var string
     */
    private $lastMod;

    /**
     * @var string
     */
    private $changeFreq = 'daily';

    /**
     * @var string
     */
    private $priority = '1.0';

    /**
     * @var Alternate[]
     */
    private $alternates = [];

    public function __construct(string $loc, ?DateTime $lastMod = null, string $changeFreq = self::CHANGE_FREQUENCY_DAILY, string $priority = '1.0', array $alternates = [])
    {
        $this->setLoc($loc);
        $this->setLastMod($lastMod ?? new DateTime);
        $this->setChangeFreq($changeFreq);
        $this->setPriority($priority);
        $this->alternates = $alternates;
    }

    /**
     * @return string|null
     */
    public function getLoc(): ?string
    {
        return tag('loc', $this->loc);
    }

    /**
     * @return string|null
     */
    public function getLastMod(): ?string
    {
        return tag('lastmod', $this->lastMod);
    }

    /**
     * @return string|null
     */
    public function getChangeFreq(): ?string
    {
        return tag('changefreq', $this->changeFreq);
    }

    /**
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return tag('priority', $this->priority);
    }

    /**
     * @return Alternate[]
     */
    public function getAlternates()
    {
        return instance_filter($this->alternates, Alternate::class);
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
     * @param DateTime $lastMod
     * @return self
     */
    public function setLastMod(DateTime $lastMod): self
    {
        $this->lastMod = $lastMod->format(DateTime::ATOM);

        return $this;
    }

    /**
     * @param string $changeFreq
     * @return self
     */
    public function setChangeFreq(string $changeFreq): self
    {
        $this->changeFreq = escape($changeFreq);

        return $this;
    }

    /**
     * @param string $priority
     * @return self
     */
    public function setPriority(string $priority): self
    {
        $this->priority = escape($priority);

        return $this;
    }

    /**
     * @param Alternate $alternate
     * @return self
     */
    public function registerAlternate(Alternate $alternate): self
    {
        $this->alternates[] = $alternate;

        return $this;
    }

    /**
     * @param string $href
     * @param string $lang
     * @return self
     */
    public function registerBasicAlternate(string $href, string $lang = 'en'): self
    {
        $this->alternates[] = new Alternate($href, $lang);

        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return tag('url', [
            $this->getLoc(),
            $this->getLastMod(),
            $this->getChangeFreq(),
            $this->getPriority(),
            implode(PHP_EOL, $this->getAlternates())
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