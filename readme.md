# Installation of projects
step 1) download project from https://github.com/javulorg/javul
step 2) rename .evn.example to .env file and add database information
step 3) cd project_name
step 4) composer install
step 5) go to project_name/app/Providers/. open file "ViewComposerServiceProvider.php" comment all code of public function boot()
step 6) run php artisan migrate
step 7) php artisan db:seed
step 8) go to project_name/app/Providers/. open file "ViewComposerServiceProvider.php" uncomment all code of public function boot()


login credentials : 
email : admin@javul.org
password : 123456 
