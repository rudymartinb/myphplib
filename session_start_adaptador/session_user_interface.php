<?php
namespace session_start_adaptador {
    use session_variable_adaptador\session_variable_adaptador_interface ;
    interface session_start_adaptador_interface {
        function inicio();
        function estado();
        function nombre( string $name );
        function esta_registrada( string $name  );
        function get_data() : session_variable_adaptador_interface ;
        function unset();
        function destroy();
    }

};
?>