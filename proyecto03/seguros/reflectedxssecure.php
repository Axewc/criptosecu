<!DOCTYPE html>
<html>
  <head>
    <title>Reflected XSS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Reflected XSS</h1>
    <p>Cross Site Scripting (XSS) es una vulnerabilidad de seguridad que permite a atacantes maliciosos inyectar su propio código malicioso en el sitio web legítimo de víctimas desprevenidas. Esto se puede utilizar para aprovechar las vulnerabilidades del lado de la víctima y causar consecuencias importantes.</p>
    <p>Permite que un atacante se haga pasar por el usuario afectado, realice cualquier acción que el usuario sea capaz de hacer y obtenga acceso a cualquier información del usuario. Si el usuario afectado tiene acceso privilegiado a la aplicación, el atacante podría obtener el control total sobre toda la funcionalidad y los datos de la aplicación.</p>
    <h2>Reflected XSS Example</h2>
    <p>En este cuadro de texto puedes buscar cualquier palabra que se te ocurra. Es un claro ejemplo de cómo funciona la vulnerabilidad Reflected XSS.</p>
    <form class="search-example" action="reflectedxssecure.php" method="get">
      <input type="text" placeholder="search..." name="search" required>
      <button type="submit"><i class="search"></i></button>
    </form>
    <?php
      if (isset($_GET["search"])) {
        $search = htmlspecialchars($_GET["search"], ENT_QUOTES, "UTF-8");
        echo "<br><br><i>No se encontraron resultados para la búsqueda: </i>" . $search;
      }
    ?>
    <h2>Reflected XSS Prevention</h2>
    <p>Para prevenir la vulnerabilidad de Reflected XSS, es importante sanitizar y validar cualquier entrada de usuario que llegue al servidor. La función htmlspecialchars() es una manera sencilla de escapar los caracteres especiales en el texto que se muestra en la página, para evitar que se interpreten como código HTML o JavaScript.</p>
  </body>
</html>
