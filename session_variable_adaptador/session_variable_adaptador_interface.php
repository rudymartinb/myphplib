<?php
namespace session_variable_adaptador;

interface session_variable_adaptador_interface { 
    function get( string $clave );
    function set( string $clave, $valor );
    function unset( string $clave );
}

