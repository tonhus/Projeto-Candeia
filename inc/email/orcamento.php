<?php

header('Content-Type: text/html; charset=UTF-8');

require 'inc/classes/Funcoes_auxiliares.php';
require 'inc/classes/ClienteOrcamento.php';
require 'Envia_orcamento.php';

$confirmacao = false;

if(isset($_POST) && count($_POST) > 0) {

    $cliente = new ClienteOrcamento();


    $cliente->dados['nome'] = $_POST["inputNomeOrc"];
    $cliente->dados['email'] = $_POST["inputEmailOrc"];
    $cliente->dados['telefone'] = Funcoes_auxiliares::limpaEspacosBranco($_POST["inputTelOrc"]);
    $cliente->dados['cad_data'] = $_POST["inputDataOrc"];


    $enviador = substr($cliente->dados['nome'], 0, strpos($cliente->dados['nome'], " "));

    $cabeçalho = "Data: " . implode("/", array_reverse(explode("-", $cliente->dados['cad_data']))) .
        "\n\nNome: " . $cliente->dados['nome'] . "\n\nTelefone: " . Funcoes_auxiliares::formataTelefone($cliente->dados['telefone']) .
        "\n\nE-mail: " . $cliente->dados['email'] . "\n\n";

    $tipoDeProjeto = [];

    if (isset($_POST["identVisual"])) {
        array_push($tipoDeProjeto, $_POST["identVisual"]);
    }
    if (isset($_POST["designInterior"])) {
        array_push($tipoDeProjeto, $_POST["designInterior"]);
    }
    if (isset($_POST["marcaSimples"])) {
        array_push($tipoDeProjeto, $_POST["marcaSimples"]);
    }
    if (isset($_POST["opProduto"])) {
        array_push($tipoDeProjeto, $_POST["opProduto"]);
    }

    $projetos = "";

    foreach ($tipoDeProjeto as $tipo) {
        $projetos .= " * " . $tipo . "\n";
    }

    if (count($tipoDeProjeto) != 0) {
        $projetos = "\n# Tipos de projetos\n\n" . $projetos;
    }

    $camposTexto = [];

    if (strlen($_POST["campoAtuacao"]) > 0) {
        array_push($camposTexto, "# Campo de atuação da empresa\n" . $_POST["campoAtuacao"]);
    }
    if (strlen($_POST["historiaEmpresa"]) > 0) {
        array_push($camposTexto, "# Historia da Empresa\n" . $_POST["historiaEmpresa"]);
    }
    if (strlen($_POST["missaoValores"]) > 0) {
        array_push($camposTexto, "# Missão de valores\n" . $_POST["missaoValores"]);
    }
    if (strlen($_POST["publicoDesejado"]) > 0) {
        array_push($camposTexto, "# Público desejado\n" . $_POST["publicoDesejado"]);
    }
    if (strlen($_POST["objetivoNegocio"]) > 0) {
        array_push($camposTexto, "# Adjetivo que define o negócio\n" . $_POST["objetivoNegocio"]);
    }
    if (strlen($_POST["possuiSlogan"]) > 0) {
        array_push($camposTexto, "# Slogan\n" . $_POST["possuiSlogan"]);
    }
    if (strlen($_POST["msgParaPassar"]) > 0) {
        array_push($camposTexto, "# Mensagem que deseja passar\n" . $_POST["msgParaPassar"]);
    }
    if (strlen($_POST["produtosNoMercado"]) > 0) {
        array_push($camposTexto, "# Produtos no mercado\n" . $_POST["produtosNoMercado"]);
    }
    if (strlen($_POST["principaisConcorrentes"]) > 0) {
        array_push($camposTexto, "# Principais Concorrentes\n" . $_POST["principaisConcorrentes"]);
    }
    if (strlen($_POST["produtosParaDesenvolver"]) > 0) {
        array_push($camposTexto, "# Produtos a serem desenvolvidos\n" . $_POST["produtosParaDesenvolver"]);
    }
    if (strlen($_POST["preferenciaDeMaterial"]) > 0) {
        array_push($camposTexto, "# Material preferencial\n" . $_POST["preferenciaDeMaterial"]);
    }
    if (strlen($_POST["restricao"]) > 0) {
        array_push($camposTexto, "# Restrições\n" . $_POST["restricao"]);
    }
    if (strlen($_POST["dataDeLancamento"]) > 0) {
        array_push($camposTexto, "# Data para lançamento\n" . $_POST["dataDeLancamento"]);
    }
    if (strlen($_POST["limiteDeOrcamento"]) > 0) {
        array_push($camposTexto, "# Limitação do orçamento\n" . $_POST["limiteDeOrcamento"]);
    }
    if (strlen($_POST["informExtras"]) > 0) {
        array_push($camposTexto, "# Informações extras\n" . $_POST["informExtras"]);
    }

    $camposPreenchidos = "\n";

    foreach ($camposTexto as $campo) {
        $camposPreenchidos .= $campo . "\n";
    }
    $camposPreenchidos .= "\n";

    $Vai = $cabeçalho . $projetos . $camposPreenchidos;


//if (Envia_orcamento::smtpmailer('antonio.wac@gmail.com', $cliente->dados['email'], $enviador, utf8_encode('Orcamento'), $Vai)) {
    $cliente->gravarCliente();
    $confirmacao = true;
//    //echo "<meta http-equiv='Refresh' content='2;URL=./'>"; // Redireciona para uma página.
//}
//if (!empty($error)) echo $error;
}
