<?php
error_reporting(E_ALL);


function leercreds() : Array {
	$todo = file_get_contents( $_SERVER["HOME"]."/.creds/local.mysql.cred" );
	$user = explode( PHP_EOL, $todo );
	$lista = [];
	foreach( $user as  $dato ){
		$parte = explode( "=", $dato );
		$lista[ $parte[0] ]  = $parte[1] ;
	}
	return $lista;
}


class DemoUsuarioSQL implements myphplib\credenciales {
	private static $user = ""; 
	private static $pwd = "";
	
	public function get_user(){ 
		if( self::$user == "" ){
			$this->leercreds();
		}
		
		return self::$user;	
	}
	public function get_pwd() { 
		if( self::$pwd == "" ){
			$this->leercreds();
		}		
		
		return self::$pwd;	
	}
	
	public function leercreds() {
		$list = leercreds();
		self::$user = $list["user"];
		self::$pwd  = $list["pwd"];
		
	}
}

class DemoServidorSQL implements myphplib\host {
	private $host = "127.0.0.1";
	private $port = 3306;
	private $catalogo = "";	
	
	public function get_host(){ 
		return $this->host;	
	}
	public function get_catalogo(){ 
		return $this->catalogo;	
	}
	public function set_catalogo( $cat ){ 
		$this->catalogo = $cat;	
	}
	public function get_port(){ 
		return $this->port;	
	}
}
?>