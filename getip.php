<?php
function getUserIP() {
    $ip = '';
    $privateIPs = [
        '10.0.0.0|10.255.255.255',    // Single class A network
        '172.16.0.0|172.31.255.255',  // 16 contiguous class B networks
        '192.168.0.0|192.168.255.255', // 256 contiguous class C networks
        '127.0.0.0|127.255.255.255'   // localhost
    ];

    $ip_keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // Remove leading and trailing spaces
                
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    // Public IP found
                    return ['public' => $ip, 'private' => null];
                }
            }
        }
    }

    // Fallback to REMOTE_ADDR for private IP
    if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) !== false) {
        return ['public' => null, 'private' => $_SERVER['REMOTE_ADDR']];
    }

    return ['public' => null, 'private' => null];
}

$ip_addresses = getUserIP();
echo "Public IP: " . ($ip_addresses['public'] ? $ip_addresses['public'] : 'None') . "<br>";
echo "Private IP: " . ($ip_addresses['private'] ? $ip_addresses['private'] : 'None') . "<br>";
?>
