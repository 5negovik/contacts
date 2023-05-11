Задача: Реализовать онлайн версию телефонной книжки со следующим функционалом:

- Авторизаванный пользователь может Создавать/Редактировать/Удалять свои контакты;
- Каждый контакт имеет следующие поля: ФИО, Телефон, Электронная почта, Дата рождения;
- Поиск контакта по фрагменту любого из полей контакта (ФИО, Телефон, Электронная почта, Дата рождения);
- На электронную почту пользователя указанную во время авторизации, отправляются уведомления о контактах, у которых сегодня день рождение;
- Ввод и вывод данных осуществляется в формате REST API;

Пример запросов и ответов из Postman:
https://documenter.getpostman.com/view/27228134/2s93eWzsNM

______________________________________________________
1. Установите последнюю версию Laravel (Laravel 10)<br>
composer create-project laravel/laravel contacts

2. Запустите миграцию с сидами<br>
php artisan migrate --seed

3. Для теста создайте себе аккаунт в ручную в таблице Users или раскоментируйте часть кода в файле Controller

4. Для теста отправки уведомлений на электронную почту пользователя используйте принудительный запуск расписания<br>
php artisan schedule:run



![image](https://user-images.githubusercontent.com/76124337/236428870-86393f81-9943-47d8-9403-fed876db1fcd.png)
