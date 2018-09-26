# Simple-bookstore-api
A basic RESTFUL API for Creating, Reading, Updating, Deleting &amp; Rating books from  a bookstore

# What's inside?
The entire API is inside index.php, but it's using the micro framework Slim and an authentication module. The .htaccess creates these nice-looking URLs like /api/test, that's actually part of Slim.

# Requirements
*PHP 7.0 or higher
* PDO drivers for MySQL
* A web server with URL rewriting
* [Composer](https://getcomposer.org) for downloading dependecies

# Installation
### Clone Project
 ``` 
 git clone https://github.com/fulfilen/simple-bookstore-api.git
 ```
### Install all composer depencies
 ``` 
 $ cd project-folder && composer install 
 ```
### Import database
 ``` 
 create a MYSQL database and import Bookstore-api.sql 
 ```
 
# Configuration 
 Locate and edit App/settings.php
 
 ```
return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'db' => [
            'driver'    =>  'mysql',
            'host'      =>  'localhost',
            'database'    => 'bookshop-api',
            'username'  =>  'root',
            'password'  =>  '',
            'collation' =>  'utf8_general_ci',
            'charset'   =>  'utf8',
            'prifix'    =>  '',
        ],

        //JWT KEY
        'jwt' => [
            'secret'    => '1a2b3c4d5e6f',
            'attribute' => 'decoded_token_data',
            'algorithm' => ["HS256"],
            'secure' => false,
        ],
    ],
];
```
# Instruction
You must register & login to authorization token
* To register, send a POST request to
```
POST /register
```
with a body containing:

``` 
{
    "username": "your username",
    "email": "email address",
    "password": "password"
} 
```

And it will return a success message

* To login, send a POST request to
```
POST /login
```
with a body containing:

``` 
{
    "email": "email address",
    "password": "password"
} 
```

And it will return a success message plus an authorization token


# Note

You have to send your include authorization token in header when require:
### key
```
Authorization
```
### Value
```
Bearer Xhsb2FkZWRAZ21haWwuY29tIn0.Rr3LuCCsPqTnFiQSwth7A5Bjqyq8AUmqeo5J3NIFI5U
```

# Usage 
The CRUD + List operations below act on this table

### Create
* Authorization token require!
* To add a book, the request can be written in URL format as:

``` 
POST /book
```
You have to send a body containing:

``` 
{
    "title": "Book Title",
    "author": "Book Author",
    "desc": "Book description"
} 
```

And it will return a success message

### Read
To read a record, the request can be written in URL format as:

``` 
GET /book/1
```
Where "1" is the value of the primary key of the record that you want to read. It will return:

``` 
{
    "id": Book id
    "title": "Book title",
    "author": "Book author",
    "desc": "Book description.",
    "rating": "average rating"
} 
```

### Update 
* Authorization token require!
* To update a record in this table the request can be written in URL format as:
```
PUT /api/book/1
```
Where "1" is the value of the primary key of the record that you want to update.
You have to send a body containing:

``` 
{
    "title": "New Book Title"
} 
```

### Delete
* Authorization token require!
* To delete a record, the request can be written in URL format as:
```
DELETE /api/book/1
```
Where "1" is the value of the primary key of the record that you want to update. It will return a success response


### List
To list all records, the request can be written in URL format as:
```
GET /books
```
It will return:
 ```
 {
    "data": [
        {
            "id": "1",
            "title": "Brandy of the Damned",
            "author": "Colin Wilson",
            "rating": "4"
        },
        {
            "id": "2",
            "title": "Blue Remembered Hills",
            "author": "Rosemary Sutcliff",
            "rating": "5"
        },
        {
            "id": "3",
            "title": "The Curious Incident of the Dog in the Night-Time",
            "author": "Mark Haddon",
            "rating": "3"
        }
    ]
}

 ```
### Rating
* Authorization token require!
* To rate a book, the request can be written in URL format as:
```
POST /api/rate/1/5
```
Where "1" is the id of the book you want to update and where 5 is the rating number (1 - 5 only)



