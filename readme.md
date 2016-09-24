# Installation of project
 1) download project from https://github.com/javulorg/javul <br/>
 2) create database and add database information into .env file <br/>
 3) cd project_name <br/>
 4) composer install <br/>
 5) go to project_name/app/Providers/. open file "ViewComposerServiceProvider.php" comment all code of public function boot() <br/>
 6) run php artisan migrate <br/>
 7) php artisan db:seed <br/>
 8) go to project_name/app/Providers/. open file "ViewComposerServiceProvider.php" uncomment all code of public function boot() <br/>


login credentials : <br/>
email : admin@javul.org<br/>
password : 123456 <br/>
