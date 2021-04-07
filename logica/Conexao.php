<?php

class Conexao {
    private $host = 'localhost';
    private $dbname = 'bd_notas';
    private $user = 'root';
    private $pass = '';

    public function conectar(){
        try {
            return new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        } catch (PDOException $e){
            echo "Não foi possível se conectar ao banco de dados. <br> <strong>Código do erro:</strong>" . $e->getCode(). "<br> <strong>Mensagem do erro:</strong>" . $e->getMessage();
        }
    }
}