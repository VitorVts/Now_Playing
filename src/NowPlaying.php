<?php

require_once 'SpotifyTokenManager.php';

class NowPlaying
{
    private SpotifyTokenManager $tokenManager;

    public function __construct(SpotifyTokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function getCurrentPlaying(): ?array
    {
        $accessToken = $this->tokenManager->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.spotify.com/v1/me/player/currently-playing',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$accessToken}"
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);

            $type = $data['currently_playing_type'] ?? null;
            $item = $data['item'] ?? null;

            return match ($type) {
                'track' => $item ? [
                    'name' => $item['name'],
                    'artist' => $item['artists'][0]['name'],
                    'image' => $item['album']['images'][0]['url'] ?? ''
                ] : null,

                'episode' => [
                'name' => '🎙️ Um podcast está tocando',
                'artist' => '',
                'image' => 'https://cdn-icons-png.flaticon.com/512/3919/3919980.png'
                ],


                default => null
            };
        }
        return null;
    }

}