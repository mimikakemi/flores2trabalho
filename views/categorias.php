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
Descritivo:Tela de cadastro e listagem de categorias.
 ******************************************************************************/

require_once "../config/conexao.php";
require_once "../modelo/Categoria.php";

$categoria = new Categoria($conexao);
$categorias = $categoria->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <a class="back-home" href="../index.php">Voltar para a página inicial</a>

    <h1>Gerenciamento de Categorias</h1>

    <h2>Cadastrar Categoria</h2>

    <form action="../controles/CategoriaController.php" method="POST">

        <input type="hidden" name="acao" value="cadastrar">

        <label>Nome da categoria:</label>
        <input type="text" name="nome" required>

        <br><br>

        <label>Descrição:</label>
        <input type="text" name="descricao">

        <br><br>

        <button type="submit">Cadastrar</button>

    </form>

    <hr>

    <h2>Categorias Cadastradas</h2>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>

        <?php while ($linha = $categorias->fetch_assoc()) { ?>

            <tr>
                <td><?php echo $linha["id"]; ?></td>
                <td><?php echo htmlspecialchars($linha["nome"]); ?></td>
                <td><?php echo htmlspecialchars($linha["descricao"] ?? ""); ?></td>

                <td>
                    <a href="editar_categoria.php?id=<?php echo $linha['id']; ?>">
                        Editar
                    </a>

                    <form action="../controles/CategoriaController.php" method="POST" style="display:inline;">
                        <input type="hidden" name="acao" value="excluir">
                        <input type="hidden" name="id" value="<?php echo $linha['id']; ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>

        <?php } ?>

    </table>

</body>

</html>