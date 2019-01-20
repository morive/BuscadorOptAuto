<?php
include "conexion.php";

if (isset($_POST['query'])) {

    $respuesta = mysqli_real_escape_string($cn, $_POST['query']);
    $data = array();
    $sql = "SELECT * from news_rss WHERE title LIKE '%" . $respuesta . "%'";
    $res = $cn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $data[] = $row["title"];
        }
        echo json_encode($data);
    }

}
