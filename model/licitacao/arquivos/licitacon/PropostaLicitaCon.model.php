<?php
/**
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

use \ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao\Proposta;

/**
 * Class PropostaLicitaCon
 */
class PropostaLicitaCon extends ArquivoLicitaCon {

  const CODIGO_LAYOUT = 243;
  const NOME_ARQUIVO  = "PROPOSTA";

  private $aDadosProposta = array();

  public function __construct(CabecalhoLicitaCon $oCabecalho) {

    parent::__construct($oCabecalho);
    $this->sNomeArquivo  = self::NOME_ARQUIVO;
    $this->iCodigoLayout = self::CODIGO_LAYOUT;
  }

  /**
   * @return array
   * @throws Exception
   */
  public function getDados() {

    if (count($this->aDadosProposta) == 0) {
      $this->preparaPropostas();
    }
    return $this->aDadosProposta;
  }

  /**
   * @throws Exception
   */
  private function preparaPropostas() {

    $aSituacoes = array(
      SituacaoLicitacao::SITUACAO_JULGADA,
      SituacaoLicitacao::SITUACAO_ADJUDICADA,
      SituacaoLicitacao::SITUACAO_HOMOLOGADA
    );

    $aWhere = LicitacaoLicitaCon::getWhereLicitacao($this->oCabecalho->getInstituicao(), $this->oCabecalho->getDataGeracao());
    $aWhere[] = "l20_licsituacao in (" . implode(", ", $aSituacoes).")";
    $aWhere[] = "l44_sigla not in ('RPO','PRD','PRI')";
    $aWhere[] = "pcorcamfornelichabilitacao.l17_situacao = 1";

    $aCampos = array(
      "pc23_orcamforne as codigo_fornecedor",
      "l20_codigo as codigo_licitacao",
      "l20_numero as numero_licitacao",
      "l20_anousu as ano_licitacao",
      "l44_sigla as sigla_modalidade",
      "z01_cgccpf as documento_fornecedor",
      "z01_numcgm",
      "l20_dataaber as data_proposta",
      "sum(pc23_valor) as valor_total",
      "l20_tipojulg as tipo_julgamento",
      "sum(coalesce(pc23_notatecnica, 0)) as nota_tecnica"
    );

    $sOrder = " order by sigla_modalidade, numero_licitacao,  documento_fornecedor ";
    $sGroup = " group by pc23_orcamforne, z01_numcgm, l20_codigo, l20_numero, l20_anousu, l44_sigla, z01_cgccpf, l20_dataaber, l20_tipojulg";
    $sWhere  = implode(' and ', $aWhere);
    $sWhere .= " {$sGroup} {$sOrder} ";

    $oDaoOrcamento    = new cl_pcorcamval();
    $sSqlOrcamento    = $oDaoOrcamento->sql_query_proposta_licitacao(implode(',', $aCampos), $sWhere);
    $rsBuscaOrcamento = db_query($sSqlOrcamento);

    if (!$rsBuscaOrcamento) {
      throw new Exception('Não foi possível carregar as propostas para criação do arquivo PROPOSTAS.TXT.');
    }

    $iNumeroLinhas = pg_num_rows($rsBuscaOrcamento);
    $aFornecedorIgnorar = array();
    for ($iRowProposta = 0; $iRowProposta < $iNumeroLinhas; $iRowProposta++) {

      $oStdDadosProposta = db_utils::fieldsMemory($rsBuscaOrcamento, $iRowProposta);
      $sTipoDocumento    = LicitanteLicitaCon::getTipoDocumentoPorCGM($oStdDadosProposta->z01_numcgm);
      $lJulgamentoGlobal = $oStdDadosProposta->tipo_julgamento == licitacao::TIPO_JULGAMENTO_GLOBAL;

      /*
       * Validação que verifica somente as propostas vencedoras nas modalidades colocadas no array
       */
      if (in_array($oStdDadosProposta->sigla_modalidade, array('CNS', 'PRE', 'PRP', 'LEI')) &&
          !LicitanteLicitaCon::fornecedorGanhouItens($oStdDadosProposta->codigo_fornecedor)) {
        continue;
      }

      if(empty($oStdDadosProposta->valor_total)) {
        continue;
      }

      $sDataProposta = '';
      if (!empty($oStdDadosProposta->data_proposta)) {

        $oDataProposta = new DBDate($oStdDadosProposta->data_proposta);
        $sDataProposta = $oDataProposta->getDate(DBDate::DATA_PTBR);
      }

      $oProposta = new Proposta($this->oCabecalho->getDataGeracao());
      $oProposta->setLicitacao(LicitacaoRepository::getByCodigo($oStdDadosProposta->codigo_licitacao));
      $oProposta->setFornecedor(new OrcamentoFornecedor($oStdDadosProposta->codigo_fornecedor));
      $sTipoResultado = $oProposta->getResultadoLicitacaoGlobal();


      $nValorNotaTecnica = null;
      if (!is_null($oStdDadosProposta->nota_tecnica)) {
        $nValorNotaTecnica = number_format($oStdDadosProposta->nota_tecnica, 2, ',', '');
      }

      $oStdRetornoPropostas = new stdClass();
      $oStdRetornoPropostas->NR_LICITACAO           = $oStdDadosProposta->numero_licitacao;
      $oStdRetornoPropostas->ANO_LICITACAO          = $oStdDadosProposta->ano_licitacao;
      $oStdRetornoPropostas->CD_TIPO_MODALIDADE     = $oStdDadosProposta->sigla_modalidade;
      $oStdRetornoPropostas->TP_DOCUMENTO_LICITANTE = $sTipoDocumento;
      $oStdRetornoPropostas->NR_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getDocumentoPorCGM($oStdDadosProposta->z01_numcgm);
      $oStdRetornoPropostas->DT_PROPOSTA            = $sDataProposta;
      $oStdRetornoPropostas->TP_RESULTADO_PROPOSTA  = $sTipoResultado;
      $oStdRetornoPropostas->VL_TOTAL_PROPOSTA      = str_replace('.', '', db_formatar($oStdDadosProposta->valor_total, 'f'));
      $oStdRetornoPropostas->VL_NOTA_TECNICA        = $nValorNotaTecnica;
      $oStdRetornoPropostas->DT_HOMOLOGACAO         = null;

      if (in_array($oStdDadosProposta->sigla_modalidade, array('CPC'))) {
        $oStdRetornoPropostas->DT_HOMOLOGACAO = $this->getDataHomologacao($oStdDadosProposta->codigo_licitacao);
      }

      //Colunas que vão sempre vazios.
      $oStdRetornoPropostas->PC_DESCONTO = null;

      if (!$lJulgamentoGlobal) {
        $oStdRetornoPropostas->VL_TOTAL_PROPOSTA = null;
      }

      if (!$this->mostrarNotaTecnica($lJulgamentoGlobal, $oStdDadosProposta->codigo_licitacao)) {
        $oStdRetornoPropostas->VL_NOTA_TECNICA  = null;
      }

      $this->aDadosProposta[] = $oStdRetornoPropostas;

      /**
       * @todo refatorar
       * busca os fornecedores que não lançaram valores em nenhum dos itens
       */
      $sSqlBuscaFornecedorSemValorLancado = "
        select distinct pcorcamforne.* 
          from liclicita 
               inner join liclicitem on l20_codigo = l21_codliclicita 
               inner join pcorcamitemlic on pc26_liclicitem = l21_codigo 
               inner join pcorcamitem on pc22_orcamitem = pc26_orcamitem 
               inner join pcorcamforne on pc22_codorc = pc21_codorc 
               inner join pcorcamfornelic      on pc31_orcamforne = pc21_orcamforne
               inner join pcorcamfornelichabilitacao on l17_pcorcamfornelic = pc31_orcamforne 
               left join pcorcamval on pc23_orcamforne = pc21_orcamforne 
         where l20_codigo = {$oStdDadosProposta->codigo_licitacao} and pc23_orcamforne is null and l17_situacao = 1;
      ";
      $rsBuscaFornecedorSemValor = db_query($sSqlBuscaFornecedorSemValorLancado);
      if (!$rsBuscaFornecedorSemValor) {
        throw new Exception("Ocorreu um erro ao buscar os fornecedores sem valor lançado na proposta.");
      }
      $iTotalFornecedor = pg_num_rows($rsBuscaFornecedorSemValor);
      if ($iTotalFornecedor > 0) {

        for ($iRowFornecedor = 0; $iRowFornecedor < $iTotalFornecedor; $iRowFornecedor++) {

          $oStdDadosFornecedor = db_utils::fieldsMemory($rsBuscaFornecedorSemValor, $iRowFornecedor);

          if (!empty($aFornecedorIgnorar[$oStdDadosFornecedor->pc21_orcamforne])) {
            continue;
          }

          if ( in_array($oStdDadosProposta->sigla_modalidade, array('CNS', 'PRE', 'PRP', 'LEI') ) ) {
            continue;
          }

          $oStdRetornoPropostas = new stdClass();
          $oStdRetornoPropostas->NR_LICITACAO           = $oStdDadosProposta->numero_licitacao;
          $oStdRetornoPropostas->ANO_LICITACAO          = $oStdDadosProposta->ano_licitacao;
          $oStdRetornoPropostas->CD_TIPO_MODALIDADE     = $oStdDadosProposta->sigla_modalidade;
          $oStdRetornoPropostas->TP_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getTipoDocumentoPorCGM($oStdDadosFornecedor->pc21_numcgm);;
          $oStdRetornoPropostas->NR_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getDocumentoPorCGM($oStdDadosFornecedor->pc21_numcgm);
          $oStdRetornoPropostas->DT_PROPOSTA            = $sDataProposta;
          $oStdRetornoPropostas->TP_RESULTADO_PROPOSTA  = Proposta::RESULTADO_DESCLASSIFICADO;
          $oStdRetornoPropostas->VL_TOTAL_PROPOSTA      = "0,00";
          $oStdRetornoPropostas->VL_NOTA_TECNICA        = null;
          $oStdRetornoPropostas->DT_HOMOLOGACAO         = null;
          $oStdRetornoPropostas->PC_DESCONTO = null;
          $this->aDadosProposta[] = $oStdRetornoPropostas;
          $aFornecedorIgnorar[$oStdDadosFornecedor->pc21_orcamforne] = $oStdDadosFornecedor->pc21_orcamforne;
        }
      }

      unset($oStdPropostas, $oStdDadosProposta);
    }
  }

