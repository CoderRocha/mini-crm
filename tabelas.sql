-- Antes de criar as tabelas, crie uma database chamada 'mini_crm'.

CREATE TABLE posts
(
  id              smallint unsigned NOT NULL auto_increment,
  title           varchar(255) NOT NULL,
  excerpt         text NOT NULL,
  content         text NOT NULL,
  published_on     datetime NOT NULL,

  PRIMARY KEY     (id)
);

INSERT INTO posts
( title, excerpt, content, published_on )
VALUES
(
  'Lorem ipsum dolor sit amet',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae pulvinar turpis',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae pulvinar turpis. Nam ut arcu tellus. Morbi sit amet elit lacinia, tincidunt leo a, posuere mi. Mauris nec odio at quam lacinia consequat. Fusce mattis orci ex, eget accumsan neque vehicula et. Vivamus consectetur tempor lacus, in tincidunt massa rutrum ut. Pellentesque augue felis, iaculis eu interdum et, semper eu purus. Vestibulum a viverra justo.',
  '2018-10-11 10:15:00'
);

INSERT INTO posts
( title, excerpt, content, published_on )
VALUES
(
  'Nunc eget enim vulputate',
  'Integer placerat hendrerit pharetra. Nunc eget enim vulputate, efficitur dolor pretium',
  'Integer placerat hendrerit pharetra. Nunc eget enim vulputate, efficitur dolor pretium, pharetra nulla. Proin mattis aliquam sem. Morbi vel mi ac magna consequat tempus vitae eget diam. Aliquam ac sapien a tortor rutrum faucibus nec nec urna. Ut et nisl magna. Vivamus elit risus, rhoncus vitae elit suscipit, porta pulvinar justo. Aliquam sodales urna eu scelerisque ultrices. Fusce et neque id risus gravida vestibulum a et urna. Curabitur aliquam accumsan leo, pharetra tempus velit condimentum et. Donec dapibus faucibus lorem a tincidunt. Donec ultricies id metus et aliquam. Vestibulum dapibus magna nec elit ultrices, ornare pretium nisi dictum.',
  '2018-10-11 10:15:00'
);