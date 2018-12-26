<?php
namespace header_adaptador;

class HeaderAdaptador  implements header_adaptador_interface   {

    public function enviar( string $cadena ) {
        header($cadena);
        
    }
    public function enviados() : bool {
        return headers_sent();
    }
}

?>