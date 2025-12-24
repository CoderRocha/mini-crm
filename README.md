# Indie Games Hub

Indie Games Hub é uma comunidade para divulgação de jogos indies, permitindo que desenvolvedores e jogadores compartilhem conteúdo sobre jogos independentes.

## Características

- Sistema de autenticação com diferentes tipos de usuários (Player, Indie Dev, Player/Dev, Admin)
- Criação e gerenciamento de posts
- Busca e paginação de posts
- Perfis de usuário personalizados
- Painel administrativo
- Interface responsiva para desktop e mobile

## Requisitos

- PHP 7.4+
- MySQL 5.7+
- WAMP, XAMP ou LAMP para rodar o projeto localmente.

## Instalação

1. Clone ou faça o download do projeto para o seu repositório local.

2. Crie um banco de dados MySQL:

   ```sql
   CREATE DATABASE mini_crm;
   ```

3. Execute o script SQL para criar as tabelas:

   ```bash
   mysql -u root -p mini_crm < tabelas.sql
   ```

4. Configure as credenciais do banco de dados no arquivo `config.php`:

   ```php
   define( 'DB_HOST', 'localhost' );
   define( 'DB_USER', 'seu_usuario' );
   define( 'DB_PASSWORD', 'sua_senha' );
   define( 'DB_DATABASE', 'mini_crm' );
   ```

5. Configure a URL do site no arquivo `config.php`:

   ```php
   define( 'SITE_URL', 'http://seudominio.com' );
   ```

6. Para produção, desabilite a exibição de erros no `config.php`:

   ```php
   error_reporting( 0 );
   ini_set( 'display_errors', 0 );
   ```

## Primeiro Acesso

Após a instalação, você pode fazer login com:

- **Usuário:** admin
- **Senha:** admin123

**Importante:** Altere a senha do administrador após o primeiro acesso.

## Estrutura de Usuários (Roles)

- **Player (1):** Usuário que consome conteúdo sobre jogos indies
- **Indie Dev (2):** Desenvolvedor de jogos independentes
- **Player/Dev (3):** Usuário que é tanto jogador quanto desenvolvedor
- **Admin (4):** Administrador do sistema com acesso completo

## Permissões

- Todos os usuários autenticados podem criar posts
- Usuários podem deletar apenas seus próprios posts
- Administradores podem deletar qualquer post
- Apenas administradores podem acessar o painel administrativo

## Estrutura de Diretórios

```
mini-crm/
├── admin/              # Painel Administrativo
│   ├── templates/      # Templates do admin
│   └── index.php       # Controller principal de Admin
├── assets/             # Assets do Projeto
├── inc/                # Classes e funções auxiliares
│   ├── class-db.php    # Classe de conexão com banco
│   ├── helpers.php     # Funções auxiliares
│   ├── posts.php       # Funções relacionadas a posts
│   └── users.php       # Funções relacionadas a usuários
├── templates/          # Templates reutilizáveis
│   ├── header.php      # Cabeçalho do site
│   └── footer.php      # Rodapé do site
├── config.php          # Configurações do sistema
├── init.php            # Inicialização do sistema
├── index.php           # Página principal
├── login.php           # Página de login
├── register.php        # Página de registro
├── profile.php         # Página de perfil
├── new-post.php        # Criação de novos posts
└── tabelas.sql         # Script de criação do banco de dados
```

## Funcionalidades Principais

### Posts

- Criação de posts com título, resumo e conteúdo
- Busca por palavras-chave no título, resumo ou conteúdo
- Paginação configurável (10, 20, 30, 40 ou 50 posts por página)
- Visualização individual de posts
- Exibição do autor e tipo de usuário

### Perfis

- Visualização de informações do usuário
- Lista de posts criados pelo usuário
- Exibição de bio e tipo de usuário

### Busca e Navegação

- Barra de pesquisa na página principal
- Filtros de paginação
- Navegação responsiva com menu hambúrguer em dispositivos móveis

## Segurança

- As senhas são armazenadas usando `password_hash()` do PHP
- Validação de hash para ações sensíveis (deletar posts)
- Proteção contra SQL injection usando `real_escape_string()`
- Verificação de permissões antes de ações críticas
- Sessões PHP para autenticação e evitar acessos não autorizados

## Autor

**Guilherme Rocha (CoderRocha)**

- GitHub: [CoderRocha](https://github.com/coderrocha)
- LinkedIn: [Guilherme Rocha](https://www.linkedin.com/in/guilherme-rocha-da-silva)

---