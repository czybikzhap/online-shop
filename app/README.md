
 <h1 align="center">Сервис "Online shop"</h1> 
 
* Этот проект реализован с помощью **PHP 8.0**, **PostgreSql** и **Nginx**.


<!-- ABOUT THE PROJECT -->
## Описание проекта:

Здесь реализован интернет магазин, в котором представлен подробный каталог товаров с описанием и ценами на них, на основе которого пользователь сможет сформировать свой заказ, добавив их в свою корзину.



## Функционал сервиса:

* Регистрация пользователя, вход в личный кабинет и выход из него.
* При регистрации пользователя, отпралвяется запрос в БД на наличие уже существуещего E-mail, так же и при авторизации на соответствие введенных данных.
* Просмотр товаров на главной странице.
* Добавление товаров в корзину.
* Валидация при заполнении полей во время регистрации и авторизации, а также при добавлении товара в корзину.
* Просмотр корзины с отображением имени пользователя, количества товаров, общей стоимости определенного товара(-ов) и общей стоимости всей корзины.
* Удаление товаров из корзины или самой корзины в целом.


## Функционал проекта:

* реализовал свою маршрутизацию.
* реализовал шаблон проектирования MVC.
* реализовал autoloader.

# Чтобы запустить проект, выполните:

Создайте контейнеры:
>docker compose build

Запустите их:
>docker compose up -d

Проверьте созданные docker-контейнеры:
>docker ps

Готово.
