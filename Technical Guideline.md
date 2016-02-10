For running the project the following notes should be considered:

• For Creating the Database and testing data:
– open the database-initiation folder situated in the root of the project.
– run the file exercera table creation-v2
– run the file exercera data initiation-v2.sql
– Change the hoster, username and the password of your Mysql inside the file public/includes/db config.php

• Internet Connection
we load the libraries of Angular JS using online lnks. From the other side, UserApp cloud service is needed for logging and other user manage- ment stuffs. So, Internet connection is required.

• Deployment issue
Please, Consider that deploying the project in nested folder of the server, the htdocs for MAMP, could cause problems. these problems would be solved by deploying the folders and files of the project in the root folder of the server, htdocs in the case of MAMP. Another solution is to review the parameters of routing AngularJS found in Public/JS/app.js.
Make sure also to add the word public after the localhost link. Your link to the application would be something close of : ’http://localhost:8888/public/ ’

• Platform issue
Please, make sure to use local server, MAMP as an example, with PHP
5.5 .

• Connection Database
we have prepared a lot of test of database transactions, you can con- sult them by going to the Public/test folder or navigating a link similar to http://localhost:8888/public/test/ which is used in our case.
