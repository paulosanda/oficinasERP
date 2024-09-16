# ERP EMPRESAS DO SETOR DE MANUTENÇÃO AUTOMOTIVA

Este projeto utiliza Laravel, Sail e Docker. Siga os passos abaixo para configurar o ambiente de desenvolvimento.
<br />

## Pré-requisitos

Certifique-se de ter [Docker](https://www.docker.com/products/docker-desktop) e [Docker Compose](https://docs.docker.com/compose/install/) instalados em sua máquina.
<br />

## Configuração do Ambiente

1.  **Instalação das dependências PHP:**

Execute o comando a seguir para instalar as dependências PHP usando o Composer:

```bash
composer install
```
<br />

2.  **Instalação das dependências JavaScript:**

Execute o comando a seguir para instalar as dependências JavaScript usando o npm:

```bash
npm install
```
<br />

3.  **Configure o Ambiente:**

Copie o arquivo .env.example para um novo arquivo .env e ajuste as variáveis de ambiente conforme necessário:

```bash
cp .env.example .env
```
<br />

4.  **Subir os containers Docker:**

Execute o comando a seguir para subir os containers Docker em segundo plano:

```bash
docker-compose up -d
```
<br />  

5.  **Executar as migrations e seeders:**

Utilize o Sail para executar as migrations e seeders:

```bash
./vendor/bin/sail php artisan migrate --seed
```
<br />

6.  **Iniciar o servidor de desenvolvimento:**

Execute o comando abaixo para iniciar o servidor de desenvolvimento:

```bash
npm run dev
```

## Testes

Antes de começar a codar em uma nova branch, rode os testes para garantir que o código está funcionando corretamente. Após finalizar as modificações, execute os testes novamente antes do commit.