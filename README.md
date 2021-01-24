## About this app.
WP4Chat is a Single Page Web Application for chatting, using [Laravel framework](https://laravel.com/) and [Vue.js](https://vuejs.org/) as a group project for my for my university. I created this Web App as for educational purpose, when I was creating it, I still don't have much experience with Laravel and Vue.js yet. You're free to use it or criticize about it. Also this web app is in Lao language you might need to edit some part of the code to change it, but the code follow the convention of naming (I think) so it might be kinda easy to find and change it (I think)

### Installation
- clone this project.
- run these commands to install pakages.
```
composer install
npm install
```
- copy file .env.example and save it as .env file in the same folder.
- edit DB part in .env file according to database in your machine. (you should create new database for it).
- edit PUSHER part in .env file. this part you may need to have pusher account and create an app in pusher web site in order to use it, then edit it according to your created app. (but you can use others Web Socket server if you need to).
- after that you can run this command to compile JavaScript.
```
npm run dev
```
- migrate database.
```
php artisan migrate
```
- start your localhost server.
```
php artisan serve
```


## License

[MIT license](https://opensource.org/licenses/MIT).
