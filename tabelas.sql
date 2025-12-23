-- Antes de criar as tabelas, crie uma database chamada 'mini_crm'.

CREATE TABLE users
(
  id              smallint unsigned NOT NULL auto_increment,
  username        varchar(100) NOT NULL UNIQUE,
  password        varchar(255) NOT NULL,
  email           varchar(255) NOT NULL,
  user_type       tinyint NOT NULL DEFAULT 1 COMMENT '1=Player, 2=Indie Dev, 3=Player/Dev, 4=Admin',
  display_name    varchar(255) NOT NULL,
  bio             text,
  created_at      datetime NOT NULL,
  
  PRIMARY KEY     (id)
);

CREATE TABLE posts
(
  id              smallint unsigned NOT NULL auto_increment,
  title           varchar(255) NOT NULL,
  excerpt         text NOT NULL,
  content         text NOT NULL,
  published_on    datetime NOT NULL,
  user_id         smallint unsigned NOT NULL,
  
  PRIMARY KEY     (id),
  FOREIGN KEY     (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users
( username, password, email, user_type, display_name, bio, created_at )
VALUES
(
  'admin',
  '$2y$12$AglE3vVK7Psx6GOR/KMPsem9HBaSPm.a4vszuyiJ1Un4fwBi5kQfe',
  'admin@indiegames.com',
  4,
  'Administrador',
  'Administrador do sistema',
  NOW()
);

INSERT INTO posts
( title, excerpt, content, published_on, user_id )
VALUES
(
  'Bem-vindo ao Indie Games Hub!',
  'Um espaço dedicado para desenvolvedores indie e jogadores compartilharem seus jogos favoritos',
  'Este é um espaço dedicado para desenvolvedores indie e jogadores compartilharem seus jogos favoritos. Aqui você pode descobrir novos jogos independentes, compartilhar suas experiências e conectar-se com outros membros da comunidade.',
  NOW(),
  1
);

INSERT INTO posts
( title, excerpt, content, published_on, user_id )
VALUES
(
  'Como divulgar seu jogo indie',
  'Dicas essenciais para desenvolvedores independentes que querem dar visibilidade aos seus projetos',
  'Divulgar um jogo indie pode ser desafiador, mas com as estratégias certas é possível alcançar seu público. Compartilhe seu progresso regularmente, participe de comunidades, crie conteúdo interessante e não tenha medo de pedir feedback.',
  NOW(),
  1
);