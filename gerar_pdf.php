<?php

// Carregar o Composer
require './vendor/autoload.php';

// Receber da URL o termo usado para pesquisar
// $texto_pesquisar = filter_input(INPUT_GET, 'texto_pesquisar', FILTER_DEFAULT);

// Acrescentar no termo de pesquisa "%" para usar no LIKE e indica que pode ter caracteres antes e depois do termo pesquisado
$nome = "%" . $texto_pesquisar . "%";

// Incluir conexao com BD
include_once './conexao.php';

// QUERY para recuperar os registros do banco de dados
$query_usuarios = "SELECT id, description, date, valor,type 
                FROM moviment ORDER BY id DESC";

$result_usuarios = $conn->prepare($query_usuarios);
// $result_usuarios->bindParam(':nome', $nome);
$result_usuarios->execute();

$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
// $dados .= "<link rel='stylesheet' href='http://localhost/MVC-2022/css/custom.css'";
$dados .= "<title>PDF Moviment</title>";
$dados .= "</head>";
$dados .= "<body>";
$dados .= "<h1>Seus Dados do Movimento</h1>";
// while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
//     extract($row_usuario);
    
//     $dados .= "ID: $id <br>";
//     $dados .= "Nome: $description <br>";
//     $dados .= "E-mail: $date <br>";
//     $dados .= "E-mail: $valor <br>";
//     $dados .= "E-mail: $type <br>";
//     $dados .= "<hr>";
// }
$dados .= "</body>";
$dados .= "</html>";

use Dompdf\Dompdf;
$dompdf = new Dompdf(['enable_remote' => true]);
$dompdf->loadHtml($dados);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream();
