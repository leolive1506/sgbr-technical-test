<p align="center">
    <img src="https://raw.githubusercontent.com/PKief/vscode-material-icon-theme/ec559a9f6bfd399b82bb44393651661b08aaf7ba/icons/folder-markdown-open.svg" align="center" width="30%">
</p>
<p align="center"><h1 align="center">SGBR-TECHNICAL-TEST</h1></p>
<p align="center">
	<em><code>❯ REPLACE-ME</code></em>
</p>
<p align="center">
	<img src="https://img.shields.io/github/license/leolive1506/sgbr-technical-test?style=default&logo=opensourceinitiative&logoColor=white&color=0080ff" alt="license">
	<img src="https://img.shields.io/github/last-commit/leolive1506/sgbr-technical-test?style=default&logo=git&logoColor=white&color=0080ff" alt="last-commit">
	<img src="https://img.shields.io/github/languages/top/leolive1506/sgbr-technical-test?style=default&color=0080ff" alt="repo-top-language">
	<img src="https://img.shields.io/github/languages/count/leolive1506/sgbr-technical-test?style=default&color=0080ff" alt="repo-language-count">
</p>
<p align="center"><!-- default option, no dependency badges. -->
</p>
<p align="center">
	<!-- default option, no dependency badges. -->
</p>
<br>

##  Table of Contents

- [ Overview](#-overview)
- [ Features](#-features)
- [ Project Structure](#-project-structure)
  - [ Project Index](#-project-index)
- [ Getting Started](#-getting-started)
  - [ Prerequisites](#-prerequisites)
  - [ Installation](#-installation)
  - [ Usage](#-usage)
  - [ Testing](#-testing)
- [ Project Roadmap](#-project-roadmap)
- [ Contributing](#-contributing)
- [ License](#-license)
- [ Acknowledgments](#-acknowledgments)

---

##  Getting Started

###  Prerequisites

Before getting started with sgbr-technical-test, ensure your runtime environment meets the following requirements:

- **Programming Language:** PHP 8.4
- **Package Manager:** Composer
- **Container Runtime:** Docker

###  Installation

Install sgbr-technical-test using one of the following methods:

**Build from source:**

1. Clone the sgbr-technical-test repository:
```sh
❯ git clone https://github.com/leolive1506/sgbr-technical-test
```

2. Navigate to the project directory:
```sh
❯ cd sgbr-technical-test
```

3. Install the project dependencies:


**Using `composer`** &nbsp; [<img align="center" src="https://img.shields.io/badge/PHP-777BB4.svg?style={badge_style}&logo=php&logoColor=white" />](https://www.php.net/)

```sh
❯ composer install
```


###  Usage
Run sgbr-technical-test using the following command:
**Using `docker`** &nbsp; [<img align="center" src="https://img.shields.io/badge/Docker-2CA5E0.svg?style={badge_style}&logo=docker&logoColor=white" />](https://www.docker.com/)

```sh
❯ ./vendor/bin/sail up -d
```


###  Testing
Run the test suite using the following command:

```sh
❯ ./vendor/bin/sail pest --parallel
```

---

## 📌 Technical Test

Crie uma API RESTful para gerenciar **lugares (places)** com as seguintes funcionalidades:

- Criar um lugar
- Editar um lugar
- Obter um lugar específico
- Listar lugares com filtro por nome

---

## 🧾 Estrutura do Lugar

Cada lugar deve conter os seguintes campos:

| Campo       | Tipo    | Descrição                |
|-------------|---------|--------------------------|
| `name`      | string  | Nome do lugar            |
| `slug`      | string  | Slug gerado automaticamente |
| `city`      | string  | Cidade do lugar          |
| `state`     | string  | Estado do lugar          |
| `created_at`| datetime| Data de criação          |
| `updated_at`| datetime| Data de atualização      |

---

## ⚙️ Tecnologias obrigatórias

- Laravel 12
- PostgreSQL
- Docker (para ambiente de teste)
- JSON como formato de resposta da API

---

## 🧪 Requisitos e Recomendações

- ✅ Todas as respostas da API devem estar no formato **JSON**
- ✅ Fornecer um ambiente Docker funcional com PostgreSQL
- ✅ README com instruções completas (como executar, endpoints, etc.)
- ✅ Código e nomenclaturas em **inglês**
- ✅ Escreva **testes** automatizados

---

##  Project Structure

```sh
└── sgbr-technical-test/
    ├── README.md
    ├── app
    │   ├── Constants
    │   ├── Http
    │   ├── Models
    │   ├── Providers
    │   └── Traits
    ├── artisan
    ├── bootstrap
    │   ├── app.php
    │   ├── cache
    │   └── providers.php
    ├── composer.json
    ├── composer.lock
    ├── config
    │   ├── app.php
    │   ├── auth.php
    │   ├── cache.php
    │   ├── cors.php
    │   ├── database.php
    │   ├── filesystems.php
    │   ├── logging.php
    │   ├── mail.php
    │   ├── queue.php
    │   ├── sanctum.php
    │   ├── services.php
    │   └── session.php
    ├── database
    │   ├── .gitignore
    │   ├── factories
    │   ├── migrations
    │   └── seeders
    ├── docker-compose.yml
    ├── phpunit.xml
    ├── public
    │   ├── .htaccess
    │   ├── favicon.ico
    │   ├── index.php
    │   └── robots.txt
    ├── resources
    │   └── views
    ├── routes
    │   ├── api.php
    │   ├── auth
    │   ├── console.php
    │   └── web.php
    ├── storage
    │   ├── app
    │   ├── framework
    │   └── logs
    └── tests
        ├── Feature
        ├── Pest.php
        ├── TestCase.php
        └── Unit
```
