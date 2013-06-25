<?php

/*
 * Desenvolvido por: Pablo Henrique Penha Silva
 * Github: pablohenrique
 */

class PDOMongo{
	private $database;
	private $connection;
	private $collection;

	public function __construct($host = 'localhost:27017', $database = null, $username = null, $password = null, $dbauth = 'admin'){
		try{
			$serverString = "mongodb://";
			if(is_null($username))
				$serverString .= $host . "/" . $dbauth;
			else
				$serverString .= $username . ":" . $password . "@" . $host . "/" . $dbauth;

			$this->connection = new MongoClient($serverString);
			self::setDatabase($database);
		}
		catch(MongoConnectionException $e){
			throw new Exception($e);
		}
	}

	// Create a object from a MongoCursor.
	private function createObjects($mongoCursor){
		$resultSet = array();
		while($mongoCursor->hasNext())
			$resultSet[] = $mongoCursor->getNext();
		return $resultSet;
	}

	// Create an array given an attribute and a value.
	// PHP Mongo uses a special way to create an array given an ID.
	private function createArray($attr, $value){
		if($attr == 'id')
			return array('_id' => new MongoID($value));
		else
			return array($attr => $value);
	}

	public function setDatabase($input){
		if(!is_null($input))
			$this->database = $this->connection->selectDB($input); 
	}

	public function setCollection($input){
		if(!is_null($input))
			$this->collection = $this->database->selectCollection($input); 
	}

	// Use it when you need to call a method directly from 
	// MongoClient that the PDOMongo doesn't support.
	public function getConnection(){ return $this->connection; }

	// Use it when you need to call a method directly from 
	// MongoCollection that the PDOMongo doesn't support.
	public function getCollection(){ return $this->collection; }

	// Use it when you need to call a method directly from 
	// MongoDB that the PDOMongo doesn't support.
	public function getDatabase(){ return $this->database; }

	//  Creates an index on the given field(s), or does nothing if the index already exists
	public function ensureIndex($args){ return $this->collection->ensureIndex($args); }

	public function insert($document){ $this->collection->insert($document); }

	public function update($oldDocument, $newDocument){ $this->collection->update($oldDocument, $newDocument); }

	public function get($attr, $value){
		$mongoCursor = $this->collection->find(self::createArray($attr, $value));
		return self::createObjects($mongoCursor);
	}

	public function getAll(){
		$mongoCursor = $this->collection->find();
		return self::createObjects($mongoCursor);
	}

	public function delete($attr, $value, $justOne = FALSE){
		$c = $this->collection->remove(self::createArray($attr, $value), self::createArray('justOne', $justOne));
		if($c['n'] == 0)
			throw new Exception('Deletion wasn\'t possible.'); 
	}
}
?>
