## SuperLógica Project

Sistema CRUD para gerenciamento de imóveis

Tecnologias utilizadas no projeto:

    - BackEnd: PHP com framework Laravel
    - FrontEnd: JavaScript com framework Vue
    - Banco: MySQL

Também foi gerado um container docker para rodar a aplicação

### Comandos Projeto

- Run Project

Para rodar a aplicação, suba o container docker e em seguida rode o comando npm:

```
docker-compose up -d
npm run dev
```

- Run Migration

Para rodar as migrations identifique o CONTAINER_ID da aplicação com a comando:

```
docker ps
```

Em seguida acesse o terminal da aplicação e rode as migrations:

```
docker exec -it {CONTAINER_ID} bash
php artisan migrate
```
