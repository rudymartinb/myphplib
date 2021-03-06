<?php
error_reporting(E_ALL);
/*
 * esto tiene sentido para las pruebas que corren localmente o en un servidor fijo.
 */
class DemoUsuarioSQL implements mysql_wrapper\credenciales {
	private static $user = ""; 
	private static $pwd = "";

	function __construct(){
	    $todo = file_get_contents( "/.creds/local.mysql.cred" );
	    $user = explode( PHP_EOL, $todo );
	    $list = [];
	    $list["user"] = "";
	    $list["pwd"] = "";
	    
	    foreach( $user as  $dato ){
	        $parte = explode( "=", $dato );
	        if( count( $parte ) != 2 )
	            break;
	        $list[ $parte[0] ]  = $parte[1] ;
	    }
	    
	    self::$user = $list["user"];
	    self::$pwd  = $list["pwd"];
	}
	
	public function get_user(){ 
		return self::$user;	
	}
	public function get_pwd() { 
		return self::$pwd;	
	}
	
}

class DemoServidorSQL implements mysql_wrapper\host {
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