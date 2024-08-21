<?php

class SessionManager
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public static function initializeCart(): void
    {
        if (!self::has('cart')) {
            self::set('cart', []);
        }
    }
}
