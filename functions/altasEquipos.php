<!DOCTYPE html>
<head>
    <title>Altas Equipo. Formulario Fútbol PHP</title>
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="../css/style.css">
</head>
<body id="pagina1">
    <div id="main">
        <!-- contenido -->
        <?php
        include '../conection.php';

        echo "<h1>Altas</h1>
        <h6>Autor: Ayoze Amaro</h6>";

        $stmp = $pdo->prepare("SELECT codLiga, nomLiga FROM ligas");
        $stmp->execute();

        echo "<form method='POST'>
            <div id='content'>
                <table>
                <th>Nombre</th><th>Liga</th><th>Localidad</th><th>Internacional</th>
                <tr>
                <td><input type='text' value='' name='nomEquipo'></td>
                <td>
                <select name='codLiga'>";
                while ($row = $stmp->fetch()) {
                    echo "<option value=".$row['codLiga'].">".$row['nomLiga'];  
                }
                echo "</select>
                </td>
                <td><input type='text' value='' name='localidad'></td>";
                echo "<td>SÍ <input type='checkbox' value='1' name='internacional'>  NO <input type='checkbox' value='0' name='internacional'></td>"; 
                echo "</table>
                <input type='reset' name='Limpiar' value='Limpiar datos' style='padding: 5px 25px 5px; margin: 30px;'>
            </div>";
            
            echo "<p>¿Está seguro de que desea dar de alta este equipo de la base de datos?</p>
                    <div id='seleccion'>
                        <input type='submit' name='deseaAlta' value='Sí' style='padding: 5px 35px 5px; margin: 5px;'>
                        <a href='../index.php'><button type='button'>No</button></a>
                        
                    </div>
            </form>";

            if(isset($_POST["deseaAlta"])) {
                $datos = array($_POST["nomEquipo"],$_POST["codLiga"],$_POST["localidad"],$_POST["internacional"]);
    
                $modificar = $pdo->prepare("CALL ejerc_2 (?,?,?,?, @ligaExiste, @insercion)");
                $modificar->execute($datos);
                $pdo=null;
    
                header('refresh:3.5; url=http://localhost/Futbol_Proyecto_PHP/');
    
                echo "<h1>Creando nuevo equipo...</h1>
    
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