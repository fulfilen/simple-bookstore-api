<?php 
namespace App\Helpers;

use PDO;

class Database
{
	protected $pdo;

	public function __construct()
	{
		$options = [ 
            PDO::ATTR_PERSISTENT => true, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

		try {

			$this->pdo =  new PDO( 'mysql:host=' . Config::get('db.host') . '; dbname=' . Config::get('db.database'), Config::get('db.username'), Config::get('db.password'), $options);
		} 
		catch (PDOException $e) {

			die('Error: ' . $e->getMessage() );
		}
	}
	
	public function instance()
	{
		return $this->pdo;
	}

}