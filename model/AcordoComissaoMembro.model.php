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

/**
 * @package contratos
 */
class AcordoComissaoMembro {

  const TIPO_GESTOR     = 1;
  const TIPO_SECUNDARIO = 2;
  const TIPO_SUPLENTE   = 3;
  const TIPO_FISCAL     = 4;

  /**
   * Codigo do membro.
   *
   * @var Integer
   */
  private $iCodigo;

  /**
   * Nome do membro.
   *
   * @var String
   */
  private $sNome;

  /**
   * Codigo CGM do membro.
   *
   * @var Integer
   */
  private $iCodigoCgm;

  /**
   * Codigo da comissao do membro.
   *
   * @var Integer
   */
  private $iCodigoComissao;

  /**
   * Codigo da responsabilidade do cliente;
   *
   * @var Integer
   */
  private $iResponsabilidade;

  /**
   *
   * @var string
   */
  private $sDescricaoResponsabilidade;

  /**
   *
   * @var DBDate
   */
  private $oDataInicio;

  /**
   *
   * @var DBDate
   */
  private $oDataTermino;

  /**
   * @param integer $iCodigo
   */
  function __construct($iCodigo = null) {

    if ($iCodigo) {

      $oDaoComissaoMembro = new cl_acordocomissaomembro;
      $sSqlMembro         = $oDaoComissaoMembro->sql_query(null, "*", "", " ac07_sequencial={$iCodigo}");
      $rsCM               = $oDaoComissaoMembro->sql_record($sSqlMembro);

      if ($rsCM && $oDaoComissaoMembro->numrows != 0) {

        $oMembro = db_utils::fieldsMemory($rsCM, 0);

        $this->setCodigo($oMembro->ac07_sequencial);
        $this->setNome($oMembro->z01_nome);
        $this->setCodigoCgm($oMembro->ac07_numcgm);
        $this->setCodigoComissao($oMembro->ac07_acordocomissao);
        $this->setResponsabilidade($oMembro->ac07_tipomembro);
        $this->setDescricaoResponsabilidade($oMembro->ac42_descricao);
        if (!empty($oMembro->ac07_datainicio)) {
          $this->setDataInicio(new DBDate($oMembro->ac07_datainicio));
        }
        if (!empty($oMembro->ac07_datatermino)) {
          $this->setDataTermino(new DBDate($oMembro->ac07_datatermino));
        }
      }
    }
  }

  public function save() {

    if (!db_utils::inTransaction()) {
      throw new Exception("Não existe transação ativa com o bando de dados.");
    }

    $oDaoComissaoMembro = new cl_acordocomissaomembro;
    $oDaoComissaoMembro->ac07_numcgm         = $this->getCodigoCgm();
    $oDaoComissaoMembro->ac07_acordocomissao = $this->getCodigoComissao();
    $oDaoComissaoMembro->ac07_tipomembro     = $this->getResponsabilidade();

    $oDataInicio = $this->getDataInicio();
    if ($oDataInicio) {
      $oDaoComissaoMembro->ac07_datainicio = $this->getDataInicio()->getDate();
    }

    $oDataTermino = $this->getDataTermino();
    if ($oDataTermino) {
      $oDaoComissaoMembro->ac07_datatermino = $this->getDataTermino()->getDate();
    }

    if ($oDataInicio && $oDataTermino && $oDataInicio->getTimeStamp() > $oDataTermino->getTimeStamp()) {
      throw new BusinessException('Data de Início deve ser menor ou igual a Data de Término.');
    }

    if ($this->getCodigo()) {

      $oDaoComissaoMembro->ac07_sequencial = $this->getCodigo();
      $oDaoComissaoMembro->alterar($this->getCodigo());
    } else {

      $oDaoComissaoMembro->incluir(null);
    }

    if ($oDaoComissaoMembro->erro_status == 0) {

      $sMensagem  = "Houve um erro ao salvar dados do membro da comissao.\n";
      $sMensagem .= "Erro:{$oDaoComissaoMembro->erro_msg}";
      throw new Exception($sMensagem);
    }
  }

  public function excluir() {

    $oDaoComissaoMembro = new cl_acordocomissaomembro;
    $oDaoComissaoMembro->excluir($this->getCodigo());

    if ($oDaoComissaoMembro->erro_status == 0) {

      $sMensagem  = "Houve um erro ao excluir o membro da comissao.\n";
      $sMensagem .= "Erro:{$oDaoComissaoMembro->erro_msg}";
      throw new Exception($sMensagem);
    }

  }

  /**
   * @return Integer
   */
  public function getCodigo() {

    return $this->iCodigo;
  }

  /**
   * @return Integer
   */
  public function getCodigoCgm() {

    return $this->iCodigoCgm;
  }

  /**
   * @return Integer
   */
  public function getCodigoComissao() {

    return $this->iCodigoComissao;
  }

  /**
   * @return String
   */
  public function getNome() {

    return $this->sNome;
  }

  /**
   * @return Integer
   */
  public function getResponsabilidade() {

    return $this->iResponsabilidade;
  }
  /**
   * @param Integer $iCodigo
   */
  public function setCodigo($iCodigo) {

    $this->iCodigo = $iCodigo;
  }

  /**
   * @param Integer $iCodigoCgm
   */
  public function setCodigoCgm($iCodigoCgm) {

    $this->iCodigoCgm = $iCodigoCgm;
  }

  /**
   * @param Integer $iCodigoComissao
   */
  public function setCodigoComissao($iCodigoComissao) {

    $this->iCodigoComissao = $iCodigoComissao;
  }

  /**
   * @param String $sNome
   */
  public function setNome($sNome) {

    $this->sNome = $sNome;
  }

  /**
   * @param Integer $iResponsabilidade
   */
  public function setResponsabilidade($iResponsabilidade) {

    $this->iResponsabilidade = $iResponsabilidade;
  }

  /**
   * metodo para retornar a descrição da responsabilidade, dentro da comissão
   * @return string
   */
  public function getDescricaoResponsabilidade() {
    return $this->sDescricaoResponsabilidade;
  }

  /**
   * @param string $sDescricaoResponsabilidade
   */
  public function setDescricaoResponsabilidade($sDescricaoResponsabilidade) {
    $this->sDescricaoResponsabilidade = $sDescricaoResponsabilidade;
  }

  /**
   * @return DBDate $oDataInicio
   */
  public function getDataInicio() {
    return $this->oDataInicio;
  }

  /**
   * @param DBDate $oDataInicio
   */
  public function setDataInicio(DBDate $oDataInicio) {
    $this->oDataInicio = $oDataInicio;
  }

  /**
   * @return DBDate $oDataTermino
   */
  public function getDataTermino() {
    return $this->oDataTermino;
  }

  /**
   * @param DBDate $oDataTermino
   */
  public function setDataTermino(DBDate $oDataTermino) {
    $this->oDataTermino = $oDataTermino;
  }

}
