<?php
require "Conexao.php";
$con = new Conexao();
$con = $con->conectar();

//verificação se os dados estão preenchidos
if ($_POST['nomeMateria'] == "" || $_POST['tipoMateria'] == ""){
    header('Location: ../index.php?erro=1');
} else {
    //adicionar matéria no banco de dados
    $query = "INSERT INTO materia(nomeMateria, corMateria, descricao, tipoMateria) values (:nomeMateria, :corMateria, :descricao, :tipoMateria)";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':nomeMateria', $_POST['nomeMateria']);
    $stmt->bindValue(':corMateria', $_POST['corMateria']);
    $stmt->bindValue(':descricao', $_POST['descricao']);
    $stmt->bindValue(':tipoMateria', $_POST['tipoMateria']);
    $stmt->execute();
    header('Location: ../index.php');
}




