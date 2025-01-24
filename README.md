## Teste para Desenvolvedor PHP/Laravel

- Author: Nataniel Martins de oliveira

### 1. Clone o Repositório

```bash
# Substitua <seu-repositorio> pela URL do seu repositório
git clone git@github.com:natanielmartinsoliveira/teste-dev-php-nataniel.git
cd teste-dev-php-nataniel
```

### 1. Build os contêineres 

```bash
docker-compose build
```

### 2. Suba os contêineres

```bash
docker-compose up -d
```


### 3. Configuração do Laravel

1. Copie o arquivo de exemplo `.env.example` para `.env`:

```bash
cp .env.example .env
```

2. Atualize as variáveis de ambiente no arquivo `.env` para refletir a configuração do banco de dados do Docker:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=test_db
DB_USERNAME=devuser
DB_PASSWORD=devpass
```

### 4. execute o comando 

```bash
docker exec -it <mycontainer> bash
```

1. agora dentro do terminal vamos executar alguns comandos para o funcionamento do laravel

```bash
chmod -R 777 /var/www/projects/example-app/storage/.
```

```bash
cd /var/www/projects/example-app/ && composer dump-autoload -o
```

Caso tenha algun problema com o processo anterior execute o comando abaixo
```bash
composer update --no-scripts
```

Prossiga com os comandos para terminar

```bash
php artisan migrate
```

```bash
php artisan key:generate
```

```bash
php artisan config:cache
```

## Comandos Úteis

- **Parar os contêineres:**
  ```bash
  docker-compose down
  ```

- **Acessar o contêiner do PHP:**
  ```bash
  docker-compose exec app bash
  ```

- **Limpar cache do Laravel:**
  ```bash
  docker-compose run --rm app php artisan cache:clear
  ```

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
