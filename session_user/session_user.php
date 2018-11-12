<?php
namespace session_user {
    use session_data\session_data;
    use session_data\session_data_interface;
    class session_user implements session_user_interface  {
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
        public function get_data() : session_data_interface {
            $data = new session_data();
            return $data;
        }
    
        
    }
    

}
?>