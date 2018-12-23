<?php
namespace session_start_adaptador {
    interface session_start_adaptador_interface {
        function iniciar();
        function estado();

        function terminar();
    }

};
?>