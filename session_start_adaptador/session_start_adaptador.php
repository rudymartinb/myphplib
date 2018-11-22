<?php
namespace session_start_adaptador {
    use session_variable_adaptador\session_variable_adaptador; 
    use session_variable_adaptador\session_variable_adaptador_interface;
    class session_start_adaptador implements session_start_adaptador_interface  {
        private $status ;
        private $name = "";
        private $valores = [];
        
        function inicio(){
            session_start();
        }
        
        function estado(){
            return session_status();
        }
        function nombre( string $name ){
            session_name( $name );
        }
        function esta_registrada( string $name  ){
            return isset( $_SESSION[ $name ] );
        }
        
        function unset(){
            session_unset();
        }
        
        function destroy(){
            session_destroy();
        }
        public function get_data() : session_variable_adaptador_interface {
            $data = new session_variable_adaptador();
            return $data;
        }
    
        
    }
    

}
?>