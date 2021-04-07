<?php
//conectar ao Banco de dados
require "Conexao.php";
$con = new Conexao();
$con = $con->conectar();

//Excluir
$query = 'DELETE FROM nota WHERE idNota = ' . $_GET['idNota'];
$stmt = $con->prepare($query);
$stmt->execute();

header('Location: ../materia.php?idMateria=' . $_GET['idMateria']);