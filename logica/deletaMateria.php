<?php

require "Conexao.php";
$con = new Conexao();
$con = $con->conectar();

//Deletar matéria
$stmt = $con->prepare('DELETE FROM materia where idMateria = ' . $_GET['id']);
$stmt->execute();
print_r($stmt->errorInfo() );

header('Location: ../index.php');
