#!/bin/bash

# nota: al final termine usando phUML individualmente para cada directorio
# me genera el grafico con las clases. No es una maravilla pero cumple el proposito:
# visualizar la relacion entre las clases.
# el script es crearUML.sh y se debe correr en cada directorio individualmente


# correr este script desde la raiz del repo 
# ejemplo:
# scripts/crear_xmi_UML.sh
# 

# la idea de este script es generar el archivo 
# para luego importar el archivo en ArgoUML o BoUML


# if [! -d  tmp ]; then exit; fi
# mkdir tmp

# poner abajo los fuentes a leer del proyecto en el orden que corresponde
TEST=`cat << EndOfMessage
./ldap/ldap_interface.php
./ldap/ldap.php
./session_user/session_user_interface.php
./session_data/session_data_interface.php
./session_data/session_data_fake.php
./session_data/session_data.php
./session_user/session_user_fake.php
./session_user/session_user.php
./derivador/derivador.php
./db/mysql_interface.php
./db/mysql_wrapper.php
./db/mysql_query_mock.php
./db/test/credencialessql.php
./myheaders/myheaders_interface.php
./myheaders/myheaders_fake.php
./myheaders/myheaders.php
./seguridad_usuarios/menu.php
./seguridad_usuarios/menu_primario.php
./seguridad_usuarios/dummy.php
EndOfMessage`

# para debug 
# echo "$TEST" 

php2xmi --no-private --no-protected --output=tmp/myphplib.xmi $TEST 