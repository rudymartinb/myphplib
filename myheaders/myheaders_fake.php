<?php
namespace myheaders;

/*
 * parece una pavada como esta implementado esto pero
 * 1) prefiero esperar a tener mas informacion respecto de cual es la implementacion correcta
 * 2) hacer las cosas simples
 * 
 * la idea final es que cuanod necesite usar headers() termine usando un objeto que implemente esta interface
 * preferentemente como parametro  de un metodo
 * 
 */
class MyHeaders_fake implements myheaders_interface {

    public function enviar( $cadena ) {
        
    }

    public function enviados() : bool {
        return true;
    }
}

