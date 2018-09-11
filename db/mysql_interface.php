<?php
namespace mylib {
	
	/* lo optimo hubiera sido 
	 * q estas interfaces formen parte de la clase mysql_wrapper
	 * pero php no lo permite
	*/ 
	interface proveedor_datos_sql {
		// public function abrir( credenciales_host $cred  );
		public function abrir( credenciales $usuario, host $servidor );
		public function ejecutar( $query );
		public function cerrar( );
	}	
	
	/* esto es una mezcla de credenciales 
	 * e info de host de server
	 * la idea es externalizar la implementacion en particular
	 * ejemplo: que dichos datos sean extraido de un archivo ini
	 * o que la info devuelta sea dinamica en funcion del usuario que se loguea
	 * interface credenciales_host extends credenciales, host {	}
	*/
	

	interface credenciales {
		public function get_user();
		public function get_pwd();
	}
	
	
	interface host {
		public function get_host();
		public function get_catalogo();
		public function get_port();
	}

}
?>