This folder is the container of our code, the folder itself is created by UserApp and we had to move all our codes to it. The folder contains the following folders:


• CSS and Img Folders:

These folders contains the scripts and the images necessary to create the visual identity of the website.

• Includes Folder

It includes the files for configuring the encoding and the connection to the database.

• AJAX Folder

This folder can be considered as a part of the model layer. It contains more than 30 Php files responsible of doing all the CRUD operation against the database.
the typical content of these files is: creating an instance of the connection with the database, preparing some query, executing the query inside ex- ception handler, and returning the value of the query.

One example: the ’category get all.php’ provide the service to get all the categories from database. It serves for displaying the side bar at front-end pages.
To carry out the CRUD operations, we use the mysqli, an improvement of mysql api, with object oriented approach to do the tasks. The ajax services also handle the error when dealing with database.

For some complex operations that have to work with multi table, we use the transaction management to assure the stable of the system.
To avoid the duplication of database connection, we also apply the single- ton pattern. This pattern is implemented in the “includes/db instance.php” file. Whenever using a database connection, the system will check whether it is initiated, if yes, it will be reused, otherwise, it will be created.
For data transfer between client and server, we use the json data format.

• Test Folder

This folder can be considered as a part of testing the model layer. It con- tains more than 20 Php files responsible of testing all the CRUD operation
10
against the database.
It was used during the development of the AJAX Folder.

• Partials Folder

This folder contains all the Html files of the interface except the index which exists at the root of Public folder and which is the start page of the application. The partials are very elegant Html files because of the Anjgular JS annotations.

Constants folder contains the files of the header, the footer and the sidebar file which don’t refresh their content most the time.
Tabs folder contains html hooks for the page of showing a single exer- cise, ’Partials/exercise.html’ , which is the most complicated page of the application.
They were created to keep the elegance of other pages and to keep the high readability of the code. the partial folders contains also predefined html pages for the UserApp functionalities as set-password.html

• JS Folder

This folder contains the AngularJS codes. It contains only 4 files which conclude the most critical part of our work.

– App.js File

In this file we declare the main module of the whole application, myApp. We link this module with other modules, In technical words, we create its dependencies which are declared in the other files, such as controllers and directives, or predefined ones, such as routing mod- ule.

In this file we also configure the routing of views for directing the links to the appropriate pages and add the parameters of UserApp for controlling the visibility of pages according to the given permis- sions.
The last section of this file is for linking the UserApp id with our application.

– Directives.js FIle

In this file we declare multiple directives for linking the ’index.html’ with the files of constants folder or for linking the ’exercixe.html’ with the files of Constant folder.
For the first directive nothing important exists in the controllers of the directives. but in the second linking, for directives, such as exre- views or exsolutions, the controller read user request, handle it and return the suitable response. It either add a solution, a review or report an exercise or other similar requests.
The technical concepts used in this directive is pretty simple, where all what we do is to parse data, invoke a service and show the result by writing the right expression.

– Controllers.js File

This file contains multiple controllers for creating the business logic of the partials pages. Each controller offer one or more functionalities invoked in the scope of the controller.

The accountCtrl for example is responsible for updating the personal information of users by doing a convocation of one function of User- App API.
The exsController is used to invoke the http service for retrieving the required data for displaying a list of the exercises . The ex controller contains the code for invoking the http service for retrieving the re- quired data for displaying the given exercise and other functions for controlling the behavior of exercises tabs.

To carry out the data get and request, we use the $http built-in module of AngularJS. The front-end home page is divided into several parts, each one in angularjs is called a directive. Each directive have its own controller. In the figure above, the controller of exsidebar is use to load the categories from database by using ajax service category get all.php. The response data is under the json format and is bind to $scopy.categories.

• Root files

the files found at the root of the project are either lo files for recording the some information by Angular JS and UserApp or php files for loading and configuring the UserApp