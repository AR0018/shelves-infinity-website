<?php

/**
 * Helper class for session initialisation.
 */
class BootStrapHelper
{
    /**
     * Starts a new session.
     * @return void
     */
    public function sec_session_start()
    {
        ini_set('session.use_only_cookies', 1);
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params(
            $cookieParams["lifetime"],
            $cookieParams["path"],
            $cookieParams["domain"],
            true,
            true,
        );
        session_name('sec_session_id');
        session_start();
        session_regenerate_id();
    }
}