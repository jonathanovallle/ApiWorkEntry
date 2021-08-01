# ApiWorkEntry
## Instalacion 🔧: 
* [Npm](https://www.npmjs.com/) - Para el gestor de paquetes
* [NodeJs](https://nodejs.org/en/) - Para el back
* [mySql](https://www.mamp.info/en/windows/) - Base de datos(yo he utilizado mamp)

## Configuracion ⚙️
Una vez se tengan todo instalado y el repositorio clonado con
```
git clone https://github.com/jonathanovallle/ApiWorkEntry.git
```
el siguiente paso es en nuestra terminal ejecutar
```
composer install
```
eso instalara todas las dependencias de la app y despues ejecutar
```
composer update
```
Despues de todo eso necesitaremos crear las tablas para nuestra base de datos con : 
```
 php bin/console doctrine:migrations:migrate  
```

## Comenzando 🚀
Abrimos una terminal y ejecutamos el comando para iniciar nuestra app
```
symfony server:start               
```
# Llamadas 📞
## Usuarios
* Añadir -> (/user/add) necesitaremos pasarle un json con datos de 'name' y 'email'.
* Todos los usuarios -> (/user) nos devulve un json con todos los usuarios.
* Buscar 1 usarios -> (/user/{id}) nos devuelve un json con el usuario.
* Actualizar -> (/user/update/{id}) necesitaremos pasarle un json con datos de 'name' y 'email'.
* Eliminar -> (/user/delete/{id}).

## WorkEntry
* Añadir -> (/user/{id}/workEntryAdd)
* Buscar 1 workEntry por id -> (/user/workEntries/{id}) devulve un json.
* Buscar workEntry por id de usuario -> (/user/{id}/workEntries) devuelve un json.
* Eliminar -> (/user/workEntry/delete/{id}).
* Actualizar -> (/user/workEntry/update/{id}).
