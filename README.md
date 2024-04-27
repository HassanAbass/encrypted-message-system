# Laravel Encrypted Messaging API

This Laravel project provides a RESTful API for encrypted messaging. Users can register, login, create encrypted messages, and decrypt messages using provided encryption keys.

Both the sender/receiver of messages needs to be registered in system(could be changed) but in our case you register both users,
user can register account and login, create his own message with expiry date, it will be encrypted using `AES-256-CBC` algorithm.
recipient could decrypt it using the same key it was encrypted with.

## Features
- User authentication (Login/Register)
- Create encrypted messages
- Decrypt messages with provided encryption keys

## Requirements
- PHP >= 8.2
- Laravel >= 11.x
- Composer
- Redis

## Installation

1. Clone and initialize the repository:

   ```bash
   git clone git@github.com:HassanAbass/encrypted-message-system.git
   cd laravel-encrypted-messaging
   composer install
   cp .env.example .env
   php artisan key:generate

2. Connect you database of your choice in your `.env` file, **uncomment and add your credentials**:
    ```bash
    #DB_HOST=127.0.0.1
    #DB_PORT=3306
    #DB_DATABASE=db_name
    #DB_USERNAME=root
    #DB_PASSWORD=
3. Run migration command to create your tables
    ```bash
   php artisan migrate
4. Setup passport(oauth2) for authentication
    ```bash
    php artisan passport:client --personal --no-interaction
5. Seed your database(optional) with user or create them(register endpoint)
    ```bash
    php artisan db:seed
6. configure queue worker in your `.env` file, I'm using redis but feel free to add any other queue such as sqs
    ```bash
    REDIS_CLIENT=predis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
7. Start the queue worker to delete the expired messages:
    ```bash
   php artisan queue:work
8. You can start serve the application
    ```bash
   php artisan serve

# API Routes

### Messages
- `POST api/messages`
    - Description: Store a message.
    - Controller: MessageController@store

- `POST api/messages/decrypted`
    - Description: Get decrypted message.
    - Controller: MessageController@getMessage
### Users
- `POST api/users/login`
    - Description: User login.
    - Controller: AuthController@login
- `POST api/users/register`
    - Description: Register a new user.
    - Controller: AuthController@register


# Application Architecture Overview

This Laravel application follows a structured architecture pattern with three main components:

1. **Controller**: Responsible for handling incoming HTTP requests and controlling the flow of data.

2. **Service**: Contains the application's business logic, orchestrates interactions between components, and abstracts complex operations.

3. **Repository**: Provides an abstraction layer for database operations, promoting code maintainability and decoupling database logic from the rest of the application.

This architecture ensures maintainability, scalability, and separation of concerns, making the application easier to develop, test, and maintain.

