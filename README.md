# Teste Requisito RH

Para que o projeto funcione, siga os passos abaixo:

##Baixar as imagens do Docker 
###docker-compose up -d

##Baixar as dependências do Composer 
###Primeiro entra na imagem do php-fpm
docker exec -it teste-requisito-rh-php-fpm bash
 	
###Rode o comando para instalar as dependências do composer
composer install

--------------------------------

##Banco de dados
O banco está dentro da pasta src