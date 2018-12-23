<?php
namespace session_start_adaptador {

    class session_start_adaptador implements session_start_adaptador_interface  {
    
        function iniciar(){
            session_start();
        }
        
        function estado(){
            return session_status();
        }
        
        function terminar(){
            session_unset();
            session_destroy();
        }
        
    }
    

}
?>