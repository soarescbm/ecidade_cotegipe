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

use ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao\Alteracao as Regra;

/**
 * Class AlteracaoLicitaCon
 */
class AlteracaoLicitaCon extends ArquivoLicitaCon {

  /**
   * @type string
   */
  const NOME_ARQUIVO  = "ALTERACAO";

  /**
   * @type stdClass[]
   */
  private $aDadosArquivo = array();

  /**
   * AlteracaoLicitaCon constructor.
   * @param CabecalhoLicitaCon $oCabecalho
   */
  public function __construct(CabecalhoLicitaCon $oCabecalho) {

    parent::__construct($oCabecalho, new Regra($oCabecalho->getDataGeracao()));
    $this->sNomeArquivo  = self::NOME_ARQUIVO;
    $this->iCodigoLayout = $this->oRegra->getCodigoLayout();
  }

  /**
   * @return array
   */
  public function getDados() {

    if (count($this->aDadosArquivo) == 0) {
      $this->prepararDados();
    }
    return $this->aDadosArquivo;
  }

  /**
   * Busca os dados que serão enviados ao arquivo
   * @throws BusinessException
   * @throws DBException
   */
  private function prepararDados() {

    /**
     * Executa a busca de todos os acordos que tem como origem Licitação
     */
    $aCampos = array(
      "distinct ac16_numero    as numero_acordo",
      "ac16_anousu          as ano_acordo",
      "ac16_tipoinstrumento as tipo_instrumento",
      "ac16_sequencial      as sequencial_acordo",
    );

    $aWhere = array(
      "(ac58_acordo is null or ac58_data >= '{$this->oCabecalho->getDataGeracao()->getDate()}')",
      "ac16_instit = {$this->oCabecalho->getInstituicao()->getCodigo()}",
    );

    $oDaoAcordo       = new cl_acordo();
    $sSqlBuscaAcordos = $oDaoAcordo->sql_query_acordo_licitacao( implode(',', $aCampos), implode(' and ', $aWhere) );
    $rsBuscaAcordos   = db_query($sSqlBuscaAcordos);
    if (!$rsBuscaAcordos) {
      throw new DBException("Ocorreu um erro ao buscar as informações para o arquivo ".self::NOME_ARQUIVO.".TXT.");
    }

    $iTotalAcordos = pg_num_rows($rsBuscaAcordos);
    if ($iTotalAcordos == 0) {
      return;
    }

    /**
     * Percorre os acordos buscando as posições existentes
     */
    for ($iRowAcordo = 0; $iRowAcordo < $iTotalAcordos; $iRowAcordo++) {

      $oStdAcordo = db_utils::fieldsMemory($rsBuscaAcordos, $iRowAcordo);
      $oAcordo    = AcordoRepository::getByCodigo($oStdAcordo->sequencial_acordo);

      $oStdCabecalhoLinha = $this->oRegra->getDadosLicitacao($oStdAcordo->sequencial_acordo, $this->oCabecalho->getDataGeracao());
      $oStdAcordo->numero_licitacao = $oStdCabecalhoLinha->numero;
      $oStdAcordo->ano_licitacao    = $oStdCabecalhoLinha->ano;
      $oStdAcordo->sigla_modalidade = $oStdCabecalhoLinha->tipo;
      $oStdAcordo->tipo_instrumento = $this->oRegra->getTipoInstrumento($oStdAcordo->tipo_instrumento);
      $oStdAcordo->data_inicial     = $oAcordo->getDataInicialVigenciaOriginal();
      $oStdAcordo->data_final       = $oAcordo->getDataFinalVigenciaOriginal();
      $oStdAcordo->posicoes         = array();

      $aCamposPosicao = array(
        "ac26_sequencial        as codigo_posicao",
        "ac55_sequencial        as codigo_evento",
        "ac26_acordoposicaotipo as tipo_aditamento",
        "ac26_tipooperacao      as tipo_operacao",
      );

      $aWhere = array(
        "ac26_acordo = {$oStdAcordo->sequencial_acordo} and ac55_sequencial is not null
         group by ac26_sequencial,
                  ac26_acordoposicaotipo,
                  ac26_tipooperacao,
                  ac55_sequencial
         order by ac26_sequencial"
      );
      $oDaoAcordoPosicao = new cl_acordoposicao();
      $sSqlBuscaPosicao  = $oDaoAcordoPosicao->sql_query_posicoes_licitacon(implode(', ', $aCamposPosicao), implode(' and ', $aWhere));
      $rsBuscaPosicao    = db_query($sSqlBuscaPosicao);
      if (!$rsBuscaPosicao) {
        throw new DBException("Não foi possível buscar eventos existentes para o acordo de código {$oStdAcordo->sequencial_acordo}.");
      }

      $iTotalEventos = pg_num_rows($rsBuscaPosicao);
      for ($iRowEvento = 0; $iRowEvento < $iTotalEventos; $iRowEvento++) {

        $oStdValorPosicaoAnterior = end($oStdAcordo->posicoes);

        // FIX para pegar a posicao de inclusao
        if($iRowEvento == 0){

          $aWhere = array(
            "ac26_acordo = {$oStdAcordo->sequencial_acordo} and ac26_acordoposicaotipo = 1
             group by ac26_sequencial,
                      ac26_acordoposicaotipo,
                      ac26_tipooperacao,
                      ac55_sequencial
             order by ac26_sequencial
             limit 1"

          );
          $sSqlBuscaInclusao  = $oDaoAcordoPosicao->sql_query_posicoes_licitacon(implode(', ', $aCamposPosicao), implode(' and ', $aWhere));
          $rsBuscaInclusao    = db_query($sSqlBuscaInclusao);

          if (!$rsBuscaInclusao) {
            throw new DBException("Não foi possível buscar o evento de inclusão existente para o acordo de código {$oStdAcordo->sequencial_acordo}.");
          }
          $oStdPosicaoInclusao = db_utils::fieldsMemory($rsBuscaInclusao, 0);
          $oAcordoInclusao   = new AcordoPosicao($oStdPosicaoInclusao->codigo_posicao);

          $oStdPosicaoInclusao->valores = $this->oRegra->getValoresAtualizadosAtePosicao($oAcordoInclusao);

          $oStdValorPosicaoAnterior = $oStdPosicaoInclusao;
        }
        $oStdPosicaoAtual = db_utils::fieldsMemory($rsBuscaPosicao, $iRowEvento);
        $oAcordoPosicao   = new AcordoPosicao($oStdPosicaoAtual->codigo_posicao);

				if ($oStdValorPosicaoAnterior === false) {
					$oStdValorPosicaoAnterior = null;
				}
        $oStdPosicaoAtual->valores = new stdClass();
        $oStdPosicaoAtual->valores = $this->oRegra->getValoresAtualizadosAtePosicao($oAcordoPosicao);
				$oValores = $this->oRegra->getValores($oStdPosicaoAtual, $oStdValorPosicaoAnterior);

        $oStdPosicaoAtual->sigla_tipo_aditamento = $this->oRegra->getTipoOperacao($oStdPosicaoAtual->tipo_aditamento, $oStdPosicaoAtual->tipo_operacao);
        $oStdPosicaoAtual->justificativa         = $oAcordoPosicao->getObservacao();
        $oStdPosicaoAtual->valores->dias_novo_prazo      = $this->oRegra->getDiasPrazo($oAcordoPosicao, !empty($oStdValorPosicaoAnterior), $oStdAcordo);
        $oStdPosicaoAtual->valores->valor_acrescimo      = is_null($oValores->valor_acrescimo)      ? $oValores->valor_acrescimo      : Regra::formatarValor($oValores->valor_acrescimo);
        $oStdPosicaoAtual->valores->percentual_acrescimo = is_null($oValores->percentual_acrescimo) ? $oValores->percentual_acrescimo : Regra::formatarValor($oValores->percentual_acrescimo);
        $oStdPosicaoAtual->valores->valor_reducao        = is_null($oValores->valor_reducao)        ? $oValores->valor_reducao        : Regra::formatarValor($oValores->valor_reducao);
        $oStdPosicaoAtual->valores->percentual_reducao   = is_null($oValores->percentual_reducao)   ? $oValores->percentual_reducao   : Regra::formatarValor($oValores->percentual_reducao);
        $oStdAcordo->posicoes[$oStdPosicaoAtual->codigo_posicao] = $oStdPosicaoAtual;
      }
      $this->configurarObjetoLayout($oStdAcordo);
    }
  }

  /**
   * Configura um objeto stdClass com as informações necessárias para impressão do arquivo
   * @param stdClass $oStdDadosAcordo
   */
  private function configurarObjetoLayout(stdClass $oStdDadosAcordo) {

    foreach ($oStdDadosAcordo->posicoes as $oStdPosicao) {

      if (empty($oStdPosicao->sigla_tipo_aditamento)) {
        continue;
      }

      $oStdImprimir = new stdClass();
      $oStdImprimir->NR_LICITACAO         = $oStdDadosAcordo->numero_licitacao;
      $oStdImprimir->ANO_LICITACAO        = $oStdDadosAcordo->ano_licitacao;
      $oStdImprimir->CD_TIPO_MODALIDADE   = $oStdDadosAcordo->sigla_modalidade;
      $oStdImprimir->NR_CONTRATO          = $oStdDadosAcordo->numero_acordo;
      $oStdImprimir->ANO_CONTRATO         = $oStdDadosAcordo->ano_acordo;
      $oStdImprimir->TP_INSTRUMENTO       = $oStdDadosAcordo->tipo_instrumento;
      $oStdImprimir->SQ_EVENTO            = $oStdPosicao->codigo_evento;
      $oStdImprimir->CD_TIPO_OPERACAO     = $oStdPosicao->sigla_tipo_aditamento;
      $oStdImprimir->DS_OUTRA_OPERACAO    = '';
      $oStdImprimir->NR_DIAS_NOVO_PRAZO   = $oStdPosicao->valores->dias_novo_prazo;
      $oStdImprimir->VL_ACRESCIMO         = $oStdPosicao->valores->valor_acrescimo;
      $oStdImprimir->VL_REDUCAO           = $oStdPosicao->valores->valor_reducao;
      $oStdImprimir->PC_ACRESCIMO         = $oStdPosicao->valores->percentual_acrescimo;
      $oStdImprimir->PC_REDUCAO           = $oStdPosicao->valores->percentual_reducao;
      $oStdImprimir->TP_REGIME_EXECUCAO_NOVO = '';
      $oStdImprimir->TP_FORNECIMENTO_NOVO = '';
      $oStdImprimir->DS_JUSTIFICATIVA     = str_replace("\n", '', $oStdPosicao->justificativa);
      $this->aDadosArquivo[] = $oStdImprimir;
    }
  }
}