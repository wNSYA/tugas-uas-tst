<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('createJWT')) {
    function createJWT($payload, $secret, $expiry = 3600)
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + $expiry;

        return JWT::encode($payload, $secret, 'HS256');
    }
}

if (!function_exists('validateJWT')) {
    function validateJWT($token, $secret)
    {
        try {
            return JWT::decode($token, new Key($secret, 'HS256'));
        } catch (Exception $e) {
            return false; // Invalid token
        }
    }
}

if (!function_exists('getAuthorizationHeader')) {
    function getAuthorizationHeader()
    {
        $headers = apache_request_headers();
        return isset($headers['Authorization']) ? $headers['Authorization'] : null;
    }
}

if (!function_exists('getBearerToken')) {
    function getBearerToken()
    {
        $header = getAuthorizationHeader();
        if ($header && preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}