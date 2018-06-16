# ArtHouse.Ru
Что бы развернуть сайт, необходимо выполнить следующие команды:

Получаем библиотеки необходимых версий
```
composer update
```

Инициализируем конфиги, первоначально задав необходимые параметры в environments
```
php init
```

Выполняем миграции
```
php yii migrate
```

Создаем необходимую структуру ролей Rbac
```
php yii rbac-manager/init-roles
```

После необходимо добавить пользователя (админа) для авторизации в панели управления:
```
php yii user/create <email> <username> [password] MASTER
```

Основные параметры:
```
common/config/params.php
------------------------
countDaysForMoveNewsToArchive - Кол-во дней, после которых новость будет автоматически архивированна
```

```
common/config/params-local.php
------------------------
authorRequestNotificationEmail - Email для уведомлений администратора о новой заявке в авторы
contactEmailSource - Email адрес, который будет написан в отправителе письма
```

```
common/config/main-local.php
------------------------
backendUrlManager.baseUrl - Ссылка до панели управления сайтом
frontendUrlManager.baseUrl - Ссылка до публичной части сайта
modules.user.fromEmail - Email адрес, который будет написан в отправителе письма
```

```
frontend/config/params-local.php
------------------------
homePage.countLastWorks - Кол-во работ выводимых на главной странице в разделе последних работ
```

Консольные команды
```
php yii utils/news-archive - запуск архивации новостей
```