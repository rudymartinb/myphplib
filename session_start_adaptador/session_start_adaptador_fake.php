<?php
namespace session_start_adaptador {
    use session_variable_adaptador\session_data_fake;
    use session_variable_adaptador\session_variable_adaptador_interface;
    
    class session_start_adaptador_fake implements session_start_adaptador_interface  {
        private $status = PHP_SESSION_NONE;
        private $name = "";
        private $valores = [];
        
        function inicio(){
            $this->status = PHP_SESSION_ACTIVE;
        }
        function estado(){
            return $this->status;
        }
        function nombre( $name ){
            $this->name = $name;
        }
        function esta_registrada( $name  ){
            return $this->name == $name;
        }
        
        function data_set( $nombre, $valor ){
            $this->valores[ $nombre ] = $valor ;
        }
        
        function data_get( $nombre ) {
            if( array_key_exists( $nombre, $this->valores ) )
                return $this->valores[ $nombre ];
            return "";
        }
        
        function data_unset( string $clave ){
            if( array_key_exists( $clave, $this->valores ) )
                unset( $this->valores[ $clave ] );
        }
        
        function unset(){
            $this->valores = [];
        }
        
        function destroy(){
            $this->status = PHP_SESSION_NONE;
            $this->valores = [];
        }
        public function get_data() : session_variable_adaptador_interface  {
            $data = new session_data_fake();
            return $data;
        }
    
    
        
    }
}
?>