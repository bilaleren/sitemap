<?php

namespace SiteMap;

interface Stringable
{

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @return string
     */
    public function __toString(): string;

}