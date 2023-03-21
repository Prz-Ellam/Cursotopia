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