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

	/*
	* [PRIVATE] Create an Object (array) using a mongoCursor.
	*/
	private function createObjects($mongoCursor){
		$resultSet = array();
		while($mongoCursor->hasNext())
			$resultSet[] = $mongoCursor->getNext();
		return $resultSet;
	}

	/*
	* [PRIVATE] Create an array for search purposes;
	*/
	private function createArray($index, $value){
		if($index == 'id')
			return array('_id' => new MongoID($value));
		else
			return array($index => $value);
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

	public function get($index, $value){
		$mongoCursor = $this->collection->find(self::createArray($index, $value));
		return self::createObjects($mongoCursor);
	}

	public function getAll(){
		$mongoCursor = $this->collection->find();
		return self::createObjects($mongoCursor);
	}

	public function delete($field, $value, $justOne = FALSE){
		$c = $this->collection->remove(self::createArray($field, $value), self::createArray('justOne', $justOne));
		return $c;
	}
}
 #
 # Exemplo de uso do PDOMongo passando o host e o banco de dados
 #
/*
$host = 'localhost';
$database = 'test';
$t = new PDOMongo($host,$database);
$t->setCollection('things');
var_dump($t->get('id','51b6a1a2082d86d6c66faaae'));
*/

 #
 # Exemplo de uso do PDOMongo com valores padroes
 #
/*
$t = new PDOMongo();
$t->setDatabase('test');
$t->setCollection('things');
var_dump($t->get(array('a'=>1)));
var_dump($t->get('id','51b6a1a2082d86d6c66faaae'));
*/
?>
