<?php
class Session {
    public static function init() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::init();
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        self::init();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function destroy() {
        self::init();
        $_SESSION = [];
        if(ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time()-42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }
}