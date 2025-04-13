<?php

class SpotifyTokenManager
{
    private string $tokenPath;
    private ?string $accessToken = null;
    private ?string $refreshToken = null;
    private int $expiresIn = 0;
    private int $createdAt = 0;

    public function __construct(string $tokenPath = __DIR__ . '/../tokens/token.json')
    {
        $this->tokenPath = $tokenPath;
        $this->loadToken();
    }

    private function loadToken(): void
    {
        if (!file_exists($this->tokenPath)) {
            echo "Token não encontrado.\n";
            return;
        }

        $tokenData = json_decode(file_get_contents($this->tokenPath), true);
        $this->accessToken = $tokenData['access_token'] ?? null;
        $this->refreshToken = $tokenData['refresh_token'] ?? null;
        $this->expiresIn = $tokenData['expires_in'] ?? 3600;
        $this->createdAt = $tokenData['created_at'] ?? time();

        if ($this->isTokenExpired()) {
            $this->refreshAccessToken();
        }
    }

    private function isTokenExpired(): bool
    {
        return (time() - $this->createdAt) >= $this->expiresIn;
    }

    private function refreshAccessToken(): void
    {
        if (!$this->refreshToken) {
            echo "Refresh token ausente.\n";
            return;
        }

        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
        ];

        $authHeader = base64_encode($_ENV['SPOTIFY_CLIENT_ID'] . ':' . $_ENV['SPOTIFY_CLIENT_SECRET']);

        $headers = [
            'Authorization: Basic ' . $authHeader,
            'Content-Type: application/x-www-form-urlencoded'
        ];

        $ch = curl_init('https://accounts.spotify.com/api/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['access_token'])) {
            $this->accessToken = $data['access_token'];
            $this->expiresIn = $data['expires_in'];
            $this->createdAt = time();

            file_put_contents($this->tokenPath, json_encode([
                'access_token' => $this->accessToken,
                'refresh_token' => $this->refreshToken,
                'expires_in' => $this->expiresIn,
                'created_at' => $this->createdAt
            ], JSON_PRETTY_PRINT));

            echo "🔄 Token atualizado com sucesso.\n";
        } else {
            echo "Erro ao atualizar o token:\n";
            var_dump($data);
        }
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }
}
