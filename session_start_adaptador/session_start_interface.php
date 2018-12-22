<?php
namespace session_start_adaptador {
    use session_variable_adaptador\session_variable_adaptador_interface ;
    interface session_start_adaptador_interface {
        function inicio();
        function estado();
        function nombre( string $name );
        function esta_registrada( string $name  );
        
        function data_set( string $nombre, $valor );
        function data_get( string $nombre );
        function data_unset( string $nombre );
        
        // function get_data() : session_variable_adaptador_interface ;
        function unset();
        function destroy();
    }

};
?>