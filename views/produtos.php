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
Descritivo:Tela de cadastro e listagem de produtos.
 ******************************************************************************/

require_once "../config/conexao.php";
require_once "../modelo/produto.php";

$produto = new Produto($conexao);
$produtos = $produto->listar();

$sql = "SELECT * FROM categorias";
$categorias = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <a class="back-home" href="../index.php">Voltar para a página inicial</a>

    <h1>Gerenciamento de Produtos</h1>

    <h2>Cadastrar Produto</h2>

    <form action="../controles/ProdutoController.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="acao" value="cadastrar">

        <label>Nome do produto:</label>
        <input type="text" name="nome" required>

        <br><br>

        <label>Descrição:</label>
        <input type="text" name="descricao">

        <br><br>

        <label>Foto do produto (opcional):</label>
        <input type="file" name="foto" accept="image/jpeg,image/png,image/webp">

        <br><br>

        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" min="0" required>

        <br><br>

        <label>Categoria:</label>

        <select name="categoria_id" required>
            <option value="">Selecione uma categoria</option>

            <?php while ($linha = $categorias->fetch_assoc()) { ?>

                <option value="<?php echo $linha['id']; ?>">
                    <?php echo htmlspecialchars($linha['nome']); ?>
                </option>

            <?php } ?>

        </select>

        <br><br>

        <button type="submit">Cadastrar Produto</button>

    </form>

    <hr>

    <h2>Produtos Cadastrados</h2>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>

        <?php while ($linha = $produtos->fetch_assoc()) { ?>

            <tr>
                <td><?php echo $linha["id"]; ?></td>

                <td>
                    <?php if (!empty($linha["foto"])) { ?>
                        <img class="product-photo" src="../<?php echo htmlspecialchars($linha["foto"], ENT_QUOTES, "UTF-8"); ?>" alt="Foto de <?php echo htmlspecialchars($linha["nome"], ENT_QUOTES, "UTF-8"); ?>">
                    <?php } else { ?>
                        <span>Sem foto</span>
                    <?php } ?>
                </td>

                <td><?php echo htmlspecialchars($linha["nome"]); ?></td>

                <td><?php echo htmlspecialchars($linha["descricao"] ?? ""); ?></td>

                <td>R$ <?php echo number_format($linha["preco"], 2, ",", "."); ?></td>

                <td><?php echo htmlspecialchars($linha["categoria_nome"]); ?></td>

                <td>

                    <a href="editar_produto.php?id=<?php echo $linha['id']; ?>">
                        Editar
                    </a>

                    <form action="../controles/ProdutoController.php"
                        method="POST" style="display:inline;">

                        <input type="hidden" name="acao" value="excluir">

                        <input type="hidden" name="id"
                            value="<?php echo $linha['id']; ?>">

                        <button type="submit">Excluir</button>

                    </form>

                </td>
            </tr>

        <?php } ?>

    </table>

</body>

</html>