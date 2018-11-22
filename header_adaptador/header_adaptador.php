<?php
namespace header_adaptador;

class HeaderAdaptador  implements headerad_aptador_interface   {

    public function enviar( string $cadena ) {
        header($cadena);
        
    }
    public function enviados() : bool {
        return headers_sent();
    }
}

?>