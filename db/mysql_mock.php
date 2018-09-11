<?php


namespace mylib {

	class mysql_mock implements proveedor_datos_sql {
		private $adevolver = [];
		public function esperar( $query, $devolver ){
			$this->adevolver[] = [ "query" => $query, "devolver" => $devolver ];
		}
		public function abrir( credenciales $usuario, host $servidor ){
		}
		public function ejecutar( $query ){
			foreach( $this->adevolver as $key => $value ){
				if( $value["query"] == $query ){
					$devolver = $value["devolver"];
					unset( $this->adevolver[ $key ] );
					return $devolver;
				}
				
			}
		}
		public function cerrar( ){
		}
	
	}
}
?>