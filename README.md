# Mongol 

A RESTful Interface to MongoDB.

*This is an experimental project that I hacked up in about 4 hours.  It is no where near even beta quality code. I hope to have time to flesh this out more later.*

Future Plans:

* Accept json input from raw body
* API key based authentication
* A more robust query interface
* Content Negotiation to also support xml, serialized php, and html output based on accept headers and url file extensions.
* Cross Origin support
* Better Documentation

## Requirements

* Apache
	* mod_rewrite
* PHP
	* PHP 5.3+
	* json extension
* MongoDb

## Installation

Just drop or clone entire project into your DOCUMENT_ROOT.


## Usage

### List databases

    GET /dbs - List all databases on the server

### List collections in a database

    GET /:db  - Will list all collections belonging to :db

E.g.   

    /blog

### Query a collection
   
    GET /:db/:collection

E.g.  

	/blog/posts
	/blog/posts?limit=10&skip=0
	/blog/posts?limit=10&skip=10&author=bob&category=php

Arguments: 

* skip  
* limit

Any additional arguments will be treated as AND query parameters

### Insert a document to a collection

    PUT /:db/:collection

The data to be entered into the collection must be sent as request parameters.
The content-type must be:  

    application/x-www-form-urlencoded

### Update a document in a collection

    POST /:db/:collection/:id

The data to be entered into the collection must be sent as request parameters.
The content-type must be:  

    application/x-www-form-urlencoded

### Delete a document from the collection

	DELETE /:db/:collection/:id