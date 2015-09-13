<?php
/*
 *
 * (C) ITinance GmbH <https://github.com/itinance/>
 *
 * Author: Hagen Huebel, hhuebel@itinance.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace itinance;

use Asm89\Twig\CacheExtension\CacheProvider\DoctrineCacheAdapter;
use Doctrine\Common\Cache\Cache;
use Slame\WhiteLabelBundle\Branding\SiteContext;

/**
 * Class DoctrineCacheAdapterWithSiteContext
 *
 * This class builds a bridge between TwigCache-Extension and MultiSite-Extension.
 *
 * When TwigCacheExtension will fetch from cache or save to cache, the key will be prefixed
 * by the current site_context's namepace name.
 *
 *
 * @link https://github.com/EmanueleMinotto/TwigCacheBundle
 * @link https://github.com/simonoche/white-label-bundle
 *
 */
class DoctrineCacheAdapterWithSiteContext extends DoctrineCacheAdapter
{
    /**
     * @var string
     */
    private $contextNamespace;


    /**
     * @param Cache $cache
     * @param SiteContext $siteContext
     */
    public function __construct(Cache $cache, SiteContext $siteContext)
    {
        parent::__construct($cache);

        $this->contextNamespace = $siteContext->getContext()['namespace'];
    }

    /**
     * prefix key with current site context's namespace
     * @param string $key
     * @return string
     */
    private function extendKey($key) {
        return $this->contextNamespace . '::' . $key;
    }
    /**
     * {@inheritDoc}
     */
    public function fetch($key)
    {
        return parent::fetch( $this->extendKey( $key) );
    }

    /**
     * {@inheritDoc}
     */
    public function save($key, $value, $lifetime = 0)
    {
        return parent::save( $this->extendKey( $key ), $value, $lifetime);
    }

}