<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

/*
 * Implementa interface iViradaIPTU.interface.php
 * @method public vira()
 */
require_once('interfaces/iViradaIPTU.interface.php');

class CadvencIPTU implements iViradaIPTU {
  
  /**
   * Anual atual do exercic�o
   * @var integer
   */
  private $iAnoAtual      = 0;
  
  /**
   * Ano novo do exercic�o
   * @var integer
   */
  private $iAnoNovo       = 0;
  
  /**
   * C�digo Atual
   * @var integer
   */
  private $iCodigo        = 0;
  
  /**
   * C�digo da tabela da virada anual
   * @var integer
   */
  private $iCodigoTabela  = 0;
  
  /**
   * Percentual aplicado para os valores
   * @var numeric
   */
  private $nPercentual    = 0;
  
  /**
   * Campos chave configurados na tabela iptutabelasconfigcampochave
   * @var array
   */
  private $aCampoChave    = array();
  
  /**
   * Campos correcao configurados na tabela iptutabelasconfigcampocorrecao
   * @var array
   */
  private $aCampoCorrecao = array();
  
  /**
   * @return $this->iAnoAtual
   */
  private function getAnoAtual() {

    return $this->iAnoAtual;
  }
  
  /**
   * @param integer type $iAnoAtual
   */
  private function setAnoAtual($iAnoAtual) {

    $this->iAnoAtual = $iAnoAtual;
  }
  
  /**
   * @return $this->iAnoNovo
   */
  private function getAnoNovo() {

    return $this->iAnoNovo;
  }
  
  /**
   * @param integer type $iAnoNovo
   */
  private function setAnoNovo($iAnoNovo) {

    $this->iAnoNovo = $iAnoNovo;
  }
  
  /**
   * @return integer
   */
  private function getCodigo() {

    return $this->iCodigo;
  }
  
  /**
   * @param integer $iCodigo
   */
  private function setCodigo($iCodigo) {

    $this->iCodigo = $iCodigo;
  }
  
  /**
   * @return integer
   */
  private function getCodigoTabela() {

    return $this->iCodigoTabela;
  }
  
  /**
   * @param integer $iCodigoTabela
   */
  private function setCodigoTabela($iCodigoTabela) {

    $this->iCodigoTabela = $iCodigoTabela;
  }

  /**
   * @return $this->nPercentual
   */
  private function getPercentual() {

    return $this->nPercentual;
  }
  
  /**
   * @param numeric type $nPercentual
   */
  private function setPercentual($nPercentual) {

    $this->nPercentual = $nPercentual;
  }

  /**
   * @return $this->aCampoChave
   */
  private function getCampoChave() {

    return $this->aCampoChave;
  }
  
  /**
   * @param string  type $sCampoChave
   */
  private function setCampoChave($sCampoChave) {

    $this->aCampoChave[] = $sCampoChave;
    return $this;
  }
  
  /**
   * @return $this->aCampoCorrecao
   */
  private function getCampoCorrecao() {

    return $this->aCampoCorrecao;
  }
  
  /**
   * @param string type $sCampoCorrecao
   */
  private function setCampoCorrecao($sCampoCorrecao) {

    $this->aCampoCorrecao[] = $sCampoCorrecao;
    return $this;
  }
  
