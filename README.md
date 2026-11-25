# TP1 Backend — Ficha 4: Gimnasio

Implementación del backend en **PHP 8+ Orientado a Objetos** correspondiente al dominio **Ficha 4: Gimnasio** del Trabajo Práctico 1 de la carrera **Programador y Diseñador Web Profesional (IAC Paraná)**.

* **Estudiante:** Ignacio Andrés Avilés Peltzer

* **Repositorio:** [`nachoaviles09/tp1-backend-aviles`](https://github.com/nachoaviles09/tp1-backend-aviles)

## Descripción del dominio y alcance

El sistema modela la lógica de negocio y el dominio de un gimnasio que administra sus **socios**, sus **entrenadores** y las **clases grupales** dictadas por cada entrenador, garantizando que la cantidad de inscriptos nunca supere el cupo máximo establecido.

### Criterios técnicos aplicados

* **Tipado estricto (`declare(strict_types=1);`):** Todas las clases y vistas respetan exactamente los tipos de datos (`int`, `string`, `bool`, `void`) especificados en el diagrama UML.

* **Consistencia de nombres para el TP2:** Los nombres de clases, atributos y métodos están escritos exactamente como figuran en la ficha (sin tildes ni eñes: `dia`, `miercoles`, `sabado`, `cupoMaximo`, `numeroSocio`, `clase_grupal_id`, `entrenador_id`, `socio_id`) para asegurar la integración directa con el frontend en el TP2.

* **Encapsulamiento y validación centralizada:** Los constructores delegan la asignación de valores en los setters correspondientes, asegurando que ningún objeto pueda instanciarse en un estado inválido.

## Estructura del proyecto

```
tp1-backend-aviles/
├── clases/
│   ├── Persona.php         # Clase base con atributos protegidos (#) y validaciones comunes
│   ├── Entrenador.php      # Clase hija que hereda de Persona
│   ├── Socio.php           # Clase hija que hereda de Persona
│   └── ClaseGrupal.php     # Clase independiente con la regla de negocio del dominio
├── index.php               # Instanciación, listados y demostración de regla de negocio
├── formulario.php          # Alta de ClaseGrupal por método POST con manejo de excepciones
└── README.md               # Documentación del proyecto

```

## Modelo de clases y relaciones

* **`Persona` (`clases/Persona.php`):** Clase base con los atributos protegidos (`#`) `$nombre`, `$apellido` y `$email`, getters/setters validados y el método `describir(): string`. No posee ID propio, ya que cada subclase define su identificador.

* **`Entrenador` (`clases/Entrenador.php`):** Hereda de `Persona` (`extends Persona`). Incorpora los atributos privados `$entrenador_id`, `$especialidad` y `$matricula`, y sobrescribe `describir(): string`.

* **`Socio` (`clases/Socio.php`):** Hereda de `Persona` (`extends Persona`). Incorpora los atributos privados `$socio_id`, `$numeroSocio` y `$plan`, y sobrescribe `describir(): string`.

* **`ClaseGrupal` (`clases/ClaseGrupal.php`):** Clase independiente vinculada con `Entrenador` mediante asociación (`1` entrenador dicta `0..*` clases grupales) guardando la referencia `$entrenador_id`.

## Regla de negocio y validaciones

### Regla de negocio (`ClaseGrupal`)

* `hayCupo(): bool` — Devuelve `true` si `$inscriptos < $cupoMaximo`, o `false` si la clase alcanzó su capacidad máxima.

* `cuposDisponibles(): int` — Retorna la cantidad de lugares libres (`$cupoMaximo - $inscriptos`).

* `inscribir(): void` — Verifica disponibilidad mediante `hayCupo()`; si no hay lugar lanza `new Exception("No hay cupo disponible")`, y en caso contrario incrementa `$inscriptos` en `1`.

### Validaciones implementadas

Todas las validaciones se ejecutan dentro de los setters lanzando excepciones (`Exception`) ante datos inválidos:

* **Nombre, apellido, especialidad, matrícula y nombre de clase:** No pueden estar vacíos (se sanean espacios extremos con `trim()`).

* **Email:** Validado con `filter_var($email, FILTER_VALIDATE_EMAIL)`.

* **Identificadores (`entrenador_id`, `socio_id`, `clase_grupal_id`) y `numeroSocio`:** Enteros positivos mayores a `0`.

* **Plan de socio (`Socio::setPlan`):** Únicamente `mensual`, `trimestral` o `anual`.

* **Día de clase (`ClaseGrupal::setDia`):** Únicamente de `lunes` a `sabado` (sin tilde).

* **Capacidad (`cupoMaximo` e `inscriptos`):** `cupoMaximo` entero entre `1` y `50`; `inscriptos` entero entre `0` y `cupoMaximo`.

## Vistas y funcionamiento

* **`index.php`:**

  * Instancia **3 entrenadores**, **3 socios** y **4 clases grupales**.

  * Muestra los listados ejecutando `describir()` en las clases hijas y resuelve el nombre completo de cada entrenador en la tabla de clases cruzando `entrenador_id`.

  * Ejecuta dos casos de prueba en vivo sobre `inscribir()`: una inscripción válida en una clase con cupo disponible (`12/15` $\rightarrow$ `13/15`) y un intento de inscripción en una clase completa (`20/20`) capturado mediante `try / catch` para mostrar la excepción `"No hay cupo disponible"`.

* **`formulario.php`:**

  * Procesa el alta de una nueva `ClaseGrupal` mediante `POST`.

  * No solicita el `clase_grupal_id` en el formulario; lo genera automáticamente en PHP a partir de las clases existentes (`count($clasesGrupales) + 1`) antes de instanciar el modelo.

  * Valida los campos enteros recibidos con `filter_var(..., FILTER_VALIDATE_INT)` y captura cualquier excepción lanzada por los setters dentro de un bloque `try / catch`.

## Ejecución en local

### Opción 1: Servidor embebido de PHP

Ubicar una terminal en la carpeta raíz del proyecto y ejecutar:

```
php -S localhost:8000

```

Luego abrir en el navegador:

* Listado y pruebas de negocio: `http://localhost:8000/index.php`

* Formulario de alta (`POST`): `http://localhost:8000/formulario.php`

### Opción 2: XAMPP

1. Copiar la carpeta `tp1-backend-aviles` dentro de `C:\xampp\htdocs\`.

2. Iniciar el módulo **Apache** desde el panel de control de XAMPP.

3. Ingresar a `http://localhost/tp1-backend-aviles/index.php` y `http://localhost/tp1-backend-aviles/formulario.php`.
