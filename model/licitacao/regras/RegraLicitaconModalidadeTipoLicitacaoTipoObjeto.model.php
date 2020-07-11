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
class RegraLicitaconModalidadeTipoLicitacaoTipoObjeto extends RegraLicitacon {

  protected $sMensagem = "A combinação entre Modalidade, Tipo de Licitação e Tipo de Objeto não é válida.\n\nVerifique as combinações possíveis entre as modalidades, os tipos de licitação e os tipos de objeto disponíveis no LicitaCon no Apêndice C.";

	/**
   * @var array
   */
  protected $aRegrasApendiceC = array(
    'CPC' => array(
      'NSA' => array('OUS'),
    ),
    'CHP' => array(
      'MPR' => array('COM', 'OUS', 'CSE'),
      'TPR' => array('COM', 'OUS', 'CSE'),
			'MTC' => array('CSE')
    ),
    'CNC' => array(
      'MDE' => array('COM', 'OSE', 'CSE', 'OUS'),
      'MLO' => array('ALB', 'PER', 'CON', 'OUS'),
      'MOQ' => array('PER', 'CON'),
      'MOT' => array('PER', 'CON'),
      'MOO' => array('CON', 'PER'),
      'MPP' => array('CON', 'PER'),
      'MTC' => array('OSE', 'CSE', 'OUS', 'ALB'),
      'MPR' => array('OUS', 'CSE', 'COM', 'OSE'),
      'MTO' => array('PER', 'CON'),
      'MTT' => array('CON', 'PER'),
      'MVT' => array('CON', 'PER'),
      'TPR' => array('COM', 'OSE', 'CSE', 'OUS'),
    ),
    'CNS' => array(
      'MTC' => array('OSE', 'OUS')
    ),
    'CNV' => array(
      'MLO' => array('PER'),
      'MOQ' => array('PER'),
      'MOT' => array('PER'),
      'MOO' => array('PER'),
      'MPP' => array('PER'),
      'MTC' => array('CSE', 'OSE', 'OUS'),
      'MPR' => array('CSE', 'OUS', 'COM', 'OSE'),
      'MTO' => array('PER'),
      'MTT' => array('PER'),
      'MVT' => array('PER'),
      'TPR' => array('CSE', 'OSE', 'COM', 'OUS')
    ),
    'LEI' => array(
      'MLO' => array('ALB')
    ),
    'MAI' => array(
      'NSA' => array('OUS', 'OSE')
    ),
    'PRE' => array(
      'MDE' => array('COM', 'CSE', 'OSE', 'OUS'),
      'MPR' => array('COM', 'CSE', 'OSE', 'OUS'),
      'MLO' => array('CON', 'PER', 'OUS'),
      'MOO' => array('CON', 'PER')
    ),
    'PRP' => array(
      'MDE' => array('COM', 'CSE', 'OSE', 'OUS'),
      'MPR' => array('COM', 'CSE', 'OSE', 'OUS'),
      'MLO' => array('CON', 'PER', 'OUS'),
      'MOO' => array('CON', 'PER')
    ),
    'PRD' => array(
      'NSA' => array('CSE', 'OUS', 'OSE', 'LOC', 'PER', 'CON', 'ALB', 'COM')
    ),
    'PRI' => array(
      'NSA' => array('CSE', 'OUS', 'OSE', 'COM', 'ALB')
    ),
    'RDC' => array(
      'MDE' => array('COM', 'CSE', 'OUS', 'OSE'),
      'MOP' => array('ALB'),
      'MCA' => array('OUS'),
      'MTC' => array('OUS', 'OSE'),
      'MPR' => array('CSE', 'OSE', 'OUS', 'COM'),
      'TPR' => array('CSE', 'OSE', 'OUS', 'COM')
    ),
    'RPO' => array(
      'NSA' => array('CSE', 'OSE', 'OUS', 'COM')
    ),
    'RIN' => array(
      'MLO' => array('ALB'),
      'MTC' => array('CSE', 'OSE', 'OUS'),
      'MPR' => array('CSE', 'OSE', 'OUS', 'COM'),
      'TPR' => array('CSE', 'OSE', 'OUS', 'COM')
    ),
    'TMP' => array(
      'MLO' => array('PER'),
      'MOQ' => array('PER'),
      'MOT' => array('PER'),
      'MOO' => array('PER'),
      'MPP' => array('PER'),
      'MTC' => array('OSE', 'CSE', 'OUS'),
      'MPR' => array('OUS', 'OSE', 'COM', 'CSE'),
      'MTO' => array('PER'),
      'MTT' => array('PER'),
      'MVT' => array('PER'),
      'TPR' => array('OUS', 'OSE', 'COM', 'CSE'),
    )
  );

  protected function getRegras() {
    return $this->aRegrasApendiceC;
  }

  public function regra() {

    $sModalidade    = $this->oLicitacao->getModalidade()->getSiglaTipoCompraTribunal();
    $sTipoLicitacao = null;
    $sTipoObjeto    = null;
    $aRegras        = $this->getRegras();

    if (isset($this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_LICITACAO])) {
      $sTipoLicitacao = $this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_LICITACAO];
    }

    if (isset($this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_OBJETO])) {
      $sTipoObjeto = $this->aAtributosDinamicos[LicitacaoAtributosDinamicos::NOME_TIPO_OBJETO];
    }

    if (empty($sTipoObjeto)) {

      $this->sMensagem = "O campo Tipo de Objeto é de preenchimento obrigatório.";
      return false;
    }

    if (empty($sTipoLicitacao)) {

      $this->sMensagem = "O campo Tipo de Licitação é de preenchimento obrigatório.";
      return false;
    }

    if (!isset($aRegras[$sModalidade]) || !isset($aRegras[$sModalidade][$sTipoLicitacao])) {
      return false;
    }

    if (!in_array($sTipoObjeto, $aRegras[$sModalidade][$sTipoLicitacao])) {
      return false;
    }

    return true;
  }
}