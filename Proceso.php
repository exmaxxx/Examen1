<?php
    $proceso = false;
    if(isset($_POST["oc_Control"])){

        //procesa los datos generales del archivo recibido.
		$archivo = $_FILES["txtArchi"]["tmp_name"];
		$tamanio = $_FILES["txtArchi"]["size"];
		$tipo    = $_FILES["txtArchi"]["type"];
        $nombre  = $_FILES["txtArchi"]["name"];

        //valida que
        if($tamanio > 0){
            //procesa el contenido del archivo recibido.
            $archi = fopen($archivo, "rb");
            $encabezados = explode('&',fgets($archi));

            $contenido = array();
            $posi = 0;
            while($linea = fgets($archi)){
                $contenido[$posi++] = explode('&',$linea);
            }

            //cierra el archivo.
            fclose($archi);

            //cambia el estado del proceso.
            $proceso = true;
        }
        echo json_encode(array($contenido));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>	
    <?php
        include_once("segmentos/encabe.inc");        
	?>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   
    <script type="text/javascript">
        var datos = $.ajax({
            url:'Proceso.php',
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
                title: 'Censo',
                hAxis: {title: 'Personas', titleTextStyle: {color: 'green'}},
                vAxis: {title: 'Cosas', titleTextStyle: {color: '#FF0000'}},
                backgroundColor:'#ffffcc',
                legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 13}},
                width:900,
                height:500
            };

            var grafico = new google.visualization.ColumnChart(document.getElementById('grafica'));
            grafico.draw(data, opciones);
}

    </script>   
</head>
<body class="container">
	<header class="row">
		<?php
			include_once("segmentos/menu.inc");
		?>
	</header>

	<main class="row">
		<div class="linea_sep">
            <div id="grafica"> </div>
		</div>
	</main>

	<footer class="row pie">
		<?php
			include_once("segmentos/pie.inc");
		?>
	</footer>

	<!-- jQuery necesario para los efectos de bootstrap -->
    <script src="formatos/bootstrap/js/jquery-1.11.3.min.js"></script>
    <script src="formatos/bootstrap/js/bootstrap.js"></script>
</body>
</html>
