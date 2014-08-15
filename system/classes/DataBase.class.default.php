<?php
/* DEFAULT DATABASE FILE
	fill the constants
	and rename the file without the ".default"
*/
class DataBase {
	private $PDOInstance = null;
	private static $instance = null;
	private static $nbrOfQuery = 0;
	private static $nbrOfInstance = 0;

	# server const 
	const DEFAULT_SQL_USER = '';			# TO FILL
	const DEFAULT_SQL_HOST = '';			# TO FILL
	const DEFAULT_SQL_PASS = '';			# TO FILL
	const DEFAULT_SQL_DTB  = '';			# TO FILL
	
	public static function getNbrOfQuery() {
		return self::$nbrOfQuery;
	}
	public static function getNbrOfInstance() {
		return self::$nbrOfInstance;
	}

	private function __construct() {
		try {
			$pdoOptions[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$pdoOptions[PDO::ATTR_EMULATE_PREPARES] = FALSE;
			# $pdoOptions[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
			$this->PDOInstance = new PDO(
				'mysql:dbname=' . DataBase::DEFAULT_SQL_DTB . ';host=' . DataBase::DEFAULT_SQL_HOST . ';charset=utf8', 
				DataBase::DEFAULT_SQL_USER, 
				DataBase::DEFAULT_SQL_PASS, 
				$pdoOptions
			);
		} catch (PDOException $e) {
			echo 'Erreur de connection à la base de donnée : ' . $e->getMessage();
			exit();
		}
	}

	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new DataBase();
			self::$nbrOfInstance++;
		}
		return self::$instance;
	}
	
	public function query($query) {
		self::$nbrOfQuery++;
		return $this->PDOInstance->query($query);
	}
	public function prepare($query) {
		return $this->PDOInstance->prepare($query);
	}
	public function execute($query) {
		self::$nbrOfQuery++;
		return $this->PDOInstance->exec($query);
	}
	public function lastInsertId() {
		return $this->PDOInstance->lastInsertId();
	}
	public function quote($query) {
		return $this->PDOInstance->quote($query);
	}
}