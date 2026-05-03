<?php
// Local-only wrapper — bypasses login for SQLite
// DO NOT deploy to production

if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    http_response_code(403);
    exit('Access denied.');
}

function adminer_object() {
    class AdminerLocal extends Adminer {
        function login($login, $password) { return true; }
        function name() { return 'Trivalo DB'; }
    }
    return new AdminerLocal;
}

include __DIR__ . '/adminer-core.php';
