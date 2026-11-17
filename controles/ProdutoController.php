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
Descritivo:Controlador responsável pelas operações dos produtos.
 ******************************************************************************/


require_once "../config/conexao.php";
require_once "../modelo/produto.php";

$produto = new Produto($conexao);

function salvarFotoProduto()
{
    if (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES["foto"]["error"] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Não foi possível enviar a foto. Tente novamente.");
    }

    if ($_FILES["foto"]["size"] > 5 * 1024 * 1024) {
        throw new RuntimeException("A foto deve ter no máximo 5 MB.");
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES["foto"]["tmp_name"]);
    $extensoesPermitidas = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    if (!isset($extensoesPermitidas[$mime]) || getimagesize($_FILES["foto"]["tmp_name"]) === false) {
        throw new RuntimeException("Formato inválido. Envie uma imagem JPG, PNG ou WEBP.");
    }

    $pasta = __DIR__ . "/../uploads/produtos";
    if (!is_dir($pasta) && !mkdir($pasta, 0755, true) && !is_dir($pasta)) {
        throw new RuntimeException("Não foi possível criar a pasta de fotos dos produtos.");
    }

    $nomeArquivo = bin2hex(random_bytes(16)) . "." . $extensoesPermitidas[$mime];
    $caminho = $pasta . "/" . $nomeArquivo;

    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $caminho)) {
        throw new RuntimeException("Não foi possível salvar a foto enviada.");
    }

    return "uploads/produtos/" . $nomeArquivo;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $acao = $_POST["acao"];

    try {
        if ($acao == "cadastrar") {
            $foto = salvarFotoProduto();
            $salvo = $produto->cadastrar(
                $_POST["nome"],
                $_POST["descricao"],
                $_POST["preco"],
                $_POST["categoria_id"],
                $foto
            );
        } elseif ($acao == "editar") {
            $foto = salvarFotoProduto();
            $salvo = $produto->editar(
                $_POST["id"],
                $_POST["nome"],
                $_POST["descricao"],
                $_POST["preco"],
                $_POST["categoria_id"],
                $foto
            );
        } elseif ($acao == "excluir") {
            $salvo = $produto->excluir($_POST["id"]);
        } else {
            throw new RuntimeException("Ação inválida.");
        }

        if (!$salvo) {
            throw new RuntimeException("Não foi possível salvar as alterações no banco de dados.");
        }
    } catch (RuntimeException $erro) {
        http_response_code(400);
        echo "<p>" . htmlspecialchars($erro->getMessage(), ENT_QUOTES, "UTF-8") . "</p>";
        echo '<p><a href="../views/produtos.php">Voltar aos produtos</a></p>';
        exit;
    }

    header("Location: ../views/produtos.php");
    exit;
}
