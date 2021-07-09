<?php

namespace Tests\Unit;

use Tests\TestCase;
use Prinx\Url;

class UrlTest extends TestCase
{
    /**
     * URL Utils.
     *
     * @var \Prinx\Url
     */
    protected $urlUtils;

    protected function setUp(): void
    {
        $this->urlUtils = new Url;
    }

    public function testAddQueryString()
    {
        $urls = [
            'https://test.com' => 'https://test.com?action=test',
            'https://test.com/' => 'https://test.com/?action=test',
            'https://test.com/path' => 'https://test.com/path?action=test',
            'https://test.com/path/' => 'https://test.com/path/?action=test',
            'https://test.com/path/#fragment' => 'https://test.com/path/?action=test#fragment',
            'https://test.com/path/?query=string' => 'https://test.com/path/?query=string&action=test',
        ];

        $queryStrings = [
            'action' => 'test'
        ];

        foreach ($urls as $actual => $full) {
            $this->assertEquals($full, $this->urlUtils->addQueryString($actual, $queryStrings));
        }
    }

    public function testAddMultipleQueryString()
    {
        $urls = [
            'https://test.com' => 'https://test.com?action=test&name=url',
            'https://test.com/' => 'https://test.com/?action=test&name=url',
            'https://test.com/path' => 'https://test.com/path?action=test&name=url',
            'https://test.com/path/' => 'https://test.com/path/?action=test&name=url',
            'https://test.com/path/#fragment' => 'https://test.com/path/?action=test&name=url#fragment',
            'https://test.com/path/?query=string' => 'https://test.com/path/?query=string&action=test&name=url',
        ];

        $queryStrings = [
            'action' => 'test',
            'name' => 'url',
        ];
        
        foreach ($urls as $actual => $full) {
            $this->assertEquals($full, $this->urlUtils->addQueryString($actual, $queryStrings));
        }
    }

    public function testGetUrlPart()
    {
        $urls = [
            'https://test.com?action=test&name=url',
            'https://test.com/?action=test&name=url',
            'https://test.com/path?action=test&name=url',
            'https://test.com/path/?action=test&name=url',
            'https://test.com/path/?action=test&name=url#fragment',
            'https://user:password@test.com:85/path/?query=string&action=test&name=url#fragment',
        ];

        foreach ($urls as $url) {
            $this->assertEquals(parse_url($url), $this->urlUtils->getParts($url));
        }
    }

    public function testGetQueryStringsFromUrl()
    {
        $urls = [
            'https://test.com?action=test&name=url',
            'https://test.com/?action=test&name=url',
            'https://test.com/path?action=test&name=url',
            'https://test.com/path/?action=test&name=url',
            'https://test.com/path/?action=test&name=url#fragment',
        ];
        
        $queryStrings = [
            'action' => 'test',
            'name' => 'url',
        ];

        
        foreach ($urls as $url) {
            $this->assertEquals($queryStrings, $this->urlUtils->getQueryStrings($url));
        }
    }

    public function testGetQueryStringsFromUrlParts()
    {
        $urls = [
            'https://test.com?action=test&name=url',
            'https://test.com/?action=test&name=url',
            'https://test.com/path?action=test&name=url',
            'https://test.com/path/?action=test&name=url',
            'https://test.com/path/?action=test&name=url#fragment',
        ];
        
        $queryStrings = [
            'action' => 'test',
            'name' => 'url',
        ];

        
        foreach ($urls as $url) {
            $this->assertEquals(
                $queryStrings,
                $this->urlUtils->getQueryStrings($this->urlUtils->getParts($url))
            );
        }
    }

    public function testRemoveQueryStringsFromUrlWithUrlStringAndToRemoveAsString()
    {
        $urls = [
            'https://test.com?action=test&name=url' => 'https://test.com?name=url',
            'https://test.com/?action=test&name=url' => 'https://test.com/?name=url',
            'https://test.com/path?action=test&name=url' => 'https://test.com/path?name=url',
            'https://test.com/path/?action=test&name=url' => 'https://test.com/path/?name=url',
            'https://test.com/path/?action=test&name=url#fragment' => 'https://test.com/path/?name=url#fragment',
        ];
        
        $toRemove = 'action';
        
        foreach ($urls as $url => $expected) {
            $this->assertEquals($expected, $this->urlUtils->removeQueryString($url, $toRemove));
        }
    }

    public function testRemoveQueryStringsFromUrlWithUrlStringAndToRemoveAsArray()
    {
        $urls = [
            'https://test.com?action=test&name=url' => 'https://test.com?name=url',
            'https://test.com/?action=test&name=url' => 'https://test.com/?name=url',
            'https://test.com/path?action=test&name=url' => 'https://test.com/path?name=url',
            'https://test.com/path/?action=test&name=url' => 'https://test.com/path/?name=url',
            'https://test.com/path/?action=test&name=url#fragment' => 'https://test.com/path/?name=url#fragment',
        ];
        
        $toRemove = ['action'];
        
        foreach ($urls as $url => $expected) {
            $this->assertEquals($expected, $this->urlUtils->removeQueryString($url, $toRemove));
        }
    }

    public function testRemoveQueryStringsFromUrlWithUrlPartsAndToRemoveAsString()
    {
        $urls = [
            'https://test.com?action=test&name=url' => 'https://test.com?name=url',
            'https://test.com/?action=test&name=url' => 'https://test.com/?name=url',
            'https://test.com/path?action=test&name=url' => 'https://test.com/path?name=url',
            'https://test.com/path/?action=test&name=url' => 'https://test.com/path/?name=url',
            'https://test.com/path/?action=test&name=url#fragment' => 'https://test.com/path/?name=url#fragment',
        ];
        
        $toRemove = 'action';
        
        foreach ($urls as $url => $expected) {
            $this->assertEquals($expected, $this->urlUtils->removeQueryString($this->urlUtils->getParts($url), $toRemove));
        }
    }

    public function testRemoveQueryStringsFromUrlWithUrlPartsAndToRemoveAsArray()
    {
        $urls = [
            'https://test.com?action=test&name=url' => 'https://test.com?name=url',
            'https://test.com/?action=test&name=url' => 'https://test.com/?name=url',
            'https://test.com/path?action=test&name=url' => 'https://test.com/path?name=url',
            'https://test.com/path/?action=test&name=url' => 'https://test.com/path/?name=url',
            'https://test.com/path/?action=test&name=url#fragment' => 'https://test.com/path/?name=url#fragment',
        ];
        
        $toRemove = ['action'];
        
        foreach ($urls as $url => $expected) {
            $this->assertEquals($expected, $this->urlUtils->removeQueryString($this->urlUtils->getParts($url), $toRemove));
        }
    }

    
    public function testRemoveAllQueryStringsFromUrl()
    {
        $urls = [
            'https://test.com?action=test&name=url' => 'https://test.com',
            'https://test.com/?action=test&name=url' => 'https://test.com/',
            'https://test.com/path?action=test&name=url' => 'https://test.com/path',
            'https://test.com/path/?action=test&name=url' => 'https://test.com/path/',
            'https://test.com/path/?action=test&name=url#fragment' => 'https://test.com/path/#fragment',
        ];

        $toRemove = ['action', 'name'];

        foreach ($urls as $url => $expected) {
            $this->assertEquals($expected, $this->urlUtils->removeQueryString($url, $toRemove));
        }
    }
}
