#Webservice Restfull with Slim Framework PHP using OAuth2 Authentication

### Instalar dependências do composer:
php composer.phar install

### Migração banco de dados
vendor/bin/phinx migrate
vendor/bin/phinx seed:run

### Iniciar o servidor php
php -S localhost:8080 -t public/

### Testar geração do token (Postman)
POST em http://localhost:8080/api/v1/users/oauth-full com os seguintes dados: <br />
username: rodrigo@teste.com.br <br />
password: 123456 <br />
client_id: cliente <br />
client_secret: segredo <br />