  function __construct() {
     
    $this->setAnoAtual(db_getsession('DB_anousu'));
    $this->setAnoNovo(db_getsession('DB_anousu') + 1);
    
    /**
     * Pesquisa se j� foi feito a virada anual 
     */
    $oDaoIptuTabelasConfig  = db_utils::getDao('iptutabelasconfig');
    $sSqlIptuTabelasConfig  = $oDaoIptuTabelasConfig->sql_query(null, "iptutabelasconfig.j122_sequencial", 
                                                                null, "db_sysarquivo.nomearq = 'cadvenc'");
    $rsSqlIptuTabelasConfig = $oDaoIptuTabelasConfig->sql_record($sSqlIptuTabelasConfig);
    if ($oDaoIptuTabelasConfig->numrows > 0) {
      
      $oDadosIptuTabelasConfig      = db_utils::fieldsMemory($rsSqlIptuTabelasConfig, 0);
      $oDaoIptuTabelasConfigVirada  = db_utils::getDao('iptutabelasconfigvirada');
      
      $sWhere                       = "j129_iptutabelasconfig = {$oDadosIptuTabelasConfig->j122_sequencial}";
      $sWhere                      .= " and j129_anousu = {$this->getAnoNovo()}";
      $sSqlIptuTabelasConfigVirada  = $oDaoIptuTabelasConfigVirada->sql_query_file(null, "*", null, $sWhere);
      $rsSqlIptuTabelasConfigVirada = $oDaoIptuTabelasConfigVirada->sql_record($sSqlIptuTabelasConfigVirada);
      if ($oDaoIptuTabelasConfigVirada->numrows > 0) {
      	
        $sMensagem = "ERRO: Tabela cadvenc j� foi feito virada anual para exercic�o {$this->getAnoNovo()}!";
        throw new Exception($sMensagem);
      }
      
      $this->setCodigoTabela($oDadosIptuTabelasConfig->j122_sequencial);
    }
    
    /**
     * Pesquisa percentual padrao
     */
    $oDaoCfIptuCorrecao  = db_utils::getDao('cfiptu');
    $sCampos             = "cfiptu.j18_perccorrepadrao, cfiptu.j18_vencim";
    $sSqlCfIptuCorrecao  = $oDaoCfIptuCorrecao->sql_query_file(($this->getAnoNovo()-1), $sCampos, null, '');
    $rsSqlCfIptuCorrecao = $oDaoCfIptuCorrecao->sql_record($sSqlCfIptuCorrecao);
    if ($oDaoCfIptuCorrecao->numrows == 0) {
      
      $sMensagem = "ERRO: Nenhum registro encontrado na cfiptu exercic�o {$this->getAnoNovo()}!";
      throw new Exception($sMensagem);
    }
    
    $oCfIptuCorrecao = db_utils::fieldsMemory($rsSqlCfIptuCorrecao, 0);
    $this->setPercentual($oCfIptuCorrecao->j18_perccorrepadrao);
    $this->setCodigo($oCfIptuCorrecao->j18_vencim);
    
    /**
     * Pesquisa campos chave
     */
    $oDaoIptuTabelasConfigCampoChave  = db_utils::getDao('iptutabelasconfigcampochave');   
    $sWhere                           = "db_sysarquivo.nomearq = 'cadvenc'";
    $sSqlIptuTabelasConfigCampoChave  = $oDaoIptuTabelasConfigCampoChave->sql_query(null, "db_syscampo.nomecam", null, $sWhere);
    $rsSqlIptuTabelasConfigCampoChave = $oDaoIptuTabelasConfigCampoChave->sql_record($sSqlIptuTabelasConfigCampoChave);
    for ($iInd = 0; $iInd < $oDaoIptuTabelasConfigCampoChave->numrows; $iInd++) {
        
      $oIptuTabelasConfigCampoChave = db_utils::fieldsMemory($rsSqlIptuTabelasConfigCampoChave, $iInd);
      $this->setCampoChave($oIptuTabelasConfigCampoChave->nomecam);
    }
    
    /**
     * Pesquisa campo para correcao de percentual
     */
    $oDaoIptuTabelasConfigCorrecao  = db_utils::getDao('iptutabelasconfigcampocorrecao');
    $sWhere                         = "db_sysarquivo.nomearq = 'cadvenc'";
    $sSqlIptuTabelasConfigCorrecao  = $oDaoIptuTabelasConfigCorrecao->sql_query(null, "*", null, $sWhere);
    $rsSqlIptuTabelasConfigCorrecao = $oDaoIptuTabelasConfigCorrecao->sql_record($sSqlIptuTabelasConfigCorrecao);
    if ($oDaoIptuTabelasConfigCorrecao->numrows > 0) {
      
      for ($iInd = 0; $iInd < $oDaoIptuTabelasConfigCorrecao->numrows; $iInd++) {
        
        $oIptuTabelasConfigCorrecao = db_utils::fieldsMemory($rsSqlIptuTabelasConfigCorrecao, $iInd);
        $this->setCampoCorrecao($oIptuTabelasConfigCorrecao->nomecam); 
      }
    }
  }
  
