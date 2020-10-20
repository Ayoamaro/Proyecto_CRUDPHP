<!DOCTYPE html>
<head>
    <title>Índice. Formulario Fútbol PHP</title>
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="pagina1">
    <div id="main">
        <!-- contenido -->
        <h1>Equipos</h1>
        <h6>Autor: Ayoze Amaro</h6>
        <?php
        include 'conection.php';

        $datos = $pdo->prepare("SELECT codEquipo, nomEquipo, codLiga, localidad, internacional FROM equipos ORDER BY codEquipo ASC");
        $datos->execute();

        echo "<div id='content'>";
        echo "<table>";
        echo "<th>Código</th><th>Nombre</th><th>Liga</th><th>Localidad</th><th>Internacional</th><th>Funcionalidades</th>";
        echo "<tr>";
        while ($row = $datos->fetch()) {
            echo "<td>".$row['codEquipo']."</td>";
            echo "<td>".$row['nomEquipo']."</td>";
            switch ($row['codLiga']) {
                case '11111':
                    echo "<td>La Liga Santander</td>";
                    break;
                case '22222':
                    echo "<td>Premier League</td>";
                    break;
                case '33333':
                    echo "<td>Bundesliga</td>";
                    break;
                case '44444':
                    echo "<td>Ligue 1</td>";
                    break;
                case '55555':
                    echo "<td>Eredivise</td>";
                    break;
            }
            echo "<td>".$row['localidad']."</td>";

            if ($row['internacional'] == '1') {
                echo "<td>SÍ</td>";
            }
            else if ($row['internacional'] == '0') {
                echo "<td>NO</td>";
            } 
            
            echo "<td>
                    <form action='functions/borrarEquipos.php' method='POST'>
                        <input type='hidden' value='".$row['codEquipo']."' name='codEquipo'>
                        <input type='submit' value='Borrar' name='Borrar'>
                    </form>
                    <form action='functions/modificarEquipos.php' method='POST'>
                        <input type='hidden' value='".$row['codEquipo']."' name='codEquipo'>
                        <input type='submit' value='Modificar' name='Modifica'>
                    </form>
                </td>";
            echo "</tr>";
        } 

        echo "</table>";
        echo "</div>";
        echo "<p>Número total de equipos: ".$datos->rowCount()."</p>";
        echo "<form class='altas' action='functions/altasEquipos.php' method='POST'>
                <input type='submit' value='Altas' name='Altas'>
              </form>";
        $pdo=null;
        ?> 
        </div>
    </div>
</body>
</html>