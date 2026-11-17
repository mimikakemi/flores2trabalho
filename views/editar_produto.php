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
Descritivo:Tela responsável pela edição de produtos.
 ******************************************************************************/

require_once "../config/conexao.php";
require_once "../modelo/produto.php";

$produto = new Produto($conexao);

$id = $_GET["id"];

$resultado = $produto->buscar($id);
$dados = $resultado->fetch_assoc();

$categorias = $conexao->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <h1>Editar Produto</h1>

    <form action="../controles/ProdutoController.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="acao" value="editar">

        <input type="hidden" name="id"
            value="<?php echo $dados['id']; ?>">

        <label>Nome:</label>
        <input type="text" name="nome"
            value="<?php echo htmlspecialchars($dados['nome']); ?>"
            required>

        <br><br>

        <label>Descrição:</label>
        <input type="text" name="descricao"
            value="<?php echo htmlspecialchars($dados['descricao'] ?? ''); ?>">

        <br><br>

        <label>Foto atual:</label>
        <?php if (!empty($dados["foto"])) { ?>
            <img class="product-photo product-photo-preview" src="../<?php echo htmlspecialchars($dados["foto"], ENT_QUOTES, "UTF-8"); ?>" alt="Foto de <?php echo htmlspecialchars($dados["nome"], ENT_QUOTES, "UTF-8"); ?>">
        <?php } else { ?>
            <p>Este produto ainda não tem foto.</p>
        <?php } ?>

        <label for="foto">Escolher outra foto (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">

        <br><br>

        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" min="0"
            value="<?php echo $dados['preco']; ?>"
            required>

        <br><br>

        <label>Categoria:</label>

        <select name="categoria_id" required>

            <?php while ($linha = $categorias->fetch_assoc()) { ?>

                <option value="<?php echo $linha['id']; ?>"
                    <?php if ($linha['id'] == $dados['categoria_id']) {
                        echo "selected";
                    } ?>>

                    <?php echo htmlspecialchars($linha['nome']); ?>

                </option>

            <?php } ?>

        </select>

        <br><br>

        <button type="submit">Salvar Alterações</button>

    </form>

    <br>

    <a href="produtos.php">Voltar</a>

</body>

</html>