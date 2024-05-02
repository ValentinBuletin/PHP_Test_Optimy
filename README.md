# PHP test - Simple News application /w user Comments
This application provides a structured approach to manage news articles and comments in a MySQL database, with proper organization of classes, methods, and functionalities to handle database interactions effectively.

## 1. Installation
* create an empty database named "phptest" on your MySQL server
* import the dbdump.sql in the "phptest" database
* put your MySQL server credentials in the settings.ini file
* you can test the demo script in your shell: "php index.php"

## 2. Doc

* **class/Comment.php and class/News.php**:
These classes provide a blueprint for representing comments/news in a database. It encapsulates comment/news data and provides methods for setting and getting comment/news properties while enforcing type safety. It also leverages method chaining for convenient property assignment.

* **utils/CommentManager.php and utils/NewsManager.php**:
These two classes provide methods for listing, adding, and deleting comment/news entries from the database while ensuring proper error handling and database interaction using the DB class.

* **utils/DB.php**:
The DB class provides methods for establishing database connections, executing SQL queries, and retrieving results while handling exceptions and implementing the singleton pattern. It encapsulates database interaction functionalities for better code organization and reusability.

* **settings.ini**:
This file contains the settings that are commonly used to establish a connection to a MySQL database server using PHP's PDO (PHP Data Objects) extension. It provides essential information required for establishing a connection, including the database name, server location, port, and authentication credentials.

* **index.php**:
This script serves as a demonstration of how to display database data (news and associated comments) using the NewsManager and CommentManager classes. Additionally, it provides testing functions for both managers, allowing for validation of their functionality.

## 3. Changes

Please check *changes.txt* for a list of all the changes.
