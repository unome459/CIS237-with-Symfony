<?php

if ($_SERVER['PHP_AUTH_USER'] != 'user' && $_SERVER['PHP_AUTH_PW'] != 'secret') {
    header('WWW-Authenticate: Basic realm="secret pages"');
    header('HTTP/1.0 401 Unauthorized');
} else {
    print('<pre>' . print_r($_SERVER, true) . '</pre>');
}