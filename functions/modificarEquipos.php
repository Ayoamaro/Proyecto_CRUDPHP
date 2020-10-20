<!DOCTYPE html>
<head>
    <title>Modificar Equipo. Formulario Fútbol PHP</title>
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
            echo "<h1>Modificar</h1>
            <h6>Autor: Ayoze Amaro</h6>";
            $equipoElegido = array($_POST["codEquipo"]);
            $_SESSION["equipoElegido"] = $equipoElegido;
        
            $stmp = $pdo->prepare("SELECT codEquipo, nomEquipo, codLiga, localidad, internacional FROM equipos WHERE codEquipo=?");
            $stmp->execute($equipoElegido);
            $row = $stmp->fetch();

            $stmp1 = $pdo->prepare("SELECT codLiga, nomLiga FROM ligas");
            $stmp1->execute();


            echo "<form method='POST'>
            <div id='content'>
                <table>
                <th>Código</th><th>Nombre</th><th>Liga</th><th>Localidad</th><th>Internacional</th>
                <tr>
                <td>".$row['codEquipo']."</td>
                <td><input type='text' value='".$row['nomEquipo']."' name='nomEquipo'></td>
                <td>
                <select name='codLiga'>";
                while ($row1 = $stmp1->fetch()) {
                    if ($row1['codLiga'] == $row['codLiga']) {
                        echo "<option value=".$row1['codLiga']." selected>".$row1['nomLiga']; 
                    }
                    else {
                        echo "<option value=".$row1['codLiga'].">".$row1['nomLiga'];
                    }  
                }
                echo "</select>
                </td>
                <td><input type='text' value='".$row['localidad']."' name='localidad'></td>
                <td><select name='internacional'>";
                if ($row['internacional'] == 1) {
                    echo "<option value='1'> SÍ"; 
                    echo "<option value='0'> NO";
                } else {
                    echo "<option value='0'> NO";
                    echo "<option value='1'> SÍ"; 
                }
                echo "</select></td>
                </table>
            </div>";
            echo "<p>¿Está seguro de que desea modificar este equipo de la base de datos?</p>
                    <div id='seleccion'>
                        <input type='submit' name='deseaModificar' value='Sí' style=' padding: 5px 35px 5px; margin: 5px;'>
                        <a href='../index.php'><button type='button'>No</button></a>
                    </div>
            </form>";
        }

        if(isset($_POST["deseaModificar"])) {
            $nomEquipo = $_POST["nomEquipo"];
            $codLiga = $_POST["codLiga"];
            $localidad = $_POST["localidad"];
            $internacional = $_POST["internacional"];
            $equipoElegido = $_SESSION["equipoElegido"];

            $modificar = $pdo->prepare("UPDATE equipos SET nomEquipo='$nomEquipo', codLiga='$codLiga', localidad='$localidad', internacional='$internacional' WHERE codEquipo=?");
            $modificar->execute($equipoElegido);
            $pdo = null;
            
            header('refresh:3.5; url=http://localhost/Futbol_Proyecto_PHP/');

            echo "<h1>Modificando equipo...</h1>

            <form method='POST'>
                <div id='seleccion'> 
                    <img src='../docs/img/spinner_carga.gif' alt='Spinner de carga' style='margin-top: 60px;'>
                </div>
            </form>";
        }
        ?> 
        </div>
    </div>
</body>
</html>