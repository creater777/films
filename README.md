Cайт на Yii2
---------------------------
Используется basic шаблон фреймворка Yii2. Сайт с авторизацией и регистрацией.

Установка
---------
1. Установка
   ```
   git clone https://github.com/creater777/films
   ```

2. Инициализация приложения
   ```
   php E:\OpenServer\modules\php\PHP-5.4\composer.phar install
   ```

3. Инициализация БД
   - Создать базу данных и прописать подключение в @app/config/db.php
   ```
   return [
       'class' => 'yii\db\Connection',
       'dsn' => 'mysql:host=localhost;dbname=filmsdb',
       'username' => 'root',
       'password' => '',
       'charset' => 'utf8',
   ];
   ```

   - Запустить миграцию
   ```
   php yii migrate/up
   ```

4. Инициализация rbac
   ```
   php yii migrate/up --migrationPath=@yii/rbac/migrations
   ```

5. Инициализация пользователей
   ```
   php yii rbac/init
   ```
После инициализации создадуться 2 пользователя:
  - moder с правами модератора и паролем moder
  - admin с правами администратора и паролем admin