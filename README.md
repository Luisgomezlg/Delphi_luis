###### ESTA ES LA CONFIGURACIÓN ######

#### PASO 1 ####
Tener instalado composer, nodejs, xampp u otro servidor web en el sistema 

#### PASO 2 ####
CLONAR EN CONSOLA EL REPOSITORIO GITHUB O DESCARGAR ARCHIVO DE GITHUB DIRECTAMENTE

#### PASO 3 ####
UNA VEZ DESCARGADO O CLONADO EL PROYECTO, EJECUTAR EN CONSOLA DENTRO DE LA CARPETA delphi_luis EL COMANDO 'NPM INSTALL' Y LUEGO 'COMPOSER INSTALL'

CONFIGURACIÓN DE EL ARCHIVO .ENV:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=delphi_luis
DB_USERNAME=root
DB_PASSWORD=

#### PASO 4 ####
GENERAR KEY EN CONSOLA EL COMANDO 'PHP ARTISAN KEY:GENERATE'

#### PASO 5 ####

GENERAR BASE DE DATOS CON EL COMANDO 'PHP ARTISAN MIGRATE' O IMPORTAR DIRECTAMENTE

#### PASO 6 ####

EJECUTAR 'PHP ARTISAN SERVE' Y EN OTRA CONSOLA 'NPM RUN DEV' EN OTRA CONSOLA

URL DE PROYECTO http://127.0.0.1:8000/

#### PASO 7 ####

REGISTRAR Y COMENZAR

