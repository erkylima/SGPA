# Sistema de Gerenciamento de Processos Advocatícios
Esse sistema tem como objetivo gerenciar processos advocatícios sendo capaz de gerar contratos e, futuramente, petições. A priori estamos utilizando a Framework Laravel para o desenvolvimento AGIL da aplicação, com banco de dados MySql.

## Instalação
Clone o repositório:
```shell
git clone https://github.com/erkylima/SGPA.git
```

Instale os pacotes composer:
```shell
composer update
```

Copie e renomeie o arquivo .env.example para .envt, atualize o ambiente de variáveis e defina uma App Key:
```shell
php artisan key:generate
```

Depois disso, execute todas as migrations e inxerte o banco de dados:
```shell
php artisan migrate
```
```shell
php artisan db:seed
```

Ou se você precisa reiniciar o banco de dados, não tenha tanto trabalho. Faça isso em uma linha:
```shell
php artisan migrate:refresh --seed
```

Note que inxertar o banco de dados compulsoriamente poderá criar problemas, pois você pode apagar as regras e permissões para o CRUD do usuário prividas pelo projeto.

Visite <div style="display: inline">http://yoursite.com/login</div> para entrar com as credenciais abaixo:

### Demo
URL: https://stisla.rehmat.works

#### Demo do Login do Administrador
*  Email: admin@admin.com
*  Senha: 1234

#### Demo do Login do Editor
*  Email: editor@editr.com
*  Senha: 1234

#### Demo Login do Usuario
*  Email: usuario@usuario.com
*  Senha: 1234

P.S.: Modificação de senha e apagar usuário está desabilitado no modo demonstração

Esse projeto começa com um CRUD de usuários que utiliza o Spatie [Spatie Roles and Permissions](https://github.com/spatie/laravel-permission) onde é possível usufruir de níveis de classificação de usuários para limitar ou restringir acessos. Você pode modificar as preconfigurações postiriormente de acordo com sua necessidade.

### Creditos:
*   [Laravel](https://github.com/laravel/laravel)
*   [Stisla Bootstrap 4 Admin Panel Template](https://github.com/stisla/stisla)
*   [Spatie Laravel Roles and Permissions](https://github.com/spatie/laravel-permission)
*   [vue-ios-alertview](https://github.com/Wyntau/vue-ios-alertview)

### Contribuições:
Contribution is welcomed and highly appreciated. Fork the repo, make your updates and initiate a pull request. I'll approve all pull requests as long as they are constructive and follow the Laravel standard practices.
