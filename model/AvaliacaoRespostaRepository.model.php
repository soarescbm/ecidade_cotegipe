<?php

/**
 *   
 */
class AvaliacaoRespostaRepository {
  
  private function __construct() {}

  /**
   * Remove avaliacao das tabelas avaliacaresposta e avaliacaogruporesposta
   * @param  AvaliacaoResposta $oAvaliacaoResposta 
   * @return boolean                                
   */
  public static function delete(AvaliacaoResposta $oAvaliacaoResposta) {

    $oDaoAvaliacaoResposta = new cl_avaliacaoresposta();
    $oDaoAvaliacaoGrupo    = new cl_avaliacaogrupoperguntaresposta();
    $sWhereAvaliacaoSalva  = "    db108_avaliacaogruporesposta = {$oAvaliacaoResposta->getPergunta()->getAvaliacao()} ";
    $sWhereAvaliacaoSalva .= "and db104_avaliacaopergunta      = {$oAvaliacaoResposta->getPergunta()->getCodigo()}";

    $sSqlAvaliacaoSalva = $oDaoAvaliacaoGrupo->sql_query(null,"db108_sequencial, db106_sequencial", null, $sWhereAvaliacaoSalva);
    $rsAvaliacaoSalva   = db_query($sSqlAvaliacaoSalva);

    db_utils::makeCollectionFromRecord($rsAvaliacaoSalva, function($oAvaliacaoSalva) use ($oDaoAvaliacaoResposta, $oDaoAvaliacaoGrupo) {

      $oDaoAvaliacaoGrupo->excluir(null   , "db108_sequencial = {$oAvaliacaoSalva->db108_sequencial}");
      $oDaoAvaliacaoResposta->excluir(null, "db106_sequencial = {$oAvaliacaoSalva->db106_sequencial}");
      
      if ($oDaoAvaliacaoResposta->erro_status == 0) {
        throw new DBException("Ocorreu um erro ao salvar os dados da oergunta.");
      }
    }); 

    return true;
  }

  /**
   * Persiste os dados nas tabelas avaliacaoresposta e na avaliacaogrupoperguntaresposta.
   * @param  AvaliacaoResposta $oAvaliacaoResposta AvaliacaoResposta
   * @return boolean
   */
  public static function persist(AvaliacaoResposta $oAvaliacaoResposta) {

    $oDaoAvaliacaoResposta = new cl_avaliacaoresposta();
    $oDaoAvaliacaoGrupo    = new cl_avaliacaogrupoperguntaresposta();

    $oDaoAvaliacaoResposta->db106_avaliacaoperguntaopcao = $oAvaliacaoResposta->getPerguntaOpcao();
    $oDaoAvaliacaoResposta->db106_resposta               = $oAvaliacaoResposta->getResposta();
    $oDaoAvaliacaoResposta->incluir(null);
          
    if ($oDaoAvaliacaoResposta->erro_status == 0) {
      throw new DBException("Erro ao persistir dados na tabela avaliacaoresposta");
    }

    $oDaoAvaliacaoGrupo->db108_avaliacaoresposta      = $oDaoAvaliacaoResposta->db106_sequencial;
    $oDaoAvaliacaoGrupo->db108_avaliacaogruporesposta = $oAvaliacaoResposta->getPergunta()->getAvaliacao();
    $oDaoAvaliacaoGrupo->incluir(null);

    if ($oDaoAvaliacaoGrupo->erro_status == 0) {
      throw new DBException("Erro ao persistir dados na tabela avaliacaogrupoperguntaresposta");
    }

    return true;
  }
}

