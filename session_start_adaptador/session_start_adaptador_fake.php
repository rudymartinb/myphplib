<?php
namespace session_start_adaptador {
    class session_start_adaptador_fake implements session_start_adaptador_interface  {
        private $status = PHP_SESSION_NONE;
        private $name = "";
        private $valores = [];
        
        function iniciar(){
            $this->status = PHP_SESSION_ACTIVE;
        }
        function estado(){
            return $this->status;
        }
        function terminar(){
            $this->status = PHP_SESSION_NONE;
            $this->valores = [];
        }
        
    }
}
?>