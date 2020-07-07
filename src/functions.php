<?php

namespace SiteMap;

/**
 * @param string $value
 * @return string
 */
function escape(?string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_XML1);
}

/**
 * @param array $objects
 * @param string $class
 * @return array
 */
function instance_filter(array $objects, string $class): array
{
    return array_filter($objects, function ($object) use ($class) {
        return is_object($object) && get_class($object) === $class;
    });
}

/**
 * @param string $tagName
 * @param $value
 * @param array $attributes
 * @param bool $closeTag
 * @param bool $skipEmptyAttr
 * @return string|null
 */
function tag(string $tagName, $value, array $attributes = [], bool $closeTag = true, bool $skipEmptyAttr = true): ?string
{
    if (is_array($value)) $value = implode(PHP_EOL, array_filter($value));

    if ($closeTag && is_null($value)) return null;

    if ($value === '') $closeTag = false;

    $attributes = html_build_attr($attributes, $skipEmptyAttr);

    $args = $closeTag
        ? [$tagName . $attributes, $value, $tagName]
        : [$tagName . $attributes];

    return sprintf($closeTag ? '<%s>%s</%s>' : '<%s />', ...$args);
}

/**
 * @param array $attributes
 * @param bool $skipEmpty
 * @return string
 */
function html_build_attr(array $attributes, bool $skipEmpty = true): string
{
    $object = [];

    foreach ($attributes as $name => $value) {
        if ((empty($value) && $skipEmpty) || !preg_match('/^[a-z]+/', $name)) {
            continue;
        }

        $value = escape($value);
        $object[] = "$name=\"$value\"";
    }

    return count($object) > 0 ? ' ' . implode(' ', $object) : '';
}