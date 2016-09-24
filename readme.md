# Installation of project
step 1) download project from https://github.com/javulorg/javul <br/>
step 2) create database and add database information into .env file <br/>
step 3) cd project_name <br/>
step 4) composer install <br/>
step 5) go to project_name/app/Providers/. open file "ViewComposerServiceProvider.php" comment all code of public function boot() <br/>
step 6) run php artisan migrate <br/>
step 7) php artisan db:seed <br/>
step 8) go to project_name/app/Providers/. open file "ViewComposerServiceProvider.php" uncomment all code of public function boot() <br/>


login credentials : <br/>
email : admin@javul.org<br/>
password : 123456 <br/>
