<?php
namespace myheaders;

class MyHeaders implements myheaders_interface {

    public function enviar( string $cadena ) {
        header($cadena);
        
    }
    public function enviados() : bool {
        return headers_sent();
    }
}

?>