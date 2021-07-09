# URL

URL utilities for PHP

<p>
<a href="https://github.com/prinx/url/actions/workflows/tests.yml"><img src="https://github.com/prinx/url/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/prinx/url"><img src="https://poser.pugx.org/prinx/url/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/prinx/url"><img src="https://poser.pugx.org/prinx/url/license.svg" alt="License"></a>
</p>


## Installation

```shell
composer require prinx/url
```

## Usage

### Create an instance of the utility class

```php
$url = new \Prinx\Url;
```

### Add query string to URL

```php
$newUrl = $url->addQueryString('https://test.com', ['action' => 'test']); // https://test.com?action=test
$newUrl = $url->addQueryString('https://test.com?name=url', ['action' => 'test']); // https://test.com?name=url&action=test
```

### Get URL parts

```php
$urlParts = $url->getParts('https://test.com?name=url');

/*
[
  'scheme' => 'https'
  'host'   => 'test.com'
  'path'   => '/path/'
  'query'  => 'query=string&action=test&name=url'
]
*/
```

```php
$urlParts = $url->getParts('https://user:password@test.com:85/path/?action=test&name=url#faq');

/*
[
  'scheme'   =>  'https'
  'host'     =>  'test.com'
  'port'     =>  85
  'user'     =>  'user'
  'pass'     =>  'password'
  'path'     =>  '/path/'
  'query'    =>  'action=test&name=url'
  'fragment' =>  'faq'
]
*/
```

### Get query string

```php
$queryStrings = $url->getQueryStrings('https://test.com?name=url&action=test');

// ['name' => 'url', 'action' => 'test']
```

### Remove query string from URL

```php
$newUrl = $url->removeQueryString('https://test.com?name=url&action=test', 'name');

// https://test.com?action=test
```

```php
$newUrl = $url->removeQueryString('https://test.com?name=url&action=test', ['name', 'action']);

// https://test.com
```

## Contribute

Star :star: the repo, fork it, fix a bug, add a new feature, write tests, correct documentation, and submit a pull request.

## License

[MIT](LICENSE)