  /**
   * Verifica se deve mostrar o valor da nota técnica.
   * @param boolean $lJulgamentoGlobal Se o tipo de julgamento é global.
   * @param int     $iCodigoLicitacao  Código da licitação.
   *
   * @return bool
   */
  private static function mostrarNotaTecnica($lJulgamentoGlobal, $iCodigoLicitacao) {

    if (!$lJulgamentoGlobal) {
      return false;
    }

    $oLicitacaoDinamico = new LicitacaoAtributosDinamicos();
    $oLicitacaoDinamico->setCodigoLicitacao($iCodigoLicitacao);
    $sValorAtributo  = $oLicitacaoDinamico->getAtributo('tipolicitacao');
    $aTiposLicitacao = array('MCA', 'MOQ', 'MOT', 'MPP', 'MTC', 'MTO', 'MTT', 'TPR');
    return in_array($sValorAtributo, $aTiposLicitacao);
  }

  /**
   * Busca a data de homologação, quando está é necessária.
   * @param int     $iLicitacao        Código da licitação.
   *
   * @return null|string
   * @throws DBException
   */
  private function getDataHomologacao($iLicitacao) {

    $sDataHomologacao  = null;

    $sCampos = " l11_data ";
    $sWhere = " l11_liclicita = {$iLicitacao} and l11_licsituacao = " . SituacaoLicitacao::SITUACAO_HOMOLOGADA . " ";

    $oDaoLicitacaoSituacao = new cl_liclicitasituacao();
    $sSqlLicitacaoSituacao = $oDaoLicitacaoSituacao->sql_query_file(null, $sCampos, null, $sWhere);
    $rsLicitacaoSituacao   = db_query($sSqlLicitacaoSituacao);

    if (!$rsLicitacaoSituacao) {
      throw new DBException("Houve um erro ao buscar a data de homologação da licitação.");
    }

    if (pg_num_rows($rsLicitacaoSituacao) > 0) {

      $oDataHomologacao = new DBDate(db_utils::fieldsMemory($rsLicitacaoSituacao, 0)->l11_data);
      $sDataHomologacao = $oDataHomologacao->getDate(DBDate::DATA_PTBR);
    }
    return $sDataHomologacao;
  }
}
