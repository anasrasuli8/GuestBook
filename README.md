## About Guest Book

This a simple larave app that allow users to post messages and replies to that messages. it has login, registeration, welcome and home pages. 

## GuestBook

 GuestBook develped using Laravel + Vue.js.

The guest book allows site users to leave messages. All data entered by the user is stored in MySQL, the database schema must be formed by migrations. Only authorized users can post messages. Guestbook messages should be displayed no more than 25 pieces per page. Users can reply to already left guestbook messages. Answers should be hierarchically grouped, and be visually distinguished as answers. Users can edit their own messages as long as no one has replied to them.

The form for adding an entry to the guest book contains a text input field and a file attachment control.
The test should be no more than 1000 characters long, the picture should be no larger than 500 x 500, but not less than 100 x 100 pixels, if the picture is larger than the allowable size, it should be scaled down on the server while maintaining aspect ratio (optional). The file size should not exceed 100 Kb.

The form must be validated both on the front and the server side, all requests are made via fetch or ajax.

## Features
- Laravel 8
- Vue + VueRouter + Vuex + VueI18n + ESlint
- Pages with dynamic import and custom layouts
- Login, register, Welcome, and Home
- Authentication with Laravel Sanctum
- Bootstrap 4 and Bootsrap Vue


## Installation

composer create-project --prefer-dist anasrasuli8/GuestBookEdit
- .env and set your database connection details
- (When installed via git clone or download, run php artisan key:generate)
- php artisan migrate
- php artisan db:seed
- npm install

## Usage
Run Following Commands:
- php artisan serve
- npm run dev

       
