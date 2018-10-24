<?php
namespace session_user {
    use session_data\session_data_interface ;
    interface session_user_interface {
        function inicio();
        function estado();
        function nombre( string $name );
        function esta_registrada( string $name  );
        function get_data() : session_data_interface ;
        //         function data_set( string $nombre, $valor );
        //         function data_get( string $nombre );
        //         function data_unset( string $clave );
        function unset();
        function destroy();
    }

};
?>