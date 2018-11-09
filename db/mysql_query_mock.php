<?php


namespace mysql_wrapper {
    
	class mysql_query_mock implements proveedor_datos_query {
		private $adevolver = [];
		protected $debug;
		
		protected function __construct( ){
		}
		public function start_debug(){
		    $this->debug=true;
		}
		public function stop_debug(){
		    $this->debug=false;
		}
		
		public static function Builder(){
		    
		    return new class extends mysql_query_mock {
		        public function setDebug( $debug ){
		            $this->debug = $debug;
		            return $this;
		        }
		        public function build(){
		            $mock = new mysql_query_mock();
		            $mock->debug = $this->debug;
		            return $mock;
		        }
		    }; 
		}
		
		public function esperar( $query, Callable $devolver ){
			$this->adevolver[] = [ "query" => $query, "devolver" => $devolver ];
		}

		
		public function ejecutar( $query ){
		    if( $this->debug ){
		        var_dump( $query );
		    }
		    
			foreach( $this->adevolver as $key => $value ){
				if( $value["query"] == $query ){
					$devolver = $value["devolver"];
					unset( $this->adevolver[ $key ] );
					$ret = $devolver();
					if( $this->debug ){
					    var_dump( $ret );
					}
					return $ret;
				}
				
			}
		}
	
	}
}
?>