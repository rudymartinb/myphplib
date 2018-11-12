<?php
namespace derivador {
    class Derivador {
        private $lista = [];
        private $default = null;
        function __construct() {
            $this->default = function() {};
        }
        public function agregar( string $url, callable $funcion ){
            $this->lista[] = [ "url" => $url, "funcion" => $funcion ];
        }
        
        public function ejecutar( string $cual ){
            $funcion = $this->funcion( $cual );
            $funcion();
        }
        public function default( callable $funcion ){
            $this->default  = $funcion;
        }
        
        
        function funcion( string $url ) : callable {
            foreach( $this->lista as $value ){
                if( $value["url"] == $url )
                    return $value["funcion"];
            }
            return $this->default ;
        }
        
    }
}
?>