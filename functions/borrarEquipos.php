<!DOCTYPE html>
<head>
    <title>Borrar Equipo. Formulario Fútbol PHP</title>
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="../css/style.css">
</head>
<body id="pagina1">
    <div id="main">
        <!-- contenido -->
        <?php
        include '../conection.php';
        
        session_start();    // Inicializamos las variables de Sesión

        if(isset($_POST["codEquipo"])) {
            echo "<h1>Borrar</h1>";
            echo "<h6>Autor: Ayoze Amaro</h6>";
            $equipoElegido = $_POST["codEquipo"];
            $_SESSION["equipoElegido"] = $equipoElegido;
        
            $stmp = $pdo->prepare("SELECT codEquipo, nomEquipo, codLiga, localidad, internacional FROM equipos WHERE codEquipo='$equipoElegido'");
            $stmp->execute();
    
            echo "<div id='content'>";
                echo "<table>";
                echo "<th>Código</th><th>Nombre</th><th>Liga</th><th>Localidad</th><th>Internacional</th>";
                echo "<tr>";
            while ($row = $stmp->fetch()) {
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
                if ($row['internacional'] == 1) { echo "<td>SÍ</td>"; }
                else { echo "<td>NO</td>"; }
                echo "</table>";
            echo "</div>";
            }
        
            echo "<form method='POST'>";
                echo "<p>¿Está seguro de que desea borrar este equipo de la base de datos?</p>";
                    echo "<div id='seleccion'>";
                        echo "<input type='submit' name='deseaBorrar' value='Sí' style=' padding: 5px 35px 5px; margin: 5px;'>";
                        echo "<a href='../index.php'><button type='button'>No</button></a>";
                    echo "</div>";
            echo "</form>";
        }

        if(isset($_POST["deseaBorrar"])) {
            $eliminar = $_SESSION["equipoElegido"]; // Recogemos el codEquipo para poder eliminarlo

            $sentencia = "DELETE FROM equipos WHERE codEquipo = :codEquipo";
            $borrado = $pdo->prepare($sentencia);
            $borrado->execute(array('codEquipo' => $eliminar));

            header('refresh:3.5; url=http://localhost/Futbol_Proyecto_PHP/');

            echo "<h1>Borrando equipo...</h1>";

            echo "<form method='POST'>"; 
                echo "<div id='seleccion'>";  
                    echo "<img src='../docs/img/spinner_carga.gif' alt='Spinner de carga' style='margin-top: 60px;'>";
                echo "</div>";
            echo "</form>";
        }
        ?> 
        </div>
    </div>
</body>
</html>