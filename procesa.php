<?php
    $proceso = false;
    if(isset($_POST["oc_Control"])){

        //procesa los datos generales del archivo recibido.
		$archivo = $_FILES["txtArchi"]["tmp_name"];
		$tamanio = $_FILES["txtArchi"]["size"];
		$tipo    = $_FILES["txtArchi"]["type"];
        $nombre  = $_FILES["txtArchi"]["name"];
        $sepa    = $_POST['txtsepa'];

        //valida que
        if($tamanio > 0){
            //procesa el contenido del archivo recibido.
            $archi = fopen($archivo, "rb");
            $encabezados = explode($sepa,fgets($archi));

            $contenido = array();
            $posi = 0;
            while($linea = fgets($archi)){
                $contenido[$posi++] = explode($sepa,$linea);
            }

            //cierra el archivo.
            fclose($archi);

            //cambia el estado del proceso.
            $proceso = true;
        }
    }

    $proceso = false;
    if(isset($_POST["oc_Control"])){

        //procesa los datos generales del archivo recibido.
		$archivo1 = $_FILES["txtArchi1"]["tmp_name"];
		$tamanio1 = $_FILES["txtArchi1"]["size"];
		$tipo1    = $_FILES["txtArchi1"]["type"];
        $nombre1  = $_FILES["txtArchi1"]["name"];

        //valida que
        if($tamanio > 0){
            //procesa el contenido del archivo recibido.
            $archi = fopen($archivo1, "rb");
            $encabezados = explode($sepa,fgets($archi));

            $contenido1 = array();
            $posi = 0;
            while($linea = fgets($archi)){
                $contenido1[$posi++] = explode($sepa,$linea);
            }

            //cierra el archivo.
            fclose($archi);

            //cambia el estado del proceso.
            $proceso = true;
        }
    }

    foreach ($contenido as is_int($entero)){
        $entero ++;
        
    }

    $campos = array("campo","campo1","campo2","campo3","campo4","campo5","campo6","campo7","campo8","campo9")
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include_once("segmentos/encabe.inc");
	?>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <title>Proceso de datos</title>
</head>
<body class="container">
	<header class="row">
		<?php
			include_once("segmentos/menu.inc");
		?>
	</header>

	<main class="row">
		<div class="linea_sep">
            <h3>Procesando archivo.</h3>
            <br>
            <?php
                if(!$proceso){
                    //En caso que el archivo .csv no pudiese ser procesado
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '  El archivo no puede ser procesado, verifique sus datos.....!';
                    echo '</div>';
                }else{
                    //En caso que el archivo .csv pudiese ser procesado
                    echo "<h4>Datos Generales.</h4>";

                    echo "<table class='table table-bordered table-hover'>";
                    echo "  <tr>";
                    echo "      <td>Archivo</td>";
                    echo "      <td>Tipo</td>";
                    echo "      <td>Tamaño</td>";
                    echo "      <td>Observaciones</td>";
                    echo "  </tr>";
                    echo "  <tr>";
                    echo "      <td>".$nombre."</td>";
                    echo "      <td>".$tipo."</td>";
                    echo "      <td>".number_format((($tamanio)/1024)/1024,2,'.',',')." MBs</td>";
                    echo "  </tr>";
                    echo "  <tr>";
                    echo "      <td>".$nombre1."</td>";
                    echo "      <td>".$tipo1."</td>";
                    echo "      <td>".number_format((($tamanio1)/1024)/1024,2,'.',',')." MBs</td>";
                    echo "  </tr>";
                    echo "</table>";

                    echo "<br>";
                    echo "<h4>Estructura.</h4>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "  <tr>";
                    echo "      <td>Campo</td>";
                    echo "      <td>Tipo</td>";
                    echo "      <td>Uso</td>";
                    echo "      <td>Valor</td>";
                    echo "  </tr>";

                    echo "  </tr><tr>";


                    foreach($contenido[0] as $datos){
                        echo "<td>".gettype($datos)."</td>";
                    }

                    echo "  </tr><tr>";

                    foreach($contenido[0] as $datos){
                        echo "<td>".gettype($datos)."</td>";
                    }

                    echo "  </tr>";
                    echo "</table>";

                    echo "<br>";
                    echo "<h4>Datos.</h4>";
                    echo "<table id='tblDatos' class='table table-bordered table-hover'>";
                    echo "<thead><tr>";

                    foreach($campos as $titulo){
                        echo "<td>".$titulo."</td>";
                    }

                    echo "</tr></thead><tbody>";

                    for ($i=0; $i < 100 ; $i++) {
                        echo "<tr>";
                        foreach($contenido[$i] as $datos){
                            echo "<td>".$datos."</td>";
                        }
                        echo "</tr>";
                    }
                        /**/ 
                    echo "<h4>Datos 1.</h4>";
                    echo "<thead><tr>";

                    foreach($campos as $titulo){
                        echo "<td>".$titulo."</td>";
                    }

                    echo "</tr></thead><tbody>";

                    for ($i=0; $i < 100 ; $i++) {
                        echo "<tr>";
                        foreach($contenido1[$i] as $datos1){
                            echo "<td>".$datos1."</td>";
                        }
                        echo "</tr>";
                    }
                    /**/

                    echo "<tbody></table>";

                }//fin del else (solo si el archivo fue procesado)
            ?>
		</div>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    
        <script type="text/javascript">
            var datos = $.ajax({
                url:'procesa.php',
                type:'post',
                dataType:'json',
                async:false
            }).responseText;

            datos = JSON.parse(datos);

            google.load("visualization", "1", {packages:["corechart"]});

            google.setOnLoadCallback(creaGrafico);

            function creaGrafico() {
                var data = google.visualization.arrayToDataTable(datos);
            
                var opciones = {
                    title: 'INTENSION DE VOTOS',
                    hAxis: {title: 'MESES', titleTextStyle: {color: 'green'}},
                    vAxis: {title: 'Encuestados', titleTextStyle: {color: '#FF0000'}},
                    backgroundColor:'#ffffcc',
                    legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 13}},
                    width:900,
                    height:500
                };

                var grafico = new google.visualization.ColumnChart(document.getElementById('grafica'));
                grafico.draw(data, opciones);
    }

        </script>   
	</main>

	<footer class="row pie">
		<?php
			include_once("segmentos/pie.inc");
		?>
	</footer>

	<!-- jQuery necesario para los efectos de bootstrap -->
    <script src="formatos/bootstrap/js/jquery-1.11.3.min.js"></script>
    <script src="formatos/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tblDatos').dataTable({
                "language":{
                    "url": "dataTables.Spanish.lang"
                }
            });
        });
    </script>
</body>
</html>










