<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */
namespace ECidade\Configuracao\Formulario\Resposta\Repository;
use ECidade\Configuracao\Formulario\Model\Formulario;
use ECidade\Configuracao\Formulario\Model\Opcao;
use ECidade\Configuracao\Formulario\Repository\Pergunta;
use ECidade\Configuracao\Formulario\Resposta\Model\Resposta as RespostaModel;
use ECidade\Configuracao\Formulario\Resposta\Model\Valor;

/**
 * Class Resposta
 * @package ECidade\Configuracao\Formulario\Model
 */
class Resposta {


  /**
   * @var \ECidade\Configuracao\Formulario\Repository\Formulario
   */
  private static $instance = null;

  /**
   * @var \ECidade\Configuracao\Formulario\Resposta\Model\Resposta
   */
  public $respostas;


  protected function __construct() {

  }

  /**
   * @return \ECidade\Configuracao\Formulario\Resposta\Repository\Resposta
   */
  public static function getInstance() {

    if (empty(self::$instance)) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  /**
   * Retorna todos os Formularios que responderam as pergunta com informadas
   * @param \ECidade\Configuracao\Formulario\Model\Formulario $formulario
   * @param array                                             $perguntas
   * @return array
   * @throws \BusinessException
   */
  public static function getPorFormularioECampos(Formulario $formulario, array $perguntas) {

    $oDaoAvaliacaoResposta = new \cl_avaliacaogrupoperguntaresposta;
    
    $aWhere         = array("db101_sequencial = {$formulario->getCodigo()}");    
    foreach ($perguntas as $pergunta) {      
      
      $sWherResposta = "(case when db103_avaliacaotiporesposta in(1,4) then db106_avaliacaoperguntaopcao = ".((int)$pergunta['resposta'])." else db106_resposta = '{$pergunta['resposta']}' end) ";
      $sWherResposta .= " and db104_avaliacaopergunta  = {$pergunta['pergunta']->getCodigo()}"; 
      $aWhere[] = $sWherResposta;
    }
    
    $sSqlRespostas  = $oDaoAvaliacaoResposta->sql_query_avaliacao(null,
      "distinct db107_sequencial, db107_usuario, db107_datalancamento, db107_hora",
      null,
      implode(" and ", $aWhere)
    );       
    $rsRespostas = db_query($sSqlRespostas);
    if (!$rsRespostas) {
      throw new \BusinessException("Erro ao pesquisar as respostas do formulário {$formulario->getNome()}.");
    }
    $respostas = \db_utils::makeCollectionFromRecord($rsRespostas, function($dados) use ($formulario) {      
      return Resposta::make($dados, $formulario);
        
    });
    return $respostas;
    
  }

  /**
   * Persiste os dados da Resposta
   * @param \ECidade\Configuracao\Formulario\Resposta\Model\Resposta $resposta
   * @throws \Exception
   */
  public static function persist(RespostaModel $resposta) {
    
    if ($resposta->getCodigo() == '') {

      $oDaoAvaliacaoGrupoResposta = new \cl_avaliacaogruporesposta;
      $oDaoAvaliacaoGrupoResposta->db107_datalancamento = $resposta->getData()->getDate();
      $oDaoAvaliacaoGrupoResposta->db107_hora = db_hora();
      $oDaoAvaliacaoGrupoResposta->db107_usuario = db_getsession("DB_id_usuario"); //todo retirar o usuario fixo.;

      $oDaoAvaliacaoGrupoResposta->incluir(null);
      if ($oDaoAvaliacaoGrupoResposta->erro_status == 0) {
        throw new \Exception("Erro ao salvar os dados da Resposta para o formulário {$resposta->getFormulario()->getNome()}");
      }
      $resposta->setCodigo($oDaoAvaliacaoGrupoResposta->db107_sequencial);
    }
    
    foreach ( $resposta->getRespostas() as $valorResposta) {
      
      $iCodigoResposta = $valorResposta->getCodigo();
      $oDaoAvaliacaoResposta = new \cl_avaliacaoresposta();
      $oDaoAvaliacaoResposta->db106_avaliacaoperguntaopcao = $valorResposta->getOpcao()->getCodigo();
      $oDaoAvaliacaoResposta->db106_resposta               = $valorResposta->getValor();
      
      if (empty($iCodigoResposta)) {
      
        $oDaoAvaliacaoResposta->incluir(null);
        if ($oDaoAvaliacaoResposta->erro_status == 0) {
          throw new \Exception("Erro ao salvar os dados da Resposta para a pergunta {$valorResposta->getPergunta()->getDescricao()}");
        }
        
        $valorResposta->setCodigo($oDaoAvaliacaoResposta->db106_sequencial);
        $oDaoAvaliacaoGrupoPerguntaResposta = new \cl_avaliacaogrupoperguntaresposta();
        $oDaoAvaliacaoGrupoPerguntaResposta->db108_avaliacaogruporesposta = $resposta->getCodigo();
        $oDaoAvaliacaoGrupoPerguntaResposta->db108_avaliacaoresposta = $oDaoAvaliacaoResposta->db106_sequencial;        
        $oDaoAvaliacaoGrupoPerguntaResposta->incluir(null);
        
        if ($oDaoAvaliacaoGrupoPerguntaResposta->erro_status == 0) {
          throw new \Exception("Erro ao salvar os dados da Resposta para a pergunta {$valorResposta->getPergunta()->getDescricao()}");
        }
      } else {
        
        $oDaoAvaliacaoResposta->db106_sequencial = $valorResposta->getCodigo(); 
        $oDaoAvaliacaoResposta->alterar($valorResposta->getCodigo());
        if ($oDaoAvaliacaoResposta->erro_status == 0) {
          throw new \Exception("Erro ao salvar os dados da Resposta para a pergunta {$valorResposta->getPergunta()->getDescricao()}");
        }
      }
    }
  }

  /**
   * Constroi a instancia da resposta
   * @param                                                   $dados
   * @param \ECidade\Configuracao\Formulario\Model\Formulario $formulario
   * @return \ECidade\Configuracao\Formulario\Resposta\Model\Resposta
   */
  public static function make($dados, Formulario $formulario) {
    
    $resposta = new RespostaModel();
    $resposta->setCodigo($dados->db107_sequencial);
    $resposta->setData(new \DBDate($dados->db107_datalancamento));
    $resposta->setFormulario($formulario);
    return $resposta;
  }

  /**
   * Retorna todas as valores respondidos da resposta
   * @param \ECidade\Configuracao\Formulario\Resposta\Model\Resposta $resposta
   * @return \ECidade\Configuracao\Formulario\Resposta\Model\Valor[]
   * @throws \BusinessException
   */  
  public static function getRespostasDaResposta(RespostaModel $resposta) {
    
    if ($resposta->getCodigo() == '') {
      return array();
    }
    $oDaoAvaliacaoResposta = new \cl_avaliacaogrupoperguntaresposta;
    $where                 = "db107_sequencial = {$resposta->getCodigo()}";
    
    $sSqlRespostas = $oDaoAvaliacaoResposta->sql_query_avaliacao(null,"avaliacaoresposta.*, avaliacaoperguntaopcao.*", "db102_sequencial,db103_ordem", $where);    
    $rsRespostas   = db_query($sSqlRespostas);
    if (!$rsRespostas) {
      throw new \BusinessException("Erro ao pesquisar valor das respostas.");
    }
    $respostas = \db_utils::makeCollectionFromRecord($rsRespostas, function($dados) {
        
       $valorResposta = new Valor();
       $valorResposta->setCodigo($dados->db106_sequencial);
       $valorResposta->setPergunta(Pergunta::getBydId($dados->db104_avaliacaopergunta));
       $valorResposta->setValor($dados->db106_resposta);
       
       $opcao = new Opcao();
       $opcao->setCodigo($dados->db104_sequencial);
       $opcao->setDescricao($dados->db104_descricao);
       $valorResposta->setOpcao($opcao);
       return $valorResposta;
    });
    return $respostas;
  }

  public static function getBydId(Formulario $formulario, $codigoResposta) {

    if (empty($codigoResposta)) {
      return array();
    }
    $oDaoAvaliacaoResposta = new \cl_avaliacaogruporesposta();
    $where                 = "db107_sequencial = {$codigoResposta}";

    $sSqlRespostas = $oDaoAvaliacaoResposta->sql_query_file(null,"*", "", $where);
    $rsRespostas   = db_query($sSqlRespostas);
    if (!$rsRespostas) {
      throw new \BusinessException("Erro ao pesquisar respostas de avaliacao.");
    }
    if (pg_num_rows($rsRespostas) == 0) {
      throw new \BusinessException("Não foi encontrado resposta para o código ($codigoResposta).");
    }
    return self::make(\db_utils::fieldsMemory($rsRespostas, 0), $formulario);
    
    
  }

  /**
   * @param \ECidade\Configuracao\Formulario\Resposta\Model\Resposta $resposta
   * @throws \BusinessException
   * @throws \DBException
   * @throws \ParameterException
   */
  public static function remover(\ECidade\Configuracao\Formulario\Resposta\Model\Resposta $resposta) {
    
    if (!\db_utils::inTransaction()) {
      throw new \DBException('Sem transação com o banco de dados.'); 
    }
    if (empty($resposta)) {
      throw new \ParameterException("Resposta não informada.");
    }
    $oDaoAvaliacaoResposta              = new \cl_avaliacaoresposta();
    $oDaoAvaliacaoGrupoPerguntaResposta = new \cl_avaliacaogrupoperguntaresposta();
    $oDaoAvaliacaoGrupoResposta         = new \cl_avaliacaogruporesposta();
    foreach ($resposta->getRespostas() as $valorResposta) {
      
      $oDaoAvaliacaoGrupoPerguntaResposta->excluir(null, "db108_avaliacaoresposta = {$valorResposta->getCodigo()}");
      if ($oDaoAvaliacaoGrupoPerguntaResposta->erro_status == 0) {
        throw new \BusinessException("Erro ao excluir vinculo das respostas com o formulário.");
      }

      $oDaoAvaliacaoResposta->excluir($valorResposta->getCodigo());
      if ($oDaoAvaliacaoResposta->erro_status == 0) {
        throw new \BusinessException("Erro ao excluir respostas do formulário.");
      }
    }
    $oDaoAvaliacaoGrupoResposta->excluir($resposta->getCodigo());
    if ($oDaoAvaliacaoResposta->erro_status == 0) {
      throw new \BusinessException("Erro ao excluir respostas do formulário. Alguns valores de resposta não foram excluídos.");
    }
  }
}