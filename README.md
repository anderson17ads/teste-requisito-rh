# Teste Requisito RH

##Instalação

Baixe as imagens do Docker
```bash
docker-compose up -d
```
Baixe as dependências do Composer

Primeiro entre na imagem do php-fpm
```bash
docker exec -it teste-requisito-rh-php-fpm bash
```

Depois rode o comando para instalar as dependências do composer
```bash
composer install
```

##Banco de dados
O banco está dentro da pasta src

##Como usar
Em seu navegador, digite o seguinte caminho
```bash
http://localhost:8092/
```