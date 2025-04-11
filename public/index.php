<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/SpotifyAuth.php';

$auth = new SpotifyAuth(
    $_ENV['SPOTIFY_CLIENT_ID'],
    $_ENV['SPOTIFY_CLIENT_SECRET'],
    $_ENV['SPOTIFY_REDIRECT_URI'],
    $_ENV['SPOTIFY_SCOPE']
);

echo "<a href='" . $auth->getAuthUrl() . "'>Conectar com Spotify</a>";
