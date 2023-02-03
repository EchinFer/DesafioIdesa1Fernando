# Desafio 1 Webservices Books

Webservices CRUD de Libros

## Getting Started

Webservices hecha con el framework Slim de Php.
Se puede agregar, leer, actualizar, eliminar libros desde este servicio web.
- Con autenticación JWT(Json web token)
- PDO
- Implementación de PSR
- Estructura inspirada en Slim Skeleton https://github.com/slimphp/Slim-Skeleton pero con toques personales :D



### Installing

Clone el repositorio o descargue el zip

```
 git clone https://github.com/EchinFer/DesafioIdesa1Fernando.git
```

Luego de clonar o descomprimir el proyecto, ejecutar comando de composer para iniciar servidor

```
composer start
```

Importar desde postman la colleción **IDESA.postman_collection** para comenzar con las pruebas! El token para pruebas está en la sección de autenticación de la carpeta Desafio 1 en la colección.


## Built With


* [PHP dotenv](https://github.com/vlucas/phpdotenv) - Usado para crear las variables de entorno
* [PHP-DI](https://php-di.org/) - Usado para configurar el contenedor principal de slim app
* [JWT Authentication Middleware](https://github.com/tuupola/slim-jwt-auth) - Usado para crear el Middleware que se encarga de autenticar las peticiones

## Authors

* **Fernando Alfonso**

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Thanks internet for making this possible!
