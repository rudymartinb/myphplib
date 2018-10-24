<?php
namespace session_data;

interface session_data_interface {
    function get( string $clave );
    function set( string $clave, $valor );
    function unset( string $clave );
}

