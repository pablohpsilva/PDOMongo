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

Mongo getters and setters
========

	<?php
		// PDOMongo created with defaults values;
		$pdo = PDOMongo();
		
		//Setters
		$pdo->setDatabase('myDatabase');
		$pdo->setCollection('myCollection');
		
		$returnConnection = $pdo->getConnection();
		$returnDatabase   = $pdo->getDatabase();
		$returnCollection = $pdo->getCollection();
	?>

Manipulation Database Objects
========

	<?php
		// PDOMongo created with defaults values;
		$pdo = PDOMongo("https://myMongoDB.myHost.com","myDatabase","Admin","Password");
		$pdo->setCollection("myCollection");
		
		$element = array(
				'name' => 'PDOMongo',
				'detail' => 'Its a PDO to manipulate MongoDB for lazy people',
				'author' => 'pablohenrique'
			);
		
		$pdo->insert($element);
		
		$newElement = $element;
		$newElement['author'] = 'PabloHenrique';
		$pdo->update($element, $newElement);
		
		
		$returnObject = $pdo->get('name', 'PDOMongo');
		$returnObject = $pdo->get('id', 'd1827dsa9d8a67qwe8q09ueq817');
		$returnObjects = $pdo->getAll();
		
		//Still working on this one.
		$pdo->delete($f, $one = FALSE);
	?>

Thanks
========

Thanks for the PHP developers who created the Mongo classes for PHP.