  /**
   * Processa virada anual
   *
   * @return $this
   */
  public function vira() {

    if (!db_utils::inTransaction()) {
      throw new Exception("Nenhuma transa��o com o banco de dados aberta.  \\n\\nProcessamento cancelado.");
    }

    $iAnoAtual = $this->getAnoAtual();
    if ($iAnoAtual == 0) {
    
      $sMensagem = "ERRO: Ano exerc�cio atual nao definido!";
      throw new Exception($sMensagem);
    }
    
    $iAnoNovo = $this->getAnoNovo();
    if ($iAnoNovo == 0) {
    
      $sMensagem = "ERRO: Ano pr�ximo exerc�cio nao definido!";
      throw new Exception($sMensagem);
    }
    
    $iCodigo = $this->getCodigo();
    if ($iCodigo == 0) {
    
      $sMensagem = "ERRO: C�digo q82_codigo nao definido!";
      throw new Exception($sMensagem);
    }
  	
    $oDaoCadVenc  = db_utils::getDao('cadvenc');
    $sCampo       = " ( select max(q92_codigo) from cadvencdesc ) as q82_codigo,      ";
    $sCampo      .= " q82_parc,                                                       ";
    $sCampo      .= " q82_venc + '1 year':: interval as q82_venc,                     "; 
    $sCampo      .= " q82_desc,                                                       ";
    $sCampo      .= " q82_perc,                                                       ";
    $sCampo      .= " q82_hist,                                                       ";
    $sCampo      .= " q82_calculaparcvenc                                             ";
    $sWhere       = " q82_codigo = {$this->getCodigo()}                               ";
    $sSqlCadVenc  = $oDaoCadVenc->sql_query_file(null, null, $sCampo, 'q82_parc', $sWhere);
    $rsSqlCadVenc = $oDaoCadVenc->sql_record($sSqlCadVenc);
    $iNumRows = $oDaoCadVenc->numrows;
    if ($iNumRows > 0) {

    	for ( $iInd=0; $iInd < $iNumRows; $iInd++ ) {
    		
    		$oDadosCadVenc  = db_utils::fieldsMemory($rsSqlCadVenc, $iInd);
        $aCamposCadVenc = get_object_vars($oDadosCadVenc);
        
        foreach ($aCamposCadVenc as $sNomeCampoCadVenc => $sValorCampoCadVenc ) {
        	
          if (in_array($sNomeCampoCadVenc, $this->getCampoCorrecao())) {
            
            $nPercentual     = $this->getPercentual();
            $nSomaPercentual = ($oDadosCadVenc->$sNomeCampoCadVenc + ($oDadosCadVenc->$sNomeCampoCadVenc * ($nPercentual / 100)));
            $oDaoCadVenc->$sNomeCampoCadVenc = "{$nSomaPercentual}";
          } else {
          	
          	if (trim($sNomeCampoCadVenc) == 'q82_codigo') {
          		$iCodigo = $oDadosCadVenc->$sNomeCampoCadVenc;
          	}

            if (trim($sNomeCampoCadVenc) == 'q82_parc') {
              $iParc = $oDadosCadVenc->$sNomeCampoCadVenc;
            }
       	
            $oDaoCadVenc->$sNomeCampoCadVenc = $oDadosCadVenc->$sNomeCampoCadVenc;
            if (trim($sNomeCampoCadVenc) == 'q82_calculaparcvenc') {
              $oDaoCadVenc->$sNomeCampoCadVenc = ($oDadosCadVenc->$sNomeCampoCadVenc='t'?'true':'false');
            }
          }
        }
        
        $oDaoCadVenc->incluir($iCodigo, $iParc);
        if ($oDaoCadVenc->erro_status == 0) {
          throw new Exception($oDaoCadVenc->erro_msg);
        }
    	}
    }

    /**
     * Adiciona registro para verifica��o se tabela j� fez virada anual
     */
	  $oDaoIptuTabelasConfigVirada = db_utils::getDao('iptutabelasconfigvirada');	  
	  $oDaoIptuTabelasConfigVirada->j129_iptutabelasconfig = $this->getCodigoTabela();
	  $oDaoIptuTabelasConfigVirada->j129_anousu            = $this->getAnoNovo();
	  $oDaoIptuTabelasConfigVirada->incluir(null);
	  if ($oDaoIptuTabelasConfigVirada->erro_status == 0) {
	    throw new Exception($oDaoIptuTabelasConfigVirada->erro_msg);
	  }
        
    return $this;
  }
}
?>