# TP1 Backend — Ficha 4: Gimnasio

Implementación del backend en **PHP 8+ Orientado a Objetos** correspondiente al dominio **Ficha 4: Gimnasio** del Trabajo Práctico 1 de la carrera **Programador y Diseñador Web Profesional (IAC Paraná)**.

- **Estudiante:** Ignacio Avilés
- **Repositorio:** [`nachoaviles09/tp1-backend-aviles`](https://github.com/nachoaviles09/tp1-backend-aviles)

---

## Descripción del dominio y alcance

El sistema modela la lógica de negocio y el dominio de un gimnasio que administra sus **socios**, sus **entrenadores** y las **clases grupales** dictadas por cada entrenador, garantizando que la cantidad de inscriptos nunca supere el cupo máximo establecido.

### Criterios técnicos aplicados
- **Tipado estricto (`declare(strict_types=1);`):** Todas las clases y vistas respetan exactamente los tipos de datos (`int`, `string`, `bool`, `void`) especificados en el diagrama UML.
- **Consistencia de nombres para el TP2:** Los nombres de clases, atributos y métodos están escritos exactamente como figuran en la ficha (sin tildes ni eñes: `dia`, `miercoles`, `sabado`, `cupoMaximo`, `numeroSocio`, `clase_grupal_id`, `entrenador_id`, `socio_id`) para asegurar la integración directa con el frontend en el TP2.
- **Encapsulamiento y validación centralizada:** Los constructores delegan la asignación de valores en los setters correspondientes, asegurando que ningún objeto pueda instanciarse en un estado inválido.

---

## Estructura del proyecto

```text
tp1-backend-aviles/
├── clases/
│   ├── Persona.php         # Clase base abstracta conceptualmente (atributos protegidos)
│   ├── Entrenador.php      # Clase hija que hereda de Persona
│   ├── Socio.php           # Clase hija que hereda de Persona
│   └── ClaseGrupal.php     # Clase independiente con la regla de negocio del dominio
├── index.php               # Instanciación, listados y demostración de regla de negocio
├── formulario.php          # Alta de ClaseGrupal por método POST con manejo de excepciones
└── README.md               # Documentación del proyecto