# 🚀 AI Proxy: Единый шлюз для ваших LLM

<div align="center">

[![GitHub Stars](https://img.shields.io/github/stars/ShaerWare/ai-proxy?style=for-the-badge&logo=github)](https://github.com/ShaerWare/ai-proxy/stargazers)
[![GitHub Issues](https://img.shields.io/github/issues/ShaerWare/ai-proxy?style=for-the-badge&logo=github)](https://github.com/ShaerWare/ai-proxy/issues)
[![License: MIT](https://img.shields.io/github/license/ShaerWare/ai-proxy?style=for-the-badge)](https://github.com/ShaerWare/ai-proxy/blob/main/LICENSE)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=for-the-badge)](http://makeapullrequest.com)
[![GitHub last commit](https://img.shields.io/github/last-commit/ShaerWare/ai-proxy?style=for-the-badge&logo=git)](https://github.com/ShaerWare/ai-proxy/commits/main)

</div>

> **Примечание:** Значки для Packagist (версия, загрузки, версия PHP) заработают после публикации вашего пакета на [Packagist.org](https://packagist.org/). Значок "Build Status" заработает после добавления GitHub Actions workflow с именем `tests.yml`.

Надежный прокси-сервер на Laravel, предназначенный для оптимизации и управления взаимодействием с различными API-сервисами искусственного интеллекта.

---

## ✨ О проекте

**AI Proxy** — это решение, которое выступает в роли посредника между вашими приложениями и внешними AI-сервисами (такими как OpenAI, Anthropic, Gemini и др.). Он позволяет централизованно управлять ключами, кэшировать запросы, вести аналитику и применять лимиты, снижая затраты и повышая надежность.

### 🎯 Ключевые возможности

-   **Централизованное управление API-ключами:** Храните все ключи в одном безопасном месте.
-   **Кэширование ответов:** Значительно снижает количество запросов к платным API и ускоряет получение повторных ответов.
-   **Аналитика и логирование:** Отслеживайте использование API, затраты и выявляйте ошибки.
-   **Ограничение скорости (Rate Limiting):** Защитите свои ключи от чрезмерного использования.
-   **Единый API-интерфейс:** Взаимодействуйте с разными AI-моделями через единую точку входа.
-   **Готов к развертыванию:** Поставляется с полной конфигурацией Docker для легкого запуска.

### 🛠️ Технологический стек

-   **Backend:** [Laravel 11](https://laravel.com/)
-   **База данных:** [PostgreSQL](https://www.postgresql.org/)
-   **Окружение:** [Docker](https://www.docker.com/) & [Docker Compose](https://docs.docker.com/compose/)
-   **Веб-сервер:** [Nginx](https.nginx.org/)

---

## 🚀 Начало работы

Эти инструкции помогут вам запустить копию проекта на локальной машине для разработки и тестирования.

### 📋 Предварительные требования

Убедитесь, что на вашей машине установлены:
-   [Git](https://git-scm.com/)
-   [Docker](https://www.docker.com/products/docker-desktop)
-   [Docker Compose](https://docs.docker.com/compose/install/)

### ⚙️ Установка для локальной разработки

1.  **Клонируйте репозиторий:**
    ```bash
    git clone https://github.com/ShaerWare/ai-proxy.git
    cd ai-proxy
    ```

2.  **Создайте `.env` файл:**
    Скопируйте файл с примером переменных окружения. Для локальной разработки стандартные настройки уже подходят.
    ```bash
    cp .env.example .env
    ```

3.  **Соберите и запустите Docker-контейнеры:**
    Эта команда запустит PHP, Nginx и PostgreSQL в фоновом режиме.
    ```bash
    docker-compose up -d --build
    ```

4.  **Установите PHP-зависимости:**
    Выполните `composer install` внутри контейнера `app`.
    ```bash
    docker-compose exec app composer install
    ```

5.  **Сгенерируйте ключ приложения:**
    ```bash
    docker-compose exec app php artisan key:generate
    ```

6.  **Выполните миграции базы данных:**
    Это создаст все необходимые таблицы в вашей локальной базе данных.
    ```bash
    docker-compose exec app php artisan migrate
    ```

7.  **Готово!**
    Приложение будет доступно по адресу [http://localhost:8080](http://localhost:8080).

---

## 🌐 Развертывание в Production

Для развертывания проекта на производственном сервере мы подготовили отдельное, исчерпывающее руководство. Оно включает настройку сервера, Nginx в качестве reverse proxy и получение SSL-сертификатов.

➡️ **[Читать полное руководство по развертыванию (DEPLOYMENT.md)](DEPLOYMENT.md)**

---

## 🤝 Участие в разработке

Мы приветствуем любой вклад в развитие проекта! Если вы хотите помочь, пожалуйста, следуйте этим шагам:

1.  Сделайте форк проекта.
2.  Создайте новую ветку для вашей фичи (`git checkout -b feature/AmazingFeature`).
3.  Внесите свои изменения и сделайте коммит (`git commit -m 'Add some AmazingFeature'`).
4.  Отправьте изменения в вашу ветку (`git push origin feature/AmazingFeature`).
5.  Создайте Pull Request.

---

## 📄 Лицензия

Этот проект распространяется под лицензией MIT. Подробности смотрите в файле `LICENSE`.

---

## 📞 Контакты

ShaerWare - [https://github.com/ShaerWare](https://github.com/ShaerWare)

Ссылка на проект: [https://github.com/ShaerWare/ai-proxy](https://github.com/ShaerWare/ai-proxy)