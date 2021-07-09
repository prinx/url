<?php

namespace Prinx;

class Url
{
    /**
     * Add query strings to url.
     *
     * @param string $url
     * @param array<string, string|int|float|bool>  $queryStrings
     *
     * @return string
     */
    public function addQueryString(string $url, array $queryStrings)
    {
        $urlParts = $this->getParts($url);

        $params = array_merge($this->getQueryStrings($urlParts), $queryStrings);

        $urlParts['query'] = http_build_query($params);

        return $this->build($urlParts);
    }

    /**
     * Get URL parts.
     *
     * @param string $url
     *
     * @return array
     */
    public function getParts($url)
    {
        return parse_url($url);
    }

    /**
     * Get query strings from URL or URL parts.
     *
     * @param string|array $urlOrUrlParts
     *
     * @return array
     */
    public function getQueryStrings($urlOrUrlParts)
    {
        if (is_string($urlOrUrlParts)) {
            $urlOrUrlParts = $this->getParts($urlOrUrlParts);
        }

        if (isset($urlOrUrlParts['query'])) {
            parse_str($urlOrUrlParts['query'], $params);

            return $params;
        }

        return [];
    }

    public function build($urlParts)
    {
        $newUrl = isset($urlParts['scheme']) ? $urlParts['scheme'].'://' : '';

        if (isset($urlParts['user'])) {
            $newUrl .= $urlParts['user'];
        }

        if (isset($urlParts['pass'])) {
            if (isset($urlParts['user'])) {
                $newUrl .= ':';
            }

            $newUrl .= $urlParts['pass'].'@';
        }

        if (isset($urlParts['host'])) {
            $newUrl .= $urlParts['host'];
        }

        if (isset($urlParts['port'])) {
            $newUrl .= ':'.$urlParts['port'];
        }

        if (isset($urlParts['path'])) {
            $newUrl .= $urlParts['path'];
        }

        if (isset($urlParts['query'])) {
            $newUrl .= '?'.$urlParts['query'];
        }

        if (isset($urlParts['fragment'])) {
            $newUrl .= '#'.$urlParts['fragment'];
        }

        return $newUrl;
    }

    /**
     * Remove Query string from url.
     *
     * @param string|array<string, string> $urlOrUrlParts
     * @param string|string[] $toRemove
     *
     * @return string
     */
    public function removeQueryString($urlOrUrlParts, $toRemove)
    {
        $urlParts = $urlOrUrlParts;

        if (is_string($urlOrUrlParts)) {
            $urlParts = $this->getParts($urlOrUrlParts);
        }

        if (!is_string($toRemove) && !is_array($toRemove)) {
            throw new \InvalidArgumentException('Arguments must be a query string name or an array of query string names.');
        }

        if (is_string($toRemove)) {
            $toRemove = [$toRemove];
        }

        $queryStrings = $this->getQueryStrings($urlParts);

        foreach ($toRemove as $name) {
            unset($queryStrings[$name]);
        }

        $urlParts['query'] = trim(http_build_query($queryStrings));

        if (!$urlParts['query']) {
            unset($urlParts['query']);
        }

        return $this->build($urlParts);
    }
}
