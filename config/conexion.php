<?php 

    //Conectar a Mysql
    $con = mysqli_connect("localhost", "root", "", "arquiartegrafstudio7");

    //Probar conexión
    if(mysqli_connect_errno()){
        echo "Fallo al conectarse a Mysql: "  .mysqli_connect_error();
    }/* else{
        echo "Conectado correctamente";
    } */