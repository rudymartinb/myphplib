#!/bin/bash

# descubri que en realidad esto no sirve por cuanto PHP no permite declarar
# el tipo de datos que lleva cada variable y x eso no refleja todas las asociaciones
# al menos en php7.2, teoricamente la 7.4 tendra esa posibilidad

phuml ./ -graphviz -createAssociations false -neato UML.png
