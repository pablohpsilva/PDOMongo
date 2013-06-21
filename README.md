PDOMongo
========

PDO (PHP Data Object) for MongoDB.

How to use
---------

There are some ways to use PDOMongo. Two simple examples are these:

* Simplest
	$t = new PDOMongo();
	$t->setDatabase('test');
	$t->setCollection('things');

* Regular
	$host = 'localhost';
	$database = 'test';
	$t = new PDOMongo($host,$database);
	$t->setCollection('things');