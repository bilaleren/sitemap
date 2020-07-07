<?php

namespace SiteMap\Entities;

use SiteMap\Stringable;
use function SiteMap\tag;
use function SiteMap\escape;

final class Alternate implements Stringable
{

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $lang = 'en';

    public function __construct(string $href, string $lang = 'en')
    {
        $this->setHref($href);
        $this->setLang($lang);
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return self
     */
    public function setLang(string $lang): self
    {
        $this->lang = escape($lang);

        return $this;
    }

    /**
     * @param string $href
     * @return self
     */
    public function setHref(string $href): self
    {
        $this->href = escape($href);

        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return tag('xhtml:link', null, [
            'rel' => 'alternate',
            'href' => $this->getHref(),
            'hreflang' => $this->getLang()
        ], false);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

}