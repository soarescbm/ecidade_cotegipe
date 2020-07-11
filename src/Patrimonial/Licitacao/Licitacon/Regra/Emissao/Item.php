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

namespace ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao;

use ECidade\Patrimonial\Licitacao\Licitacon\Julgamento;
use ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao\BaseAbstract;
use ECidade\Patrimonial\Licitacao\Licitacon\Resultado;
use ECidade\Patrimonial\Licitacao\Licitacon\Situacao;

class Item extends BaseAbstract {

	const CODIGO_LAYOUT_V12  = 241;
	const CODIGO_LAYOUT_V13  = 273;

	const TP_OBJETO_OBRAS_SERVICO_ENGENHARIA = "OSE";

	/**
	 * @var \licitacao
	 */
	private $oLicitacao;

	/**
	 * @return int
	 */
	public function getCodigoLayout() {

		$iCodigoLayout = self::CODIGO_LAYOUT_V12;
		switch ($this->oConfiguracao->getVersao()) {

			case '1.3':
				$iCodigoLayout = self::CODIGO_LAYOUT_V13;
				break;
		}
		return $iCodigoLayout;
	}

	/**
	 * @param \licitacao $oLicitacao
	 */
	public function setLicitacao($oLicitacao) {
		$this->oLicitacao = $oLicitacao;
	}

	/**
	 * Busca o resultado do item.
	 * @param $iCgm
	 * @param $iCodigoOrcamentoItem
	 *
	 * @return string
	 */
	public function getResultadoItem($iCgm, $iCodigoOrcamentoItem) {

		$oResultado = new Resultado($this->oConfiguracao, $this->oLicitacao);
		$oResultado->setNumeroCgm($iCgm);
		$oResultado->setCodigoOrcamentoItem($iCodigoOrcamentoItem);
		$oSituacao = $oResultado->getResultadoItem();

		if (empty($oSituacao)) {
			return null;
		}
		return $oSituacao->getSigla();
	}

	/**
	 * Aplica a regra da sigla de unidade de medida.
	 * @param int $iCodigoUnidade C�digo da unidade de medida.
	 * @param string $sUnidadeMedida Unidade de medida do eCidade.
	 *
	 * @return string
	 */
	public function getSiglaUnidadeMedida($iCodigoUnidade, $sUnidadeMedida) {

		if (empty($iCodigoUnidade) || empty($sUnidadeMedida)) {
			return "UN";
		}
		return $sUnidadeMedida;
	}

	/**
	 * Busca os fornecedores do item.
	 * @param int $iCgm C�digo do cgm.
	 *
	 * @return \stdClass
	 */
	public function getFornecedores($iCgm) {

		$iFase = $this->oLicitacao->getFase();

		$oVencedor = new \stdClass();
		$oVencedor->tipo = null;
		$oVencedor->documento = null;

		$oFornecedor = new \stdClass();
		$oFornecedor->tipo = null;
		$oFornecedor->documento = null;

		$oFornecedores = new \stdClass();
		$oFornecedores->vencedor = $oVencedor;
		$oFornecedores->fornecedor = $oFornecedor;

		$oJulgamento = new Julgamento($this->oLicitacao->getTipoJulgamento());

		if (!$oJulgamento->isItem()) {
			return $oFornecedores;
		}
		/**
		 * Caso o Tipo da Modalidade da Licita��o n�o seja Dispensa ou Inexigibilidade.
		 */
		$lModalidadesDispensa = in_array($this->oLicitacao->getModalidade()->getSiglaTipoCompraTribunal(), array('PRD', 'PRI', 'RPO'));
		if (!$lModalidadesDispensa && $iFase == \EventoLicitacao::FASE_ADJUDICACAO_HOMOLOGACAO) {

			$oVencedor->tipo = \LicitanteLicitaCon::getTipoDocumentoPorCGM($iCgm);
			$oVencedor->documento = \LicitanteLicitaCon::getDocumentoPorCGM($iCgm);
		}

		if ($this->oConfiguracao->getVersao() != '1.2' && $lModalidadesDispensa) {

			$oFornecedor->tipo = \LicitanteLicitaCon::getTipoDocumentoPorCGM($iCgm);
			$oFornecedor->documento = \LicitanteLicitaCon::getDocumentoPorCGM($iCgm);
		}

		return $oFornecedores;
	}

	/**
	 * Decide o n�mero do lote do item.
	 * @param  int       $iNumeroLote
	 *
	 * @return int
	 */
	public function getNumeroLote($iNumeroLote) {

		//Licita��es com julgamento global e por item tem lote padr�o com valor 1.
		$oJulgamento = new Julgamento($this->oLicitacao->getTipoJulgamento());
		if (!$oJulgamento->isLote()) {
			return 1;
		}
		return $iNumeroLote;
	}

	/**
	 * Busca os valores estimados e homologados unit�rios e totais.
	 *
	 * @param int $iCodigoItemLicitacao
	 * @param int $iNumeroCgm
	 * @param int $iCodigoOrcamentoItem
	 *
	 * @return \stdClass Contendo os atributos totais e unitarios
	 * @throws \ParameterException
	 */
	public function getValoresEstimadoHomologado($iCodigoItemLicitacao, $iNumeroCgm, $iCodigoOrcamentoItem = null) {

		$iFase = $this->oLicitacao->getFase();

		$oStdValorHomologado = new \stdClass();
		$oStdValorHomologado->total_estimado      = null;
		$oStdValorHomologado->unitario_estimado   = null;
		$oStdValorHomologado->total_homologado    = null;
		$oStdValorHomologado->unitario_homologado = null;

		$oOrcamentoLicitacao = new \OrcamentoLicitacao($this->oLicitacao);
		$oOrcamentoLicitacao->setCodigoItem($iCodigoItemLicitacao);

		$oStdValorHomologado->total_estimado    = number_format($oOrcamentoLicitacao->getValorTotal(), 2, ',', '');
		$oStdValorHomologado->unitario_estimado = number_format($oOrcamentoLicitacao->getValorUnitario(), 2, ',', '');

		if ($iFase != \EventoLicitacao::FASE_ADJUDICACAO_HOMOLOGACAO) {
			return $oStdValorHomologado;
		}

		if ($this->oConfiguracao->getVersao() != '1.2' && in_array($this->oLicitacao->getModalidade()->getSiglaTipoCompraTribunal(), array('PRD', 'PRI', 'RPO', 'CPC', 'MAI'))) {
			return $oStdValorHomologado;
		}

		$oResultado = new Resultado($this->oConfiguracao, $this->oLicitacao);
		$oResultado->setCodigoOrcamentoItem($iCodigoOrcamentoItem);
		$oResultado->setNumeroCgm($iNumeroCgm);
		$oSituacao = $oResultado->getResultado();

		if (empty($oSituacao) || !$oSituacao->isAdjudicada()) {
			return $oStdValorHomologado;
		}

		$oStdValorHomologado->total_homologado    = number_format($oOrcamentoLicitacao->getValorTotalHomologado(), 2, ',', '');
		$oStdValorHomologado->unitario_homologado = number_format($oOrcamentoLicitacao->getValorUnitarioHomologado(), 2, ',', '');

		return $oStdValorHomologado;
	}

	/**
	 * Busca informa��es necess�rias para tipo de objeto Obras e Servi�o de Engenharia, buscando-as de acordo com
	 * a seguinte regra:
	 * 1. Or�amento do Processo de Compras
	 * 2. Solicita��o
	 *
	 * @param int    $iCodigoItemLicitacao
	 * @param string $sTipoObjeto
	 *
	 * @return \stdClass
	 * @throws \DBException
	 */
	public function getDadosOSE($iCodigoItemLicitacao, $sTipoObjeto) {

		$iCodigoLicitacao = $this->oLicitacao->getCodigo();

		$oStdDadosOSE = new \stdClass();
		$oStdDadosOSE->data             = null;
		$oStdDadosOSE->codigo           = null;
		$oStdDadosOSE->bdiEstimado      = null;
		$oStdDadosOSE->encargosEstimado = null;

		if ($sTipoObjeto != self::TP_OBJETO_OBRAS_SERVICO_ENGENHARIA) {
			return $oStdDadosOSE;
		}

		$aCampos = array(
			"(case when pcorcamitemproc.pc31_pcprocitem is not null then pcproc.pc80_data    else solicita.pc10_data  end) as data",
			"(case when pcorcamitemproc.pc31_pcprocitem is not null then pcproc.pc80_codproc else solicita.pc10_numero end) as codigo",
			"(case when pcorcamjulg.pc24_orcamitem is null then 0 else pc23_bdi end) as bdi",
			"(case when pcorcamjulg.pc24_orcamitem is null then 0 else pc23_encargossociais end) as encargossociais"
		);

		$aWhere = array(
			"liclicitem.l21_codigo = {$iCodigoItemLicitacao}",
			"liclicitem.l21_codliclicita = {$iCodigoLicitacao}",
			"(pcorcamitemproc.pc31_orcamitem is null or pcorcamjulg.pc24_pontuacao = 1)"
		);

		$oDaoLicLicitem    = new \cl_liclicitem();
		$sSqlBuscaDadosOSE = $oDaoLicLicitem->sql_query_valor_estimado(implode(',', $aCampos), implode(" and ", $aWhere));
		$rsBuscaDadosOSE   = db_query($sSqlBuscaDadosOSE);

		if (!$rsBuscaDadosOSE) {
			throw new \DBException("Houve um erro ao buscar a data de refer�ncia do valor estimado.");
		}

		if (pg_num_rows($rsBuscaDadosOSE) == 0) {
			return $oStdDadosOSE;
		}

		$oStdBuscaDadosOSE              = \db_utils::fieldsMemory($rsBuscaDadosOSE, 0);
		$oDataReferencia                = new \DBDate($oStdBuscaDadosOSE->data);
		$oStdDadosOSE->data             = $oDataReferencia->getDate(\DBDate::DATA_PTBR);
		$oStdDadosOSE->codigo           = $oStdBuscaDadosOSE->codigo;
		$oStdDadosOSE->bdiEstimado      = number_format($oStdBuscaDadosOSE->bdi, 2, ',', '');
		$oStdDadosOSE->encargosEstimado = number_format($oStdBuscaDadosOSE->encargossociais, 2, ',', '');

		return $oStdDadosOSE;
	}

	/**
	 * Verifica se deve exibir ou n�o os valores de DBI e Encargos das propostas dos fornecedores e formata-os.
	 * @param $nDBI
	 * @param $nEncargossociais
	 * @param $sTipoObjeto
	 *
	 * @return \stdClass
	 */
	public function getDBIEncargos($nDBI, $nEncargossociais, $sTipoObjeto) {

		$oRetorno = new \stdClass();
		$oRetorno->dbi = null;
		$oRetorno->encargos = null;

		if ($sTipoObjeto == self::TP_OBJETO_OBRAS_SERVICO_ENGENHARIA) {

			$oRetorno->dbi = empty($nDBI) ? null : number_format($nDBI, 2, ',', '');
			$oRetorno->encargos = empty($nEncargossociais) ? null : number_format($nEncargossociais, 2, ',', '');
		}

		return $oRetorno;
	}

}
