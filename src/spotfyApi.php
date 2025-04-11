<?php

function getAccessToken(): ?string {
    $tokenPath = __DIR__ . '/../tokens/token.json';

    if (!file_exists($tokenPath)) {
        echo "Token não encontrado.";
        return null;
    }

    $tokenData = json_decode(file_get_contents($tokenPath), true);

    if (!isset($tokenData['access_token'])) {
        echo "Access token inválido.";
        return null;
    }

    return $tokenData['access_token'];
}

$accessToken = getAccessToken();

if (!$accessToken) {
    exit;
}

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.spotify.com/v1/me/player/currently-playing',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken"
    ]
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

var_dump($data = json_decode($response, true));
if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "🎵 Tocando agora: " . $data['item']['name'] . " - " . $data['item']['artists'][0]['name'];
} elseif ($httpCode === 204) {
    echo "Nada está tocando no momento.";
} else {
    echo "Erro ao buscar música: $httpCode";
    var_dump($response);
}
