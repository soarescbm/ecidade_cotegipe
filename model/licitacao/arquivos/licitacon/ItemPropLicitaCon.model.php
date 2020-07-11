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

use \ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao\Proposta as Regra;

/**
 * Class ItemPropLicitaCon
 */
class ItemPropLicitaCon extends ArquivoLicitaCon {

  const CODIGO_LAYOUT = 244;
  const NOME_ARQUIVO  = "ITEM_PROP";
  const TP_OBJETO_OBRAS_SERVICO_ENGENHARIA = "OSE";

  /**
   * @var stdClass[]
   */
  private $aPropostasDesclassificadas = array();

  /**
   * @var stdClass[]
   */
  private $aItensDesclassificados = array();

  /**
   * @var stdClass[]
   */
  private $aLotesDesclassificados = array();

  public function __construct(CabecalhoLicitaCon $oCabecalho) {

    parent::__construct($oCabecalho);
    $this->sNomeArquivo  = self::NOME_ARQUIVO;
    $this->iCodigoLayout = self::CODIGO_LAYOUT;
  }

  /**
   * @return array
   */
  public function getDados() {

    $aSituacoes = array(
      SituacaoLicitacao::SITUACAO_JULGADA,
      SituacaoLicitacao::SITUACAO_ADJUDICADA,
      SituacaoLicitacao::SITUACAO_HOMOLOGADA
    );

    $oDaoLicitacao = new cl_liclicita;

    $sTipos        = implode(',', array(
      licitacao::TIPO_JULGAMENTO_POR_ITEM,
      licitacao::TIPO_JULGAMENTO_GLOBAL,
    ));
    $aCampos = array(
      "l20_codigo",
      "z01_numcgm",
      "l20_numero as nr_licitacao",
      "l20_anousu as ano_licitacao",
      "l44_sigla as cd_tipo_modalidade",
      "case 
        when l44_sigla in ('CPC', 'MAI', 'RPO', 'PRD', 'PRI') or l20_tipojulg <> ".licitacao::TIPO_JULGAMENTO_POR_ITEM." then null
        when pc32_orcamitem is not null then 'D'
        when pc23_vlrun is null or pc23_vlrun = 0 then 'D'
        else 'C'
      end as tp_resultado_proposta",
      "l16_cadattdinamicovalorgrupo",
      "coalesce(pc23_bdi, 0) as pc23_bdi",
      "coalesce(pc23_encargossociais, 0) as pc23_encargossociais",
      "l21_ordem as nr_item",
      "case
        when l20_tipojulg = ".licitacao::TIPO_JULGAMENTO_POR_ITEM." and l44_sigla in ('MDE') then pc23_percentualdesconto
        else null
      end as pc_desconto",
      "coalesce(pc23_vlrun * pc23_quant, 0) as vl_total_item",
      "coalesce(pc23_vlrun, 0) as VL_UNITARIO",
      "case 
        when l44_sigla in ('MCA','MOQ','MOT','MPP','MTC','MTO','MTT','TPR') and l20_tipojulg = ".licitacao::TIPO_JULGAMENTO_POR_ITEM." then pc23_notatecnica
        else null
      end as vl_nota_tecnica
      ",
      "min(coalesce(case when l20_tipojulg in ({$sTipos}) then 1 else l04_codigo end, 1)) as NR_LOTE",
      "l04_descricao as lote",
      "case
        when l20_tipojulg = ".licitacao::TIPO_JULGAMENTO_POR_ITEM." and l44_sigla = 'CPC' then to_char( max(l11_data),'DD/MM/YYYY')
      end as dt_homologacao",
      "l20_tipojulg as tp_nivel_julgamento, pc21_orcamforne, pc22_orcamitem"
    );

    $aWhere   = LicitacaoLicitaCon::getWhereLicitacao($this->oCabecalho->getInstituicao(), $this->oCabecalho->getDataGeracao());
    $aWhere[] = "l20_licsituacao in (" . implode(", ", $aSituacoes) ." ) ";
    $aWhere[] = "l44_sigla not in ('RPO','PRD','PRI')";
    $aWhere[] = "l17_situacao = 1";

    $sWhereProposta = implode(' and ', $aWhere);
    $sGroupBy  = 'l20_codigo, l21_codliclicita, l21_codigo, l44_sequencial, z01_numcgm, pc24_pontuacao, pc22_orcamitem, pc23_orcamitem, pc21_orcamforne, pc23_orcamforne, l04_descricao, pc32_orcamitem, l16_cadattdinamicovalorgrupo, l21_ordem';
    $sSqlLotes = $oDaoLicitacao->sql_query_propostas(implode(', ', $aCampos), $sWhereProposta, $sGroupBy . ' order by l20_codigo, l21_codigo');

    $rsLotes   = db_query($sSqlLotes);
    if (!$rsLotes) {
      $sMsgErro = "Não foi possível buscar informações para o arquivo {$this->sNomeArquivo} no LicitaCon.";
      throw new DBException($sMsgErro);
    }

    $this->processarDesclassificacaoPorTipoDeJulgamento($rsLotes);

    $aLicitacoes = array();
    $iTotalLotes = pg_num_rows($rsLotes);
    for ($iLinha = 0; $iLinha < $iTotalLotes; $iLinha++) {

      $oLinha = db_utils::fieldsMemory($rsLotes, $iLinha);

      if (in_array($oLinha->cd_tipo_modalidade, array('CNS', 'PRE', 'PRP', 'LEI')) &&
        !LicitanteLicitaCon::fornecedorGanhouItens($oLinha->pc21_orcamforne)) {
        continue;
      }

      if (!empty($oLinha->vl_nota_tecnica)) {
        $oLinha->vl_nota_tecnica = number_format($oLinha->vl_nota_tecnica, 2, ',', '');
      }

      if(empty($oLinha->vl_total_item) && empty($oLinha->vl_unitario)) {
        continue;
      }

      $oRegra = new Regra($this->oCabecalho->getDataGeracao());
      $oRegra->setLicitacao(LicitacaoRepository::getByCodigo($oLinha->l20_codigo));
      $oRegra->setFornecedor(new \OrcamentoFornecedor($oLinha->pc21_orcamforne));
      $oRegra->setItem(new \ItemOrcamento($oLinha->pc22_orcamitem));
      $sResultadoProposta = $oRegra->getResultadoLicitacaoPorItem();

      $oStdItem = new stdClass;
      $oStdItem->NR_LICITACAO           = $oLinha->nr_licitacao;
      $oStdItem->ANO_LICITACAO          = $oLinha->ano_licitacao;
      $oStdItem->CD_TIPO_MODALIDADE     = $oLinha->cd_tipo_modalidade;
      $oStdItem->TP_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getTipoDocumentoPorCGM($oLinha->z01_numcgm);
      $oStdItem->NR_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getDocumentoPorCGM($oLinha->z01_numcgm);
      $oStdItem->NR_LOTE                = $oLinha->nr_lote;
      $oStdItem->NR_ITEM                = $oLinha->nr_item;
      $oStdItem->PC_DESCONTO            = empty($oLinha->pc_desconto) ? "" : number_format($oLinha->pc_desconto, 2, ',', '');
      $oStdItem->VL_TOTAL_ITEM          = empty($oLinha->vl_total_item) ? "0,00" : number_format($oLinha->vl_total_item, 2, ',', '');
      $oStdItem->VL_UNITARIO            = empty($oLinha->vl_unitario) ? "0,000" : number_format($oLinha->vl_unitario, 3, ',', '');
      $oStdItem->VL_NOTA_TECNICA        = $oLinha->vl_nota_tecnica;
      $oStdItem->TP_RESULTADO_PROPOSTA  = $sResultadoProposta;
      $oStdItem->DT_HOMOLOGACAO         = $oLinha->dt_homologacao;
      $oStdItem->TP_NIVEL_JULGAMENTO    = $oLinha->tp_nivel_julgamento;
      $oStdItem->lote                   = $oLinha->lote;
      $oStdItem->PC_BDI                 = null;
      $oStdItem->PC_ENCARGOS_SOCIAIS    = null;
      $oStdItem->pc21_orcamforne        = $oLinha->pc21_orcamforne;

      $oAtributosDinamicos = $this->getAtributosDinamicos($oLinha->l16_cadattdinamicovalorgrupo);
      if($oAtributosDinamicos->sTipoObjeto == self::TP_OBJETO_OBRAS_SERVICO_ENGENHARIA){

        $oStdItem->PC_BDI                 = empty($oLinha->pc23_bdi) ? null : number_format($oLinha->pc23_bdi, 2, ',', '');
        $oStdItem->PC_ENCARGOS_SOCIAIS    = empty($oLinha->pc23_encargossociais) ? null : number_format($oLinha->pc23_encargossociais, 2, ',', '');
      }

      if($oStdItem->TP_NIVEL_JULGAMENTO == licitacao::TIPO_JULGAMENTO_POR_LOTE || $oStdItem->TP_NIVEL_JULGAMENTO == licitacao::TIPO_JULGAMENTO_GLOBAL){

        if(!empty($aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$oLinha->lote][0])){

          $oAux = $aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$oLinha->lote][0];

          foreach($aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$oLinha->lote] as $oItem){

            if($oStdItem->NR_LOTE < $oItem->NR_LOTE){
              $oItem->NR_LOTE = $oStdItem->NR_LOTE;
            }else {
              $oStdItem->NR_LOTE = $oItem->NR_LOTE;
            }

            if($oStdItem->TP_RESULTADO_PROPOSTA == 'D' || $oAux->TP_RESULTADO_PROPOSTA == 'D'){
              $oItem->TP_RESULTADO_PROPOSTA = $oStdItem->TP_RESULTADO_PROPOSTA = 'D';
            }
          }

        }
      }
      $aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$oLinha->lote][] = $oStdItem;
    }

    $aItens = array();
    foreach ($aLicitacoes as $iCodigoLicitacao => $aLicitante){

      foreach ($aLicitante as $aLote) {

        foreach ($aLote as $sDescricaoLote => $aItem) {

          $sHashLote = "{$iCodigoLicitacao}#{$sDescricaoLote}";
          if (array_key_exists($sHashLote, $this->aLotesDesclassificados)) {
            continue;
          }

          foreach ($aItem as $oItem) {

            if (in_array($oItem->pc21_orcamforne, $this->aPropostasDesclassificadas)) {
              continue;
            }

            $sHashItem = "{$iCodigoLicitacao}#{$oItem->NR_ITEM}#{$oItem->pc21_orcamforne}";
            if (array_key_exists($sHashItem, $this->aItensDesclassificados)) {
              continue;
            }
            $aItens[] = $oItem;
          }
        }
      }
    }

    return $aItens;
  }

  /**
   * @param resource $rsBuscaPropostas
   * @return true
   */
  private function processarDesclassificacaoPorTipoDeJulgamento($rsBuscaPropostas) {

    $aPropostasLicitacao = array();
    $iTotalRegistros = pg_num_rows($rsBuscaPropostas);
    for ($iRow = 0; $iRow < $iTotalRegistros; $iRow++) {

      $oStdProposta = db_utils::fieldsMemory($rsBuscaPropostas, $iRow);

      if (empty($aPropostasLicitacao[$oStdProposta->l20_codigo])) {

        $aPropostasLicitacao[$oStdProposta->l20_codigo] = new stdClass();
        $aPropostasLicitacao[$oStdProposta->l20_codigo]->tipo_julgamento = $oStdProposta->tp_nivel_julgamento;
        $aPropostasLicitacao[$oStdProposta->l20_codigo]->itens           = array();
      }

      if ($oStdProposta->tp_nivel_julgamento == licitacao::TIPO_JULGAMENTO_POR_LOTE) {

        if (empty($aPropostasLicitacao[$oStdProposta->l20_codigo]->lotes)) {
          $aPropostasLicitacao[$oStdProposta->l20_codigo]->lotes = array();
        }
        $sHashLote = "{$oStdProposta->l20_codigo}#{$oStdProposta->lote}";
        $aPropostasLicitacao[$oStdProposta->l20_codigo]->lotes[$sHashLote][] = $oStdProposta;
      } else {
        $aPropostasLicitacao[$oStdProposta->l20_codigo]->itens[] = $oStdProposta;
      }
    }

    /**
     * Verifica os itens por tipo de julgamento
     */
    foreach ($aPropostasLicitacao as $iCodigoLicitacao => $oStdLicitacao) {

      switch ($oStdLicitacao->tipo_julgamento) {

        case licitacao::TIPO_JULGAMENTO_GLOBAL:

          $aItensAgrupadosPorFornecedor = array();
          foreach ($oStdLicitacao->itens as $oStdItem) {

            $sHash = "{$iCodigoLicitacao}#{$oStdItem->pc21_orcamforne}";
            $aItensAgrupadosPorFornecedor[$sHash][$oStdItem->nr_item] = $oStdItem;
          }

          foreach ($aItensAgrupadosPorFornecedor as $sHash => $aItens) {

            $lPrecisaExcluir = false;
            foreach ($aItens as $iOrdemItem => $oStdItem) {

              if (empty($oStdItem->vl_unitario)) {
                $lPrecisaExcluir = true;
              }
            }

            if ($lPrecisaExcluir) {

              $aHash = explode('#', $sHash);
              $this->aPropostasDesclassificadas[$aHash[1]] = $aHash[1];
            }
          }
          break;

        case licitacao::TIPO_JULGAMENTO_POR_ITEM:

          foreach ($oStdLicitacao->itens as $oStdItem) {

            if (empty($oStdItem->vl_unitario)) {

              $sHashExclusao = "{$iCodigoLicitacao}#{$oStdItem->nr_item}#{$oStdItem->pc21_orcamforne}";
              $this->aItensDesclassificados[$sHashExclusao] = $oStdItem;
            }
          }
          break;

        case licitacao::TIPO_JULGAMENTO_POR_LOTE:

          foreach ($oStdLicitacao->lotes as $sDescricaoLote => $oStdItem) {

            if (empty($oStdItem->vl_unitario)){

              $sHashLote = "{$iCodigoLicitacao}#{$sDescricaoLote}";
              $this->aLotesDesclassificados[$sHashLote] = $sHashLote;
            }
          }
          break;

      }
    }
    return true;
  }

  private function getAtributosDinamicos($iAtributoDinamicoValorGrupo) {

    $oStdAtributosDinamicos = new stdClass();
    $oStdAtributosDinamicos->sTipoObjeto    = null;
    $oStdAtributosDinamicos->sTipoOrcamento = null;

    if (empty($iAtributoDinamicoValorGrupo)) {
      return $oStdAtributosDinamicos;
    }

    $aValoresAtributosDinamicos = DBAttDinamicoValor::getValores($iAtributoDinamicoValorGrupo);

    foreach ($aValoresAtributosDinamicos as $oValor) {

      switch ($oValor->getAtributo()->getNome()) {

        case "tipoobjeto":
          $oStdAtributosDinamicos->sTipoObjeto = $oValor->getValor();
          break;
      }
    }

    if ($oStdAtributosDinamicos->sTipoObjeto != self::TP_OBJETO_OBRAS_SERVICO_ENGENHARIA) {
      $oStdAtributosDinamicos->sTipoOrcamento = null;
    }

    return $oStdAtributosDinamicos;
  }

}
