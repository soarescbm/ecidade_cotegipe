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

namespace ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao;

use ECidade\Patrimonial\Licitacao\Licitacon\Regra\Emissao\BaseAbstract;
use ECidade\Patrimonial\Licitacao\Licitacon\Resultado;
use ECidade\Patrimonial\Licitacao\Licitacon\Julgamento;
use \ParameterException;
use \SituacaoLicitacao;
use \OrcamentoLicitacao;
use \EventoLicitacao;
use \stdClass;
use \DBException;
use \cl_liclicita;
use \cl_pcorcamjulg;
use \LicitanteLicitaCon;

/**
 * Regras de layout emissão do arquivo licitacao do licitacon.
 * Class Licitacao
 */
class Licitacao extends BaseAbstract {

  /**
   * Código do leiaute da versão 1.2
   * @var integer
   */
	const CODIGO_LAYOUT_V12 = 235;

  /**
   * Código do leiaute da versão 1.3
   * @var integer
   */
	const CODIGO_LAYOUT_V13 = 264;

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
	public function setLicitacao(\licitacao $oLicitacao) {
		$this->oLicitacao = $oLicitacao;
	}

	/**
	 * @return null|string
	 * @throws ParameterException
	 */
	public function getTipoJulgamentoSigla() {

		if (empty($this->oLicitacao)) {
			throw new ParameterException("Licitação não informada.");
		}

		$iTipoJulgamento = $this->oLicitacao->getTipoJulgamento();
		$nVersao = floatval($this->oConfiguracao->getVersao());
		if ($this->oLicitacao->getModalidade()->getSiglaTipoCompraTribunal() == 'MAI' && $nVersao >= 1.3) {
			$iTipoJulgamento = \licitacao::TIPO_JULGAMENTO_GLOBAL;
		}

		$oJulgamento = new Julgamento($iTipoJulgamento);
		return $oJulgamento->getSigla();
	}

	/**
	 * Retorna o resultado global da licitação conforma regras do LicitaCon.
	 *
	 * @return null|string
	 * @throws ParameterException
	 */
	public function getResultadoGlobal() {

		if (empty($this->oLicitacao)) {
			throw new ParameterException("Licitação não informada.");
		}

		$oResultado = new Resultado($this->oConfiguracao, $this->oLicitacao);
		$oSituacao = $oResultado->getResultadoGlobal();
		if (empty($oSituacao)) {
			return null;
		}
		return $oSituacao->getSigla();
	}

	/**
	 * Retorna o resultado global da licitação conforma regras do LicitaCon.
	 *
	 * @return stdClass
	 * @throws DBException
	 * @throws ParameterException
	 */
	public function getFornecedor() {

		if (empty($this->oLicitacao)) {
			throw new ParameterException("Licitação não informada.");
		}

		$oVencedor = new stdClass();
		$oVencedor->tipo = null;
		$oVencedor->documento = null;

		$oFornecedor = new stdClass();
		$oFornecedor->tipo = null;
		$oFornecedor->documento = null;

		$oFornecedores = new stdClass();
		$oFornecedores->vencedor   = $oVencedor;
		$oFornecedores->fornecedor = $oFornecedor;

		$sSiglaModalidade = $this->oLicitacao->getModalidade()->getSiglaTipoCompraTribunal();
		$lModalidadesDispensa = in_array($sSiglaModalidade, array('PRD', 'PRI', 'RPO'));
		if ($this->oLicitacao->getTipoJulgamento() != \licitacao::TIPO_JULGAMENTO_GLOBAL) {
			return $oFornecedores;
		}

		$oDaoPcOrcamItemLic = new cl_liclicita();
		$oDaoPCOrcamJulg    = new cl_pcorcamjulg();

		$sCamposFornecedores = " cgm.z01_numcgm ";
		$sWhereFornecedores  = " l21_codliclicita = {$this->oLicitacao->getCodigo()} ";
		if ($lModalidadesDispensa) {

			$sWhereFornecedores2 = " {$sWhereFornecedores} and pc24_pontuacao = 1 ";
			$sSqlFonecedores = $oDaoPcOrcamItemLic->sql_query_licitantes(" distinct " . $sCamposFornecedores, $sWhereFornecedores2);
			$rsFornecedores  = db_query($sSqlFonecedores);
			if ($rsFornecedores === false) {
				throw new DBException("Houve um erro ao buscar os fornecedores da licitação.");
			}

			if (pg_num_rows($rsFornecedores) == 1) {

				$iCodigoCGM = \db_utils::fieldsMemory($rsFornecedores, 0)->z01_numcgm;
				$oFornecedores->fornecedor->tipo = LicitanteLicitaCon::getTipoDocumentoPorCGM($iCodigoCGM);
				$oFornecedores->fornecedor->documento = LicitanteLicitaCon::getDocumentoPorCGM($iCodigoCGM);
			}
		}

		if ($this->oLicitacao->getFase() == EventoLicitacao::FASE_ADJUDICACAO_HOMOLOGACAO) {

			$sWhereFornecedores .= " and pc24_pontuacao = 1 group by {$sCamposFornecedores} ";
			$sSqlFornecedores    = $oDaoPCOrcamJulg->sql_query_orcamento_licitacao(" distinct " . $sCamposFornecedores, $sWhereFornecedores);
			$rsFornecedores      = db_query($sSqlFornecedores);
			if ($rsFornecedores === false) {
				throw new DBException("Houve um erro ao buscar o fornecedor vencedor da licitação.");
			}

			if (pg_num_rows($rsFornecedores) == 1) {

				$iCodigoCGM = \db_utils::fieldsMemory($rsFornecedores, 0)->z01_numcgm;
				$oFornecedores->vencedor->tipo = LicitanteLicitaCon::getTipoDocumentoPorCGM($iCodigoCGM);
				$oFornecedores->vencedor->documento = LicitanteLicitaCon::getDocumentoPorCGM($iCodigoCGM);
			}
		}
		return $oFornecedores;
	}

	/**
	 * Busca valor homologado de acordo com as regras do manual do Licitacon.
	 *
	 * @return null|string
	 * @throws ParameterException
	 */
	public function getValorHomologado() {

		if (empty($this->oLicitacao)) {
			throw new ParameterException("Licitação não informada.");
		}

		$aModalidadesDispensadas= array('PRD', 'PRI', 'RPO', 'CPC','MAI');
		$nVersao = floatval($this->oConfiguracao->getVersao());
		$sModalidade = $this->oLicitacao->getModalidade()->getCodigoTipoCompraTribunal();

		if ($nVersao >= 1.3 && in_array($sModalidade, $aModalidadesDispensadas)) {
			return null;
		}

		$iTipoJulgamento = $this->oLicitacao->getTipoJulgamento();
		if (\licitacao::TIPO_JULGAMENTO_GLOBAL != $iTipoJulgamento) {
			return null;
		}

		if ($this->oLicitacao->getFase() != EventoLicitacao::FASE_ADJUDICACAO_HOMOLOGACAO) {
			return null;
		}

		$oOrcamentoLicitacao = new OrcamentoLicitacao($this->oLicitacao);
		$nValorHomologado    = $oOrcamentoLicitacao->getValorTotalHomologado();

		return number_format($nValorHomologado, 2, ',', '');
	}
}