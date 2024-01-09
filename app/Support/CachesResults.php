<?php

namespace App\Support;

use Illuminate\Support\Str;

trait CachesResults
{
    private $_cached = [];

    private static $_cachedStatic = [];

    protected function once(callable $callback, $context = null, ?int $persist = null, int $stackDepth = 1): mixed
    {
        $cachePrefix = '';

        if ($persist > 0 && method_exists($this, 'getCacheIdentifier')) {
            $cachePrefix = $this->getCacheIdentifier();

            if (! is_string($cachePrefix)) {
                $cachePrefix = '';
                $persist = null;
            } elseif ($cachePrefix !== '') {
                $cachePrefix .= ':';
            }
        }

        $call = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $stackDepth + 1)[$stackDepth];
        $identifier = $call['function'];

        if ($context !== null) {
            $identifier .= ':'.(is_string($context) ? $context : json_encode($context));
        }

        if (array_key_exists($identifier, $this->_cached)) {
            return $this->_cached[$identifier];
        }

        if ($persist > 0 && ($cached = cache()->driver('redis')->get($cachePrefix.$identifier)) !== null) {
            return $this->_cached[$identifier] = $cached;
        }

        $result = $callback();

        if ($persist > 0) {
            cache()->driver('redis')->put($cachePrefix.$identifier, $result, $persist * 60);
        }

        return $this->_cached[$identifier] = $result;
    }

    /**
     * Persists a specific value in the cache for a given duration in minutes.
     *
     * @param  callable $callback
     * @param  mixed    $context
     * @param  int      $duration
     * @return mixed
     */
    protected function persist(callable $callback, $context = null, int $duration = 60, int $stackDepth = 1)
    {
        return $this->once($callback, $context, $duration, $stackDepth + 1);
    }

    public function forgetCache(?string $identifier = null): self
    {
        if ($identifier === null) {
            $this->_cached = [];
        } else {
            unset($this->_cached[$identifier]);

            if (strpos($identifier, ':') === false) {
                foreach (array_keys($this->_cached) as $cachedIdentifier) {
                    if (Str::startsWith($cachedIdentifier, $identifier.':')) {
                        unset($this->_cached[$cachedIdentifier]);
                    }
                }
            }
        }

        return $this;
    }

    protected static function onceStatic($callback, $context = null)
    {
        $call = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $identifier = $call['function'];

        if ($context !== null) {
            $identifier .= ':'.(is_string($context) ? $context : json_encode($context));
        }

        if (! isset(self::$_cachedStatic[static::class])) {
            self::$_cachedStatic[static::class] = [];
        }

        if (array_key_exists($identifier, self::$_cachedStatic[static::class])) {
            return self::$_cachedStatic[static::class][$identifier];
        }

        return self::$_cachedStatic[static::class][$identifier] = $callback();
    }

    public static function forgetStaticCache(?string $identifier = null): void
    {
        if ($identifier === null) {
            self::$_cachedStatic = [];
        } else {
            unset(self::$_cachedStatic[$identifier]);

            if (strpos($identifier, ':') === false) {
                foreach (array_keys(self::$_cachedStatic) as $cachedIdentifier) {
                    if (Str::startsWith($cachedIdentifier, $identifier.':')) {
                        unset(self::$_cachedStatic[$cachedIdentifier]);
                    }
                }
            }
        }
    }
}
