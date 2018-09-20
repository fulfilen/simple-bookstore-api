<?php
namespace App\Helpers;

class Config
{
	protected static $data;

	public static function load(array $file )
	{
		self::$data = $file;
	}

	public static function get( $path )
	{
		$data = self::$data; 
		$parts = explode( '.', $path );

		foreach( $parts as $part ) {

			if(isset($data[$part])) {

				$data = $data[$part];	
			} 	
		}
		return $data;
	}
}