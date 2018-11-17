#!/bin/bash

# correr este script desde la raiz del repo (o sea, el directorio que contiene "scripts" y no desde scripts directamente)

# la idea es importar el archivo generado por este script en ArgoUML o similar

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

echo "$TEST" 


php2xmi --no-private --no-protected --output=tmp/myphplib.xmi $TEST 