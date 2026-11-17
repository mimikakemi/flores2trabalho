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
Descritivo:Tela de edição das categorias.
 ******************************************************************************/

require_once "../config/conexao.php";
require_once "../modelo/Categoria.php";

$categoria = new Categoria($conexao);

$id = $_GET["id"];
$resultado = $categoria->buscar($id);
$dados = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <h1>Editar Categoria</h1>

    <form action="../controles/CategoriaController.php" method="POST">

        <input type="hidden" name="acao" value="editar">

        <input type="hidden" name="id"
            value="<?php echo $dados['id']; ?>">

        <label>Nome da categoria:</label>
        <input type="text" name="nome"
            value="<?php echo htmlspecialchars($dados['nome']); ?>"
            required>

        <br><br>

        <label>Descrição:</label>
        <input type="text" name="descricao"
            value="<?php echo htmlspecialchars($dados['descricao'] ?? ''); ?>">

        <br><br>

        <button type="submit">Salvar Alterações</button>

    </form>

    <br>

    <a href="categorias.php">Voltar</a>

</body>

</html>