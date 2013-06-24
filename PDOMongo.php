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
		catch(Exception $e){
			echo $e;
		}
	}

	private function createObjects($mongoCursor){
		$resultSet = array();
		while($mongoCursor->hasNext())
			$resultSet[] = $mongoCursor->getNext();
		return $resultSet;
	}

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

	public function getConnection(){ return $this->connection; }

	public function getCollection(){ return $this->collection; }

	public function getDatabase(){ return $this->database; }

	public function insert($f){ $this->collection->insert($f); }

	public function update($f1, $f2){ $this->collection->update($f1, $f2); }

	public function ensureIndex($args){ return $this->collection->ensureIndex($args); }

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
		return $c;
	}
}
?>
