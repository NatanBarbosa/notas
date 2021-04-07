<?php
//conectar ao Banco de dados
require "Conexao.php";
$con = new Conexao();
$con = $con->conectar();

echo "<pre>";
print_r($_POST);
echo "</pre>";

if($_POST['prova'] == "" || $_POST['nota'] == ""){
    //faltando informação
    header('Location: ../materia.php?idMateria=' . $_POST['idMateria'] . '&erro=2');
} else if($_POST['nota'] > 10 || $_POST['nota'] < 0){
    //Nota não está entre 0 e 10
    header('Location: ../materia.php?idMateria=' . $_POST['idMateria'] . '&erro=3');
} else {
    #processo de adição da nota ao banco de dados
    $query = 'INSERT INTO nota(prova, nota, idMateria) VALUES(:prova, :nota, :idMateria)';
    $stmt = $con->prepare($query);
    $stmt->bindValue( ":prova", $_POST['prova'] );
    $stmt->bindValue( ":nota", round($_POST['nota'], 1) );
    $stmt->bindValue( ":idMateria", $_POST['idMateria'] );
    $stmt->execute();
    
    header('Location: ../materia.php?idMateria=' . $_POST["idMateria"]);
}