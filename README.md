# Crawler plugin for CakePHP

Crawler is a HTML parser useful to find broken links, images, scripts, etc. The user simply paste the link on the input, submit it and wait for the results. Simple as that.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require patarkf/crawler-cakephp:*
```

## Configuration

After install just add the line below to your ``config/bootstrap.php``.

```
Plugin::load('Crawler', ['routes' => true, 'autoload' => true]);
```

So access the route like the example:

```
http://localhost/project/crawler/
```

## License

 See the [LICENSE](https://github.com/patarkf/Crawler/blob/master/LICENSE.md). file for license rights and limitations (MIT).
