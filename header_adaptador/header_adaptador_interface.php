<?php
namespace header_adaptador;

interface header_adaptador_interface {
    public function enviar( string $cadena );
    public function enviados() : bool ;
    
    
}

