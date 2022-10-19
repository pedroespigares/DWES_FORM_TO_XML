<?php
	echo "<h1>Crea aquí tu archivo XML</h1>";
	echo "<br />";
	echo "<b>Consideraciones a tener en cuenta:</b>";
	echo "<ul>";
	echo "<li>Puede no haber profesores asignados a una asignatura. En ese caso no se crea el nodo correspondiente.</li>";
	echo "<li>RECORDATORIO php: Si no hay profes, el array no existe. Que no es lo mismo a que esté vacío. Usa isset.</li>";
	echo "<li>Guarda el fichero en la misma carpeta del script con el nombre <i>asignaturas.xml</i>. Después, lo muestras en el navegador</li>";
	echo "<li><b>Versión 1.0</b>: Crea un archivo XML nuevo por cada ejecución del script.</li>";
	echo "<li><b>Versión 2.0</b>: Ir acumulando asignaturas en el XML cuando se llame al script. Para ello, deberás comprobar si existe el archivo para abrirlo, cargarlo en un objeto simpleXML y añadir la nueva asignatura.</li>";
	echo "</ul>";
	echo "<a href='#' onclick='history.go(-1);'>Ir atrás</a>";

    function crearXML(){
        $asignatura = new SimpleXMLElement("<asignatura></asignatura>");

        $asignatura -> addChild("codigo",$_POST["codigo"]);
        $asignatura -> addChild("nombre",$_POST["nombre"]);
        $asignatura -> addChild("duracion",$_POST["duracion"]);
        $asignatura -> addChild("tipo",$_POST["tipo"]);

        if(isset($_POST["titDNI"]) || isset($_POST["pracDNI"])){
            $teachers = $asignatura -> addChild("profesores");
        }

        if(isset($_POST["titDNI"]) && isset($_POST["titNombre"]) && isset($_POST["titApellidos"])){
            $titulares = $teachers -> addChild("titulares");
            for($i = 0; $i < count($_POST["titDNI"]); $i++){
                $singleTitularTeacher = $titulares -> addChild("profesor");
                $singleTitularTeacher -> addChild("DNI",$_POST["titDNI"][$i]);
                $singleTitularTeacher -> addChild("nombre",$_POST["titNombre"][$i]);
                $singleTitularTeacher -> addChild("apellidos",$_POST["titApellidos"][$i]);
            }
        }

        if(isset($_POST["pracDNI"]) && isset($_POST["pracNombre"]) && isset($_POST["pracApellidos"])){
            $practicas = $teachers -> addChild("practicas");
            for($i = 0; $i < count($_POST["pracDNI"]); $i++){
                $singlePracticeTeacher = $practicas -> addChild("profesor");
                $singlePracticeTeacher -> addChild("DNI",$_POST["pracDNI"][$i]);
                $singlePracticeTeacher -> addChild("nombre",$_POST["pracNombre"][$i]);
                $singlePracticeTeacher -> addChild("apellidos",$_POST["pracApellidos"][$i]);
            }
        }

        $asignatura->asXML("asignaturas.xml");

        header("Location: asignaturas.xml");
    }

    if(isset($_POST["codigo"])){
        crearXML();
    }
?>