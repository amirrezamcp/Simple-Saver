<?php

class Helper {
    public static function getBrowser($user_agent) {
        $browsers = [
            'IE'=> '/Trident/',
            'Opera'=> '/Opera/',
            'Chrome'=> '/Chrome/',
            'Firefox'=> '/Firefox/'
        ];

        foreach($browsers as $browser => $pattern) {
            if(preg_match($pattern, $user_agent)) {
                return $browser;
            }
        }
        return 'Unknown browser';
    }
}