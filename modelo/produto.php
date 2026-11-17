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
Descritivo:Modelo responsável pelo cadastro e gerenciamento de produtos.
 ******************************************************************************/

class Produto
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }


    public function cadastrar($nome, $descricao, $preco, $categoria_id, $foto = null)
    {

        $sql = "INSERT INTO produtos (nome, descricao, preco, categoria_id, foto)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssdis", $nome, $descricao, $preco, $categoria_id, $foto);

        return $stmt->execute();
    }

    public function listar()
    {

        $sql = "SELECT produtos.*, categorias.nome AS categoria_nome
                FROM produtos
                INNER JOIN categorias
                ON produtos.categoria_id = categorias.id";

        return $this->conexao->query($sql);
    }

    public function buscar($id)
    {

        $sql = "SELECT * FROM produtos WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }


    public function editar($id, $nome, $descricao, $preco, $categoria_id, $foto = null)
    {

        if ($foto === null) {
            $sql = "UPDATE produtos
                    SET nome = ?, descricao = ?, preco = ?, categoria_id = ?
                    WHERE id = ?";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("ssdii", $nome, $descricao, $preco, $categoria_id, $id);
        } else {
            $sql = "UPDATE produtos
                    SET nome = ?, descricao = ?, preco = ?, categoria_id = ?, foto = ?
                    WHERE id = ?";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("ssdisi", $nome, $descricao, $preco, $categoria_id, $foto, $id);
        }

        return $stmt->execute();
    }

    public function excluir($id)
    {

        $sql = "DELETE FROM produtos WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
