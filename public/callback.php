<?php

require_once __DIR__ . '/../config/config.php';

if (!isset($_GET['code'])) {
    echo "Erro: code não encontrado" . PHP_EOL;
    exit;
}

$code = $_GET['code'];

$data = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $_ENV['SPOTIFY_REDIRECT_URI'],
];

$authHeader = base64_encode($_ENV['SPOTIFY_CLIENT_ID'] . ':' . $_ENV['SPOTIFY_CLIENT_SECRET']);

$headers = [
    'Authorization: Basic ' . $authHeader,
    'Content-Type: application/x-www-form-urlencoded'
];

$ch = curl_init('https://accounts.spotify.com/api/token');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$resposta = curl_exec($ch);
curl_close($ch);

$response = json_decode($resposta, true);

if (isset($response['access_token'])) {
    echo "Access Token: " . $response['access_token'];
} else {
    echo "Erro ao obter token: ";
    var_dump($response);
}

$response['created_at'] = time();
file_put_contents(__DIR__ . '/../tokens/token.json', json_encode($response, JSON_PRETTY_PRINT));

