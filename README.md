# 🎧 Now Playing Spotify Widget (PHP)

Este projeto é um widget desenvolvido em PHP para exibir a música atual que está sendo reproduzida no Spotify. Ideal para ser incorporado em portfólios, blogs ou páginas pessoais.

---

## 🚀 Funcionalidades

- Autenticação via OAuth2 com Spotify
- Obtenção da faixa atual em reprodução
- Exibição de informações como:
  - Nome da música
  - Artista
  - Capa do álbum
  - Link direto para ouvir no Spotify
- Design personalizável
- Atualização em tempo real (opcional)

---

## 🛠️ Tecnologias Utilizadas

- PHP 7+
- API do Spotify (Web API)
- OAuth2
- HTML / CSS (puro ou com framework se desejar)

---

## ✅ Etapas e Tarefas

### 📦 Etapa 1: Preparação

- [ ] Criar um app no [Spotify Developer Dashboard](https://developer.spotify.com/dashboard)
- [ ] Configurar Client ID, Secret e Redirect URI
- [ ] Estruturar diretórios do projeto

### 🔐 Etapa 2: Autenticação com Spotify

- [ ] Gerar URL de autorização com os scopes:
  - `user-read-currently-playing`
  - `user-read-playback-state`
- [ ] Redirecionar usuário para login Spotify
- [ ] Trocar `code` por `access_token` e `refresh_token`
- [ ] Armazenar os tokens com segurança

### ♻️ Etapa 3: Atualização de Token

- [ ] Verificar se o token expirou
- [ ] Usar `refresh_token` para obter um novo `access_token`

### 🎧 Etapa 4: Obter Faixa Atual

- [ ] Fazer requisição para `https://api.spotify.com/v1/me/player/currently-playing`
- [ ] Tratar resposta JSON
- [ ] Extrair nome da música, artista, capa e link

### 🧱 Etapa 5: Construção do Widget

- [ ] Criar componente visual com HTML/CSS
- [ ] Estilizar com responsividade (opcional)
- [ ] Adicionar botão “Ouvir no Spotify”

### 🔁 Etapa 6: Atualização Dinâmica

- [ ] (Opcional) Usar AJAX ou auto refresh para atualizar a faixa em tempo real

### 🧪 Etapa 7: Testes

- [ ] Verificar se token expira e renova corretamente
- [ ] Validar exibição quando música está pausada
- [ ] Testar login e desconexão

### 🚀 Etapa 8: Deploy e Uso

- [ ] Subir projeto no servidor
- [ ] Incluir widget no seu portfólio ou site pessoal

---

## 📂 Organização com POO (Programação Orientada a Objetos)

Para manter o projeto limpo e organizado, você pode usar a seguinte estrutura orientada a objetos:

```
now-playing/
├── classes/
│   ├── SpotifyAuth.php         # Gerencia login, tokens e refresh
│   ├── SpotifyAPI.php          # Requisições para os endpoints da API
│   └── NowPlayingWidget.php    # Monta e exibe o widget final
├── public/
│   ├── index.php               # Página principal do widget
│   ├── callback.php            # Recebe o retorno do login do Spotify
│   └── assets/
│       └── style.css           # Estilo do widget
├── token.json                  # Armazena token (ou usar banco de dados)
├── .env                        # Client ID e Secret (recomendo usar lib de env)
└── README.md
```

### 🧠 Conceito das classes:

- **SpotifyAuth**
  - Responsável por criar o link de login
  - Trocar o `code` por token
  - Renovar token com `refresh_token`
  - Armazenar e ler os tokens

- **SpotifyAPI**
  - Usa o `access_token` para fazer requisições na API
  - Métodos como `getCurrentlyPlaying()`

- **NowPlayingWidget**
  - Monta o HTML do widget
  - Recebe os dados da API e formata a saída

---

## 💡 Dicas Finais

- Não exponha seu `Client Secret` em páginas públicas.
- Use `.env` para variáveis sensíveis.
- Tokens têm prazo de validade, então implemente a lógica de renovação.
- Use uma lib como `vlucas/phpdotenv` se quiser carregar variáveis de ambiente.

---

📬 **Licença:** Projeto livre para fins educacionais e de portfólio.
