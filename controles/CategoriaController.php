<?php

/******************************************************************************
Curso: Engenharia de Software
Disciplina: Linguagem e Técnicas de Programacão
Professor: Flores
Turma: ESOFT-2
Componentes:
    26014891-2 - Ana Clara Amantino
    26005411-2 - Edson Robson Meneses Junior
    26015396-2 - João Winicios Lopo Oliveira
    26002469-2 - Júlia Rafaela Akemi Assakura
    226011155-2 - Kauã Teodoro Cardoso
    26006574-2 - Vitor Ferst Wosniak
Data: 03 de Novembro de 2026
Descritivo: Controlador responsável pelas ações das categorias.
 ******************************************************************************/

require_once "../config/conexao.php";
require_once "../modelo/categoria.php";

$categoria = new Categoria($conexao);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $acao = $_POST["acao"];

    if ($acao == "cadastrar") {

        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];

        $categoria->cadastrar($nome, $descricao);
    }

    if ($acao == "editar") {

        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];

        $categoria->editar($id, $nome, $descricao);
    }

    if ($acao == "excluir") {

        $id = $_POST["id"];

        $categoria->excluir($id);
    }

    header("Location: ../views/categorias.php");
    exit;
}
