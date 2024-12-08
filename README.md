## Esto es un titulo

Esto es un texto

[Esto es un hiperlink](aqui va el URL).

**Esto es negrilla**

- Esto es un un LI

## La prueba consiste en la creación de una API en Laravel

### Requisitos:
- Framework: Debes usar Laravel para desarrollar la API.
- TDD (Test-Driven Development): La solución debe seguir la metodología TDD. Es decir, debes escribir los tests primero y luego desarrollar el código para cumplir con esos tests.
- Commits Atomizados: Debes dividir el trabajo en commits separados, siguiendo una estructura lógica (por ejemplo: Init, Paquetes, Funcionalidades, etc.).
- Buenas Prácticas: Se valorará el uso de buenas prácticas, patrones y metodologías que aseguren que el código sea sostenible a largo plazo.
- Tests: La entrega debe contener tests que verifiquen el funcionamiento correcto de la API.
Defender la Solución: En caso de ser necesario, deberás presentar tu solución y defender todas las decisiones tomadas. No habrá una única solución correcta, pero se evaluará cómo aplicas buenas prácticas y justificas las decisiones.
- Restricción: No se debe hacer uso de herramientas como ChatGPT o IA para ayudar en la solución.
Tiempo: Tienes un plazo máximo de 5 días para entregar la prueba.

### Definición de la API:

La API deberá implementar el siguiente endpoint:

#### POST /api/v1/short-urls
Cuerpo de la Solicitud: Debe recibir un objeto JSON con los siguientes parámetros:

> {
>   "url": "string"  // obligatorio
> }
#### Respuesta:

La API debe devolver un objeto JSON con la siguiente estructura:

> {
>   "url": "<https://example.com/12345>"
> }

El valor de "url" debe ser un enlace acortado que redirija a la URL original recibida en el cuerpo de la solicitud.

#### Acortador de URL:

Utiliza una API pública para acortar la URL. Se recomienda usar el servicio TinyURL con su API

> GET https://tinyurl.com/api-create.php?url=http://www.example.com

### Autorización:

La autorización será del tipo Bearer Token.

Ejemplo de encabezado de autorización:

> Authorization: Bearer my-token

El token es válido si sigue el formato adecuado, por ejemplo:

> Authorization: Bearer []{}()

#### Validación de Paréntesis:

Deberás crear una función que valide si una cadena que contiene solo los caracteres "{", "}", "[", "]", "(", ")" es válida, según las siguientes reglas:

##### Reglas:

Los paréntesis, llaves y corchetes deben cerrarse con el mismo tipo con el que se abrieron.

Los paréntesis, llaves y corchetes deben cerrarse en el orden correcto.

Ejemplos de cadenas válidas:
> {} → válido
> {), [{]} → inválido
> ({[]}) → válido

## Historial de comentarios

1. ** first commit. ENV Setup. **
    - Cree el proyecto y configure el .ENV file
2. ** Require PHPUnit. Create Test. **
    - Actualice el PHPunit a la ultima version
    - Cree el archivo para probar las rutas
3. ** Created controller. fix class doesnt exit issue. **
    - Cree el controlador.
    - indique el uso del contralador para que reconociera las rutas

4. ** Created and tested 3 routes. **
    - descomente la linea del api del kernel para que trabajaran con sanctum
    - Agregue el modelo User en los archivos donde los usaria
    - Defini las pruebas a realizar
    - Corri las pruebas unitarias sin errores
5. ** move api routes to api.php **
    - Corregi los nombre de los campos requeridos en las peticiones
    - Cree un archivo de pruebas manual
    - Movi las rutas del web.php al api.php
    - Le agregue el ** test_ ** a las pruebas para que las tomara en cuenta
    - Movi los test definidos al archivo de ejemplo para que los ejecutara  
6. ** finish tests. added last funtion. clean code. **
    - Elimine la confirmacion de contraseña para el registro y el formato de contraseña ya que me estaban generando error
    - Cree la funcion para validar los simbolos de apetura y cierre
7. ** fixed issue getting auth url **
    - Movi la funcion al controlador porque me di cuenta que lo habia colocado en el archivo que no era
    - corregi la ruta con verificacion para obtener el short url 
8. ** fixed api route in cache **
    - Limpie la cache de routas ya que no estaban tomando correctamente las rutas de api.php 
    - actualize el guzzle y el sanctum
    - corregi las rutas api eliminandoles el api adicional que tenian
