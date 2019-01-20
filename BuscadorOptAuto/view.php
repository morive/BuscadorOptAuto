<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap3-typeahead.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <title>RSS</title>
</head>
<body>
<h1></h1>
<br/><br/>
<div class="container" style="width:700px;">
    <h2 align="center">Buscador de Noticias RSS</h2>
    <br/><br/>
      <form action="view.php" method="post" style="text-align:left">
    <label>Palabra Clave:</label>
    <input type="text" name="clave" id="clave" class="form-control input-lg" autocomplete="off"
           placeholder="Articulo Buscar"/>
           </form>
</div>
<script>
    $(document).ready(function () {
        $("#clave").typeahead({
            source: function (query, resultado) {
                $.ajax({
                    url: "accion.php",
                    type: "POST",
                    dataType: "json",
                    data: {query: query},
                    success: function (data) {
                        resultado($.map(data, function (item) {
                            return item;
                        }));
                    }
                });
            }
        });
    });
</script>
</body>
</html>


<?php

$mysqli = new mysqli("localhost","root","","inforss");
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}

if ($resultado = $mysqli->query("SELECT * FROM news_rss")) {
    echo '<div id="principal">';
    while($row = $resultado->fetch_assoc()){
        echo '<div>';
        echo '<h3>' . $row['title'] . '</h3>';
        echo '<p>' . $row['date'] . '</p>';
        echo '<p>'.$row['description'].'</p>';
        echo '<a href="'. $row['link'].'">Presiona aquí para ir a ver la noticia oficial</a>';
        echo '<hr />';
        echo '</div>';
        //$index++;
    }
    echo '</div>';
    $resultado->close();
}

if(isset($_POST['clave'])){
    if ($resultado = $mysqli->query("SELECT * FROM news_rss WHERE title LIKE '%".$_POST['clave']."%'")) {
        echo '<script>var div = document.getElementById(\'principal\'); div.remove() </script>';
        echo '<div id="principal">';
        while($row = $resultado->fetch_assoc()){
            echo '<div>';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<p>' . $row['date'] . '</p>';
            echo '<p>'.$row['description'].'</p>';
            echo '<a href="'. $row['link'].'">Presiona aquí para ir a ver la noticia oficial<a>';
            echo '<hr />';
            echo '<div>';
            //$index++;
        }
        $resultado->close();
    }
}



?>
