#### Foreword
The project is a typical e-shop application, that allows users to view any available products and make orders for buying them.
Our customers are allowed to sign up and log in to their own profile, which stores user orders and all added to cart products.
Adding products to cart, user can watch the total price of all products and the amount of each product.
Orders are made by one click.

#### Deployment
To deploy the application to any UNIX-machine, we need to follow steps, described below:
1. Create your project directory.
2. Make sure, that you are the owner of this directory and appropriate grants are set.
3. Clone the project repo to you current working directory.
4. Download needed extensions and dependencies, specified in _composer.json_ file(composer must be installed in your system).
5. Check, whether all your PHP-modules satisfy Yii2 requirements, by typing `php requirements.php`. If some of them are absent, install them to your PHP.
6. Once the application cloned and all dependencies installed, we're ready to run the application migrations: `php yii migrate`. 
___
**Before running migrations, make sure, that you manually created your project database and put appropriate database configuration to _config/db.php_**.
___
7. For test purposes, we don't need to configure Apache2, Nginx or another kind of web-servers. We're going to use standart built-in
Yii2-web-server, which is simply ran by typing `php yii serve`. In case the Yii2-debugger displays you traceback of errors, just follow all the recommendations, described in the debugger.
