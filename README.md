# DoctrineCacheAdapterWithSiteContext

If you are using Emanuele Minottos [TwigCacheBundle](https://github.com/EmanueleMinotto/TwigCacheBundle) and
Simon Ochos white-label-bundle (https://github.com/simonoche/white-label-bundle), you will get trouble with
the cache.

This class is a replacement for the Cache Adapter used in TwigCacheBundle, to respect the current site context
in a white-label / multi-site environment.

## Installation:

Installation using composer:

```
    "repositories": [
        {
            "type": "git",
            "url": "git@github.com:itinance/DoctrineCacheAdapterWithSiteContext.git"
        }
    ],
    "require": {
        "itinance/DoctrineCacheAdapterWithSiteContext": "dev-master"
    },
```


## Configuration

in app/config/services.yml add the following

```
    twig_cache.adapter:
        class: itinance\DoctrineCacheAdapterWithSiteContext
        arguments:
            - @cache_service
            - @site_context
```

@cache_service could be configured like this:

```
    memcached:
        class: Memcached
        calls:
            - [ addServers, [ %memcached.servers% ] ]

    cache_service:
        class: Doctrine\Common\Cache\MemcachedCache
        calls:
            - [ setMemcached, [ @memcached ] ]
```

