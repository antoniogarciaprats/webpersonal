# Tema "antoniogarciaprats" – Versión final

Tema de WordPress basado en Underscores (_s) para antoniogarciaprats.es.

## Instalación

**Opción A – desde WordPress:** Apariencia › Temas › Añadir nuevo › Subir tema › elige
`antoniogarciaprats-final.zip` › Instalar › Activar.

**Opción B – copiando la carpeta** (sustituye la actual; haz antes una copia de seguridad):

```bash
cd /var/www/html/antoniogarciaprats/wp-content/themes
sudo mv antoniogarciaprats antoniogarciaprats-copia
sudo unzip ~/Descargas/antoniogarciaprats-final.zip
sudo chown -R www-data:www-data antoniogarciaprats
```

Después recarga con Ctrl + F5.

## Páginas que hay que tener creadas (Páginas › Añadir)

| Página | Dirección (slug) | Diseño que se aplica solo |
|---|---|---|
| Inicio | cualquiera | `front-page.php` (Ajustes › Lectura › Portada) |
| Sobre mí / Quién soy | `sobre-mi` o `quien-soy` | `plantillas/quien-soy.php` |
| Servicios | `servicios` | `plantillas/servicios.php` |
| Formación | `formacion` | `plantillas/formacion.php` |
| Blog | `blog` | `home.php` (Ajustes › Lectura › Página de entradas) |
| Contacto | `contacto` | `plantillas/contacto.php` |
| Aviso legal, Privacidad, Cookies | las que quieras | plantilla normal |

A cada página ponle **extracto** (subtítulo de la cabecera) e **imagen destacada** (fondo, 1920 × 700 px).
Si una página tiene otra dirección, elige su diseño en el editor: Página › Plantilla.

## Menús (Apariencia › Menús › Gestionar ubicaciones)

- Menú principal (izquierda del logo)
- Menú principal (derecha del logo)
- Menú legal (pie de página)

## Personalizador (Apariencia › Personalizar)

- **Cabecera profesional:** email, teléfono, LinkedIn, GitHub, Facebook, eslogan, botones, imagen por defecto de páginas.
- **Pie de página:** título, texto, Instagram, YouTube, X, copyright.
- **Portada:** foto de "Sobre mí".
- **Página "Quién soy":** foto de la presentación.
- **Página "Contacto":** WhatsApp, horario, tiempo de respuesta, modalidad, "Disponible".
- **Imagen de cabecera:** fondo de la portada.

## Dónde se editan los textos

| Sección | Archivo | Función |
|---|---|---|
| Portada | `inc/inicio.php` | `ag_inicio_datos()` |
| Quién soy | `inc/quien-soy.php` | `ag_quien_soy_datos()` |
| Servicios (y enlace al portfolio) | `inc/servicios.php` | `ag_servicios_datos()` |
| Formación | `inc/formacion.php` | `ag_formacion_datos()` |
| Contacto | `inc/contacto.php` | `ag_contacto_datos()` |

**Pendiente de completar:** cifras de la portada, titulaciones, preguntas frecuentes de contacto
y la dirección del portfolio (`'url'` en `inc/servicios.php`).

## Imágenes

- `images/empresas/` → logos de centros y empresas (aparecen solos en la portada y en Formación).
- `images/cabecera-hero.jpg`, `images/seccion-defecto.jpg`, `images/ia-fondo.jpg` → fondos de ejemplo.
- `images/logo-ag.svg` → tu logo en azul sobre blanco (favicon, firmas…).

## Estructura

```
antoniogarciaprats/
├── functions.php, header.php, footer.php
├── front-page.php            Portada
├── home.php, archive.php, search.php, single.php   Blog
├── plantillas/               quien-soy, servicios, formacion, contacto
├── template-parts/blog/      listado del blog
├── inc/                      cabecera, pie, inicio, quien-soy, servicios, formacion, contacto, blog
├── css/                      un archivo por sección
├── js/                       cabecera, pie, inicio, blog, contacto
└── images/                   fondos, logo y carpeta empresas/
```

## Notas

- Google Fonts se carga desde Google: para cumplir el RGPD conviene alojar las fuentes en el propio servidor.
- Antes de publicar, desactiva `WP_DEBUG` en `wp-config.php`.
