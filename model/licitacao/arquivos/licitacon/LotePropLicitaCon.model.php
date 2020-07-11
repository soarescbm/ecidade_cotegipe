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

use ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao\Proposta as Regra;

/**
 * Class LotePropLicitaCon
 */
class LotePropLicitaCon extends ArquivoLicitaCon {

  const CODIGO_LAYOUT = 242;
  const NOME_ARQUIVO  = "LOTE_PROP";

  public function __construct(CabecalhoLicitaCon $oCabecalho) {

    parent::__construct($oCabecalho);
    $this->sNomeArquivo  = self::NOME_ARQUIVO;
    $this->iCodigoLayout = self::CODIGO_LAYOUT;
  }

  /**
   * @return array
   * @throws DBException
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
      "l20_tipojulg as tipo_julgamento",
      "case 
        when l44_sigla in ('CPC', 'MAI', 'RPO', 'PRD', 'PRI') then null
        when pc32_orcamitem is not null then 'D'
        when pc23_vlrun is null then 'D'
        else 'C'
      end as tp_resultado_proposta",
      "case
        when l20_tipojulg = ".licitacao::TIPO_JULGAMENTO_POR_LOTE." then pc23_percentualdesconto
        else null
      end as pc_desconto",
      "pc23_vlrun * pc23_quant as vl_total_item",
      "case 
        when l44_sigla in ('MCA','MOQ','MOT','MPP','MTC','MTO','MTT','TPR') and l20_tipojulg = ".licitacao::TIPO_JULGAMENTO_POR_LOTE." then pc23_notatecnica
        else null
      end as vl_nota_tecnica
      ",
      "min(coalesce(case when l20_tipojulg in ({$sTipos}) then 1 else l04_codigo end, 1)) as nr_lote",
      "l04_descricao as lote",
      "case
        when l20_tipojulg = ".licitacao::TIPO_JULGAMENTO_POR_LOTE." and l44_sigla = 'CPC' then to_char( max(l11_data),'DD/MM/YYYY')
      end as dt_homologacao, pc23_orcamforne, pc22_orcamitem"
    );

    $aWhere    = LicitacaoLicitaCon::getWhereLicitacao($this->oCabecalho->getInstituicao(), $this->oCabecalho->getDataGeracao());
    $aWhere[]  = "l44_sigla not in ('RPO','PRD','PRI')";
    $aWhere[]  = "l20_licsituacao in (" . implode(", ", $aSituacoes) ." ) ";
    $aWhere[]  = "l17_situacao = 1";

    $sGroupBy  = 'l20_codigo, l21_codliclicita, l44_sequencial, z01_numcgm, pc24_pontuacao, pc23_orcamitem, pc23_orcamforne, pc22_orcamitem, l04_descricao, pc32_orcamitem, l20_tipojulg';
    $sSqlLotes = $oDaoLicitacao->sql_query_propostas(implode(', ', $aCampos), implode(' and ', $aWhere), $sGroupBy);

    $rsLotes   = db_query($sSqlLotes);
    if (!$rsLotes) {
      $sMsgErro = "Não foi possível buscar informações para o arquivo {$this->sNomeArquivo} no LicitaCon.";
      throw new DBException($sMsgErro);
    }

    $aLicitacoes = array();
    $iTotalLotes = pg_num_rows($rsLotes);
    for ($iLinha = 0; $iLinha < $iTotalLotes; $iLinha++) {

      $oLinha = db_utils::fieldsMemory($rsLotes, $iLinha);

      if (in_array($oLinha->cd_tipo_modalidade, array('CNS', 'PRE', 'PRP', 'LEI')) &&
          !LicitanteLicitaCon::fornecedorGanhouItens($oLinha->pc23_orcamforne)) {
        continue;
      }

      if(empty($oLinha->vl_total_item)) {
        continue;
      }


      $sAgrupador      = $oLinha->lote;
//      $sResultado      = $oLinha->tp_resultado_proposta;
      $oRegra = new Regra($this->oCabecalho->getDataGeracao());
      $oRegra->setLicitacao(LicitacaoRepository::getByCodigo($oLinha->l20_codigo));
      $oRegra->setFornecedor( new \OrcamentoFornecedor($oLinha->pc23_orcamforne));
      $oRegra->setItem(new \ItemOrcamento($oLinha->pc22_orcamitem));
      $sResultado = $oRegra->getResultadoLicitacaoPorLote();

      $lJulgamentoLote = true;
      if ($oLinha->tipo_julgamento != licitacao::TIPO_JULGAMENTO_POR_LOTE) {

        $sAgrupador      = "1";
        $lJulgamentoLote = false;
      }

      if( !isset($aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$sAgrupador]) ){

        $oStdLote = new stdClass;
        $oStdLote->NR_LICITACAO           = $oLinha->nr_licitacao;
        $oStdLote->ANO_LICITACAO          = $oLinha->ano_licitacao;
        $oStdLote->CD_TIPO_MODALIDADE     = $oLinha->cd_tipo_modalidade;
        $oStdLote->TP_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getTipoDocumentoPorCGM($oLinha->z01_numcgm);
        $oStdLote->NR_DOCUMENTO_LICITANTE = LicitanteLicitaCon::getDocumentoPorCGM($oLinha->z01_numcgm);
        $oStdLote->NR_LOTE                = $oLinha->nr_lote;
        $oStdLote->PC_DESCONTO            = null;
        $oStdLote->VL_TOTAL_LOTE          = $oLinha->vl_total_item != null ? $oLinha->vl_total_item : 0;
        $oStdLote->VL_NOTA_TECNICA        = null;
        $oStdLote->TP_RESULTADO_PROPOSTA  = $sResultado;
        $oStdLote->DT_HOMOLOGACAO         = $oLinha->dt_homologacao;

        if ($lJulgamentoLote && (Check::isFloat($oLinha->vl_nota_tecnica) || Check::isInt($oLinha->vl_nota_tecnica))) {
          $oStdLote->VL_NOTA_TECNICA = $oLinha->vl_nota_tecnica;
        }

        $aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$sAgrupador] = $oStdLote;

      } else {

        $oLote = $aLicitacoes[$oLinha->l20_codigo][$oLinha->z01_numcgm][$sAgrupador];
        if($oLinha->nr_lote < $oLote->NR_LOTE){

          $oLote->NR_LOTE = $oLinha->nr_lote;
        }

        if($oLinha->tp_resultado_proposta == 'D'){

          $oLote->TP_RESULTADO_PROPOSTA = 'D';
        }
        if ($lJulgamentoLote && (Check::isFloat($oLinha->vl_nota_tecnica) || Check::isInt($oLinha->vl_nota_tecnica))) {
          $oLote->VL_NOTA_TECNICA += $oLinha->vl_nota_tecnica;
        }
        $oLote->VL_TOTAL_LOTE += $oLinha->vl_total_item;
      }
    }

    $aLotes = array();
    foreach ($aLicitacoes as $aLicitante){

      foreach ($aLicitante as $aLote) {

        foreach ($aLote as $oLote) {

          if (empty($oLote->VL_TOTAL_LOTE)) {
            continue;
          }
          $oLote->VL_TOTAL_LOTE   = number_format($oLote->VL_TOTAL_LOTE, 2, ",", "");
          $oLote->VL_NOTA_TECNICA = is_null($oLote->VL_NOTA_TECNICA) ? null : number_format($oLote->VL_NOTA_TECNICA, 2, ',', '');
          $aLotes[] = $oLote;
        }
      }
    }

    return $aLotes;

  }
}
