<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/SpotifyAuth.php';
require_once __DIR__ . '/../src/NowPlaying.php';
require_once __DIR__ . '/../src/SpotifyTokenManager.php';


$auth = new SpotifyAuth(
    $_ENV['SPOTIFY_CLIENT_ID'],
    $_ENV['SPOTIFY_CLIENT_SECRET'],
    $_ENV['SPOTIFY_REDIRECT_URI'],
    $_ENV['SPOTIFY_SCOPE']
);

echo "<a href='" . $auth->getAuthUrl() . "'>Conectar com Spotify</a><br>";

if(!file_exists(__DIR__ . '/../tokens/token.json'))
{
    echo "Conecte-se primeiro ao Spotify para ver o que está tocando." . PHP_EOL;
} else {
    $tokenManager = new SpotifyTokenManager();
    $player = new NowPlaying($tokenManager);
    $track =$player->getCurrentPlaying();
}

if (!$track) {
    echo "<p>Nada tocando no momento 🎧</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Agora tocando no Spotify</title>
  <style>
    .spotify-card {
      font-family: Arial, sans-serif;
      border-radius: 12px;
      padding: 20px;
      width: 350px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      background-color: #1db954;
      color: white;
    }
    .spotify-card img {
      width: 100%;
      border-radius: 10px;
    }
    .track-info {
      margin-top: 10px;
    }
    .track-info h2 {
      margin: 0;
      font-size: 1.2rem;
    }
    .track-info p {
      margin: 4px 0 0;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="spotify-card">
    <img src="<?= $track['image'] ?>" alt="Capa do álbum">
    <div class="track-info">
      <h2><?= $track['name'] ?></h2>
      <p><?= $track['artist'] ?></p>
    </div>
  </div>
</body>
</html>