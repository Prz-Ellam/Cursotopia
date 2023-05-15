# Cursotopia

Portal de cursos online similar a Udemy o Pluralsight

### Usuarios
| Atributo    | Reglas      |
| ----------- | ----------- |
| Nombre      | Text        |
| Apellido    | Text        |
| Género      | Text        |
| Fecha de nacimiento | Text |
| Email       | Text        |
| Contraseña  | Text        |



- Home
- Login
- Registro
- Ver perfil
- Editar perfil
- Ver certificados

- Ver curso
- Crear curso
- Modificar curso
- Chat
- Pago
- Añadir categoría
- Añadir nivel
- Reporte de ventas
- Buscador



- Roles de usuario

- Módulo de Imágenes
- Módulo de Videos
- Módulo de Documentos
- Módulo de Enlaces

- Módulo de Usuarios
  - Módulo de Auth
- Módulo de Categorias
- Módulo de Cursos
  - Módulo de Niveles
  - Módulo de Lecciones
  - Course Category
- Reseñas
- Mensajes

- Métodos de pago (Enrollments)
  - User level
  - User lesson

- Chat
  - Chat participants

- Messages



module.exports = {
  build: {
    manifest: 'ruta/para/manifest.json'
  }
}


    Configuración de PHP: Asegúrate de que la configuración upload_max_filesize y post_max_size en el archivo php.ini sea lo suficientemente grande para permitir la carga de imágenes más grandes. Si necesitas trabajar con imágenes más grandes, es posible que debas aumentar estos valores.

    Configuración de MySQL: Asegúrate de que la configuración max_allowed_packet en el archivo my.cnf sea lo suficientemente grande para permitir la inserción de BLOBs grandes en la base de datos. Si necesitas trabajar con BLOBs más grandes, es posible que debas aumentar este valor.

    Tipo de datos de BLOB: Verifica que el tipo de datos de BLOB esté disponible en tu versión de MySQL y que esté habilitado en la configuración de MySQL.

    Memoria disponible: Asegúrate de que tu servidor tenga suficiente memoria disponible para manejar las operaciones de carga y descarga de imágenes. Si necesitas trabajar con imágenes muy grandes, es posible que debas aumentar la cantidad de memoria disponible para PHP y MySQL.

    Extensión de PHP: Es posible que necesites habilitar la extensión php_mysqli o php_pdo_mysql en el archivo php.ini para permitir la conexión a la base de datos MySQL desde PHP.




1. Validaciones de los JSON Schemas y los jQuery Validators
2. Middlewares de acceso a las rutas y validacion de ID en uri
3. Creación de queries para los diferentes servicios necesarios
4. Creación de modelos que encapsulen los queries
5. Validaciones en los modelos
6. Creación de controladores
7. Configuraciones de Apache