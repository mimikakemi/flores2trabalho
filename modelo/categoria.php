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
Descritivo:Modelo responsável pelo cadastro e gerenciamento de categorias.
 ******************************************************************************/

class Categoria
{

    private $conexao;


    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function cadastrar($nome, $descricao)
    {

        $sql = "INSERT INTO categorias (nome, descricao)
                VALUES (?, ?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ss", $nome, $descricao);

        return $stmt->execute();
    }

    public function listar()
    {

        $sql = "SELECT * FROM categorias";

        return $this->conexao->query($sql);
    }

    public function buscar($id)
    {

        $sql = "SELECT * FROM categorias WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }


    public function editar($id, $nome, $descricao)
    {

        $sql = "UPDATE categorias
                SET nome = ?, descricao = ?
                WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $descricao, $id);

        return $stmt->execute();
    }

    public function excluir($id)
    {

        $sql = "DELETE FROM categorias WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
