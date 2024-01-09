<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Str as BaseStr;
use RuntimeException;

class Str extends BaseStr
{
    /**
     * Escapes some characters that are used in LIKE SQL queries to prevent some sort of injection.
     */
    public static function escapeSQLLike(string $value): string
    {
        return str_replace(['\\', '_', '%'], ['\\\\', '\\_', '\\%'], $value);
    }

    /**
     * Forces conversion to snake case (dashes are converted as well).
     */
    public static function forceSnake(string $value, string $delimiter = '_'): string
    {
        return static::snake(str_replace(['-', '_'], ' ', $value), $delimiter);
    }

    /**
     * Forces conversion to kebab case.
     */
    public static function forceKebab(string $value): string
    {
        return static::kebab(str_replace(['-', '_'], ' ', $value));
    }

    /**
     * Forces conversion to studly (pascal) case (dashes are converted as well).
     */
    public static function forceStudly(string $value, string $delimiter = '_'): string
    {
        return static::studly(str_replace(['-', '_'], ' ', $value), $delimiter);
    }

    /**
     * Forces conversion to camel case (dashes are converted as well).
     */
    public static function forceCamel(string $value, string $delimiter = '_'): string
    {
        return static::camel(str_replace(['-', '_'], ' ', $value), $delimiter);
    }

    /**
     * Generate a more truly "random" base64 string.
     */
    public static function base64Random(int $length = 16): string
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace('=', '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }



    /**
     * Checks if a given IPv4 address matches the specified CIDR subnet/s or IPs.
     * Does NOT support IPv6.
     *
     * @param  string  $ip The IP address to check
     * @param  array<int,string>  $ips The IP subnets subnets in CIDR notation, or raw IPs
     * @param  string|null  $match If provided, will contain the first matched IP subnet
     * @return bool whether the IP address matches any of the specified subnets
     */
    public static function matchesIps(string $ip, array $ips, string &$match = null): bool
    {
        foreach ($ips as $cidr) {
            if (! str_contains($cidr, '/')) {
                $cidr .= '/32';
            }

            [$subnet, $mask] = explode('/', $cidr);

            if ((ip2long($ip) & ($mask = ~((1 << (32 - $mask)) - 1))) == (ip2long($subnet) & $mask)) {
                $match = $cidr;

                return true;
            }
        }

        return false;
    }
}
