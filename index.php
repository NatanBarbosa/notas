<?php
require "logica/Conexao.php";
$con = new Conexao();
$con = $con->conectar();

//listar matérias escolares
$lista_materiaEscolar = $con->query("SELECT * FROM materia where tipoMateria = 1");
$lista_materiaEscolar = $lista_materiaEscolar->fetchAll(PDO::FETCH_OBJ);

//listar matérias técnicas
$lista_materiaTecnica = $con->query("SELECT * FROM materia where tipoMateria = 2");
$lista_materiaTecnica = $lista_materiaTecnica->fetchAll(PDO::FETCH_OBJ);

//listar outras matérias
$lista_materiaOutras = $con->query("SELECT * FROM materia where tipoMateria = 3");
$lista_materiaOutras = $lista_materiaOutras->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizador de notas</title>

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
                <h1>Suas notas</h1>
            </div>
        </div>

        <!-- Matérias escolares -->
        <?if(count($lista_materiaEscolar) !== 0){?>
            <h3>Matérias escolares</h3>
            <div class="row my-3">
                <?foreach ($lista_materiaEscolar as $me) {?>
                    <?
                        //tirando média da matéria 
                        $query = "SELECT AVG(nota) as media from nota where idMateria = " . $me->idMateria;
                        $media = $con->query($query)->fetch(PDO::FETCH_OBJ);
                        $media = round($media->media, 2);    

                        //pegando o número de notas adicionadas
                        $query = "SELECT COUNT(idNota) as count from nota where idMateria = " . $me->idMateria;
                        $count = $con->query($query)->fetch(PDO::FETCH_OBJ); 
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card" style="border-color: <?= $me->corMateria ?>">
                            <div class="card-header">
                                Matéria escolar
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="color: <?= $me->corMateria ?>"> <?= $me->nomeMateria ?> </h5>
                                <p class="card-text">
                                    <strong>Descrição:</strong> <?= $me->descricao ?>
                                </p>
                                <p class="card-text">
                                    <strong> adicionadas:</strong> <?=$count->count?> <br>
                                    <strong> Nota média:</strong> <?=$media?>
                                </p>
                                <a href="materia.php?idMateria=<?=$me->idMateria?>" class="btn btn-primary">Ir para matéria</a> <button onclick="deletaMateria(<?=$me->idMateria?>, '<?=$me->nomeMateria?>')" class="btn btn-danger"> <i class="fas fa-trash"></i> </button>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        <?}?>

        <!-- Matérias técnicas -->
        <?if(count($lista_materiaTecnica) !== 0){?>
            <h3>Matérias técnicas</h3>
            <div class="row my-3">
                <?foreach ($lista_materiaTecnica as $mt) {?>
                    <?
                        //tirando média da matéria 
                        $query = "SELECT AVG(nota) as media from nota where idMateria = " . $mt->idMateria;
                        $media = $con->query($query)->fetch(PDO::FETCH_OBJ);
                        $media = round($media->media, 2);    

                        //pegando o número de notas adicionadas
                        $query = "SELECT COUNT(idNota) as count from nota where idMateria = " . $mt->idMateria;
                        $count = $con->query($query)->fetch(PDO::FETCH_OBJ); 
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card" style="border-color: <?= $mt->corMateria ?>">
                            <div class="card-header">
                                Matéria técnica
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="color: <?= $mt->corMateria ?>"> <?= $mt->nomeMateria ?> </h5>
                                <p class="card-text">
                                    <strong>Descrição:</strong> <?= $mt->descricao ?>
                                </p>
                                <p class="card-text">
                                    <strong> adicionadas:</strong> <?=$count->count?> <br>
                                    <strong> Nota média:</strong> <?=$media?>
                                </p>
                                <a href="materia.php?idMateria=<?=$mt->idMateria?>" class="btn btn-primary">Ir para matéria</a> <button onclick="deletaMateria(<?=$mt->idMateria?>, '<?=$mt->nomeMateria?>')" class="btn btn-danger"> <i class="fas fa-trash"></i> </button>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        <?}?>

        <!-- Outras Matérias -->
        <?if(count($lista_materiaOutras) !== 0){?>
            <h3>Outras Matérias</h3>
            <div class="row my-3">
                <?foreach ($lista_materiaOutras as $mo) {?>
                    <?
                        //tirando média da matéria 
                        $query = "SELECT AVG(nota) as media from nota where idMateria = " . $mo->idMateria;
                        $media = $con->query($query)->fetch(PDO::FETCH_OBJ);
                        $media = round($media->media, 2);    

                        //pegando o número de notas adicionadas
                        $query = "SELECT COUNT(idNota) as count from nota where idMateria = " . $mo->idMateria;
                        $count = $con->query($query)->fetch(PDO::FETCH_OBJ); 
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card" style="border-color: <?= $mo->corMateria ?>">
                            <div class="card-header">
                                Outra matéria
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="color: <?= $mo->corMateria ?>"> <?= $mo->nomeMateria ?> </h5>
                                <p class="card-text">
                                    <strong>Descrição:</strong> <?= $mo->descricao ?>
                                </p>
                                <p class="card-text">
                                    <strong> adicionadas:</strong> <?=$count->count?> <br>
                                    <strong> Nota média:</strong> <?=$media?>
                                </p>
                                <a href="materia.php?idMateria=<?=$mo->idMateria?>" class="btn btn-primary">Ir para matéria</a> <button onclick="deletaMateria(<?=$mo->idMateria?>, '<?=$mo->nomeMateria?>')" class="btn btn-danger"> <i class="fas fa-trash"></i> </button>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        <?}?>

        <!-- trigger modal -->
        <button type="button" class="btn btn-outline-success btn-lg" data-bs-toggle="modal" data-bs-target="#addMateria">
            Adicionar matéria
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addMateria" tabindex="-1" aria-labelledby="addMateria" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicione uma matéria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="logica/criaMateria.php" method="post">
                        <div class="modal-body">
                                <label for="nomeMateria"> Nome da matéria </label> <br>
                                <input type="text" class="form-control my-3" id="nomeMateria" name="nomeMateria">

                                <label for="corMateria"> Cor da fonte <small>(evite cores claras)</small> </label> <br>
                                <input type="color" class="form-control my-3" id="corMateria" name="corMateria">

                                <label for="tipoMateria"> Tipo de matéria </label> <br>
                                <select class="form-control my-3" id="tipoMateria" name="tipoMateria">
                                    <option value="">Selecione um tipo</option>
                                    <option value="1">Escolar</option>
                                    <option value="2">Curso técnico</option>
                                    <option value="3">Outros</option>
                                </select>

                                <label for="descricao"> Descrição da matéria (opcional) </label> <br>
                                <textarea class="form-control my-3" id="descricao" name="descricao"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </section>

    <?php
        if(isset($_GET['erro']) && $_GET['erro'] == "1"){
            echo "<script> alert('Digite todos os dados necessários') </script>";
        }
    ?>

    <script>
        function deletaMateria(idMateria, nomeMateria){
            if ( confirm("você tem certeza que quer deletar a matéria " + nomeMateria) ){
                location.href = "logica/deletaMateria.php?id=" + idMateria
            }
        }
    </script>
</body>

</html>