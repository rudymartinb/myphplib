<?php


namespace mylib {

	class mysql_query_mock implements proveedor_datos_query {
		private $adevolver = [];
		public function esperar( $query, Callable $devolver ){
			$this->adevolver[] = [ "query" => $query, "devolver" => $devolver ];
		}

		
		public function ejecutar( $query ){
			foreach( $this->adevolver as $key => $value ){
				if( $value["query"] == $query ){
					$devolver = $value["devolver"];
					unset( $this->adevolver[ $key ] );
					return $devolver();
				}
				
			}
		}
	
	}
}
?>