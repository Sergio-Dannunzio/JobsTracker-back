<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    private static $secretKey = "clave_secreta";

    public static function generateToken($user) {
        $payload = [
            "id" => (string) $user["_id"],
            "email" => $user["email"],
            "exp" => time() + (60 * 60) // 1 hora
        ];
        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    public static function verifyToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }
}