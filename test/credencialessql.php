<?php
error_reporting(E_ALL);




class DemoUsuarioSQL implements mylib\credenciales {
	private $user = "root";
	private $pwd = "wolfrein";
	
	public function get_user(){ 
		return $this->user;	
	}
	public function get_pwd(){ 
		return $this->pwd;	
	}
}

class DemoServidorSQL implements mylib\host {
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