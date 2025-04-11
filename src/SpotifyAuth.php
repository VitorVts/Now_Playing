<?php

class SpotifyAuth
{
    private string $client_id;
    private string $redirect_URI;
    private string $scope;

    public function __construct(string $client_id, string $client_secret, string $redirect_URI, string $scope)
    {
        $this->client_id = $client_id;
        $this->redirect_URI = $redirect_URI;
        $this->scope = $scope;
    }

    public function getAuthUrl(): string
    {
        $params = [
            'client_id'     => $this->client_id,
            'redirect_uri'  => $this->redirect_URI,
            'response_type' => 'code',
            'scope'         => $this->scope,
            'state'         => '12345',
        ];

        return 'https://accounts.spotify.com/authorize?' . http_build_query($params);
    }
}

