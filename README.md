
# Parallel Zero Framework
## Descripción
Parallel Zero es un framework PHP minimalista diseñado para ser simple y rápido. Perfecto para pequeños y medianos proyectos donde se busca agilidad y una estructura de código limpia.

Características
Enrutamiento simple y efectivo
Contenedor de Inyección de Dependencias
Capa de abstracción para bases de datos con CRUD genérico
Plantilla de controlador MVC
Requisitos
PHP 7.4 o superior
Servidor Web (Apache, Nginx, etc.)
Instalación
Clonar el repositorio: git clone https://github.com/yourusername/ParallelZero.git
Instalar las dependencias: composer install
Configurar el servidor web para apuntar al directorio public/
## Uso Básico
### Enrutamiento
Editar el archivo routes.php y agregar rutas:

```php
$router->get('/', 'HomeController@index');
$router->post('/save', 'DataController@store');
```

### Modelos
Crear un modelo extendiendo la clase base Model:

```php
namespace App\Models;

use ParallelZero\Core\Model;

class UserModel extends Model {
    // Tu código aquí
}
```
### Controladores
Crear un controlador extendiendo la clase base Controller:
```php
namespace App\Controllers;

use ParallelZero\Core\Controller;

class HomeController extends Controller {
    // Tu código aquí
}
```

