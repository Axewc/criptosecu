<!DOCTYPE html>
<html>
<title> Reflected XXS </title>
<head>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1> XXS Crossscripting </h1>
  <p>Cross Site Scripting (XSS) es una vulnerabilidad de seguridad que permite a atacantes maliciosos inyectar su propio código malicioso en el sitio web legítimo de víctimas desprevenidas. Esto se puede utilizar para aprovechar las vulnerabilidades del lado de la víctima y causar consecuencias importantes.</p>
  <p> Permite que un atacante se haga pasar por el usuario afectado, realice cualquier acción que el usuario sea capaz de hacer y obtenga acceso a cualquier información del usuario. Si el usuario afectado tiene acceso privilegiado a la aplicación, el atacante podría obtener el control total sobre toda la funcionalidad y los datos de la aplicación.</p>
  <h3> Clasificación de ataques XXS </h3>
  <p> Existen varios tipo de ataques, dependiendo de donde viene el codigo malicioso. Los principales son: 
    <i>Reflected XSS, </i>
    <i>Stored XSS</i> y
    <i>DOM XSS</i></p>
    <h3> Ejercicios de la practica </h3>
    <p> Esta serie de paginas cuentan con una serie de ejercicios para que puedas llevar acabo una serie de ataques los cuales te permitan comprender como es que este ataque se lleva acabo. Deberás documentar cada uno de tus progresos y entregar un reporte al respecto. Finalmente investigarás como prevenir para que ya no suceda estos problemas de vulnerabilidad.</p>

    <h2> Reflected XSS </h2>

    En este cuadro de texto puedes buscar cualquier palabra que se te ocurra. Es un claro ejemplo de como funciona la vulnerabilidad Reflected XSS.<br><br>

    <table align="center">
      <tr><td>
        <form class="search-example" action="reflectedXxs.php" method="submit">
          <input type="text" placeholder="search..." name="search">
          <button type="submit"><i class="search"></i></button>
        </form>
      </td></tr>
    </table>
    <?php
    if(isset($_GET["search"]))
    {
      echo "<br><br> <i>No se encontraron resultados a la busqueda: </i>".$_GET["search"];
    }
    ?><br> <br>
    Reflected cross-site scripting (or XSS) surge cuando una aplicación recibe datos en una solicitud HTTP e incluye esos datos dentro de la respuesta inmediata de una manera insegura. 
    Veamos el ejemplo de esta página: 
    <p style="padding: 10px; border: 1px solid black;"><i>Proyecto03/reflectedXxs.php?search=zapato</i></p>
    La aplicación se hace eco del término de búsqueda proporcionado en la respuesta a esta URL:
    <p style="padding: 10px; border: 1px solid black;"><i>No se encontraron resultados a la busqueda: zapato</i></p>
    Suponiendo que la aplicación no realice ningún otro procesamiento de los datos, un atacante puede construir un ataque como este:
    <p style="padding: 10px; border: 1px solid black;"><i>Proyecto03/reflectedXxs.php?search=< script>/*+codigo malicioso...+*/< /script></i></p>
    Esta URL da como resultado la siguiente respuesta:
    <p style="padding: 10px; border: 1px solid black;"><i>No se encontraron resultados a la busqueda:< script>/*+codigo malicioso...+*/< /script></i></p>
    <h1> XSS DOM </h1>
    El DOM o Document Object Model es una interfaz de programación de aplicaciones (API) que permite leer, acceder y modificar el frontend del código fuente de una aplicación web. El DOM representa archivos XML o HTML en una estructura de árbol, basada en la jerarquía de los objetos que componen la página web.<br><br>
    El XSS DOM o basado en DOM es aquel que se realiza inyectando comandos de JavaScript en el DOM de una página web. Una aplicación web vulnerable permite ejecutar código malicioso desde su frontend, debido a una falta de validación de los inputs de un usuario.<br><br>
    Por ejemplo, si llamas a la URL:
    <p style="padding: 10px; border: 1px solid black;"><i>http://localhost/Proyecto03/reflectedXxs.php?search=Seguridad</i></p>
    La página te muestra:
    <p style="padding: 10px; border: 1px solid black;"><i>No se encontraron resultados a la busqueda: Seguridad</i></p>
    Un atacante podría usar:
    <p style="padding: 10px; border: 1px solid black;"><i>http://localhost/Proyecto03/reflectedXxs.php?search=%3c%73%63%72%69%70%74%3e%61%6c%65%72%74%28%22%4c%45
      %41%56%45%20%54%48%49%53%20%50%41%47%45%21%20%59%4f
      %55%20%41%52%45%20%42%45%49%4e%47%20%48%41%43%4b%45
    %44%21%22%29%3b%3c%2f%73%63%72%69%70%74%3e</i></p>
    <p style="padding: 10px; border: 1px solid black;"><i>http://localhost/Proyecto03/reflectedXxs.php?search=%3C%73%63%72%69%70%74%3E%77%69%6E%64%6F%77%2E%6C%6F%<br>63%61%74%69%6F%6E%2E%68%72%65%66%20%3D%20%20%18%68%74%74%70%73%3A<br>%2F%2F%77%77%77%2E%79%6F%75%74%75%62%65%2E<br>%63%6F%6D%2F%77%61%74%63%68%3F%76%3D%64%51%77%34%77%39%57%67%58%63%51%20<br>%19%3B%3C%2F%73%63%72%69%70%74%3E</i></p>

    <p><small> Todo lo seguido en el search es simplemente scripts codificados en hexadecimal para dificil detección.</small> </p>
    <br>

    Ahora es tu turno. Con el ejemplo realiza las siguientes tareas:
    <ul>
      <li>Agrega de el mensaje "Esta página es vulnerable" a color rojo y con la letra en cursiva.</li>
      <li>Crea una ventana de alert con el mensaje "hackeado".</li>
      <li>Agrega y modifica la página con cambios en html y script de manera en que agregues color y estilo a la información dada previamente.</li>
      <li>Agrega dos scripts y agregalos a la url de manera que el primero te redirigan a <a href="https://ptgmedia.pearsoncmg.com/images/9780735617223/samplepages/9780735617223.pdf"> Writing Secure Code</a> y el segundo muestre una alerta y un redireccionamiento a google.com.</li>
    </ul>
    <p style="color:#FFFFFF">%3C%73%63%72%69%70%74%3E%61%6C%65%72%74%28%22%4D%79%20 %6E%61%6D%65%20%69%73%20%58%58%53%22%29%3B%3C%2F%73%63%72%69%70%74%3E</p>
    <div style="text-align: right;"><a href="storeXss.php">
      <button style="text-align: right; background: #0b7dda"><big>Siguiente</big></button>
    </a></div>
    

  </body>
  </html> 