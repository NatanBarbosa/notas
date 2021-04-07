<?php
//Conexão
require "logica/Conexao.php";
$con = new Conexao();
$con = $con->conectar();

//Pegando apenas a matéria selecionada pelo cliente
$query = "SELECT * FROM materia WHERE idMateria = " . $_GET['idMateria'];
$materia = $con->query($query)->fetch(PDO::FETCH_OBJ);

//Vendo se houve algum erro na hora de adicionar nota
if ( isset($_GET['erro']) && $_GET['erro'] == 2 ){
    echo '<script> alert("Preencha todos os campos") </script>';
} else if( isset($_GET['erro']) && $_GET['erro'] == 3 ){
    echo '<script> alert("Preencha o campo notas apenas com valores de 0 - 10") </script>';
}

//Selecionando notas criadas
$query = 'SELECT * FROM nota WHERE idMateria = ' . $materia->idMateria;
$lista_notas = $con->query($query)->fetchAll(PDO::FETCH_OBJ);

//selecionando a média dos valores das colunas de nota
$query = "SELECT AVG(nota) as media from nota where idMateria = " . $_GET['idMateria'];
$media = $con->query($query)->fetch(PDO::FETCH_OBJ);
$media = round($media->media, 2);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> (nome matéria) </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/fa019dc073.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#"> Organiza <br> Notas</a> <i class="fas fa-sticky-note fs-2"></i>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                    aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-3">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link" aria-current="page" href="sobre.html">Sobre</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="container bg-light p-3">
        <div class="row justify-content-center">
            <div class="col-6 text-center">
                <h1 style="color: <?=$materia->corMateria?>"><?=$materia->nomeMateria?> - Notas</h1>
            </div>
        </div>

        <h5>Descrição / Sobre a matéria</h3>
        <p><?=$materia->descricao?></p>

        <br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Atividade/prova</th>
                    <th scope="col">Nota</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($lista_notas as $nota) { ?>
                    <tr>
                        <td> <?=$nota->prova?> </td>
                        <td> <?=$nota->nota?> <button class="btn btn-danger ms-5" onclick="deletaNota(<?=$nota->idNota?>, '<?=$nota->prova?>', <?=$materia->idMateria?>)"> <i class="fas fa-trash"></i> </button></td> 
                    </tr> 
                <?}?>  
                <tr>
                    <td class="fw-bold">Média</td>
                    <td class="fw-bold"> <?=$media?> </td>
                </tr>
                <tr>
                    <td class="fw-bold"> <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addnota"> Adicionar nota </button> </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="addnota" tabindex="-1" aria-labelledby="addnota" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="logica/criaNota.php" method="POST">

                        <div class="modal-body">
                                <label for="prova"> Prova / atividade </label> <br>
                                <input type="text" class="form-control my-3" id="prova" name="prova">
        
                                <label for="nota"> nota </label> <br>
                                <input type="number" class="form-control my-3" id="nota" name="nota" placeholder="0 - 10" step="any">

                                <input type="hidden" name="idMateria" value="<?=$materia->idMateria?>">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <a href="index.php" class="btn btn-secondary"> <i class="fas fa-arrow-circle-left"></i> Voltar</a>

    </section>
    
    <script>
        function deletaNota(idNota, prova, idMateria){
            if( confirm(`Você tem certeza que deseja deletar a nota da ${prova}?`) ){
                location.href = `logica/deletaNota.php?idNota=${idNota}&idMateria=${idMateria}`
            }
        }
    </script>
</body>

</html>