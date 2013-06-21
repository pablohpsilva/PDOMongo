PDOMongo
========

PDO (PHP Data Object) for MongoDB.

How it works
========

PDOMongo is simple and stright forward as you can see below:

	<?php
		use PDOMongo;
		/*
		 * If you aren't using namespaces, use:
		 * require_once(__DIR__.'\PDOMongo.php');
		 */

		// Create a PDOMongo with default values
		$pdomongo = new PDOMongo(); 
		// Set the database
		$pdomongo->setDatabase('test');
		// Set the collection
		$pdomongo->setCollection('things');
	?>

Another example is showed below. For understand how to use another options, please, open the PDOMongo.php file and read the construction function.

	<?php
		use PDOMongo;
		/*
		 * If you aren't using namespaces, use:
		 * require_once(__DIR__.'\PDOMongo.php');
		 */

		$host = 'www.myDatabase.myHost.com';
		$database = 'mongoDatabase';
		// Create PDOMongo with custom values;
		$pdomongo = new PDOMongo($host,$database);
		// Set Collection
		$pdomongo->setCollection('things');
	?>
