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
        
//         function data_set( string $nombre, $valor ){
//             global $_SESSION;
//             $_SESSION[ $nombre ] = $valor ;
//         }
        
//         function data_get( string $nombre ){
//             global $_SESSION;
//             if( array_key_exists( $nombre,  $_SESSION ) )
//                 return $_SESSION[ $nombre ];
//             return "";
//         }
//         function data_unset( string $clave ){
//             global $_SESSION;
//             if( array_key_exists( $clave, $_SESSION ) )
//                 unset( $_SESSION[ $clave ] ) ;
//         }
        
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