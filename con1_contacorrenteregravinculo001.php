<?
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_contacorrenteregravinculo_classe.php");
include("dbforms/db_funcoes.php");
require("libs/db_utils.php");
require_once("model/contabilidade/planoconta/ContaPlano.model.php");

db_postmemory($HTTP_POST_VARS);
$clcontacorrenteregravinculo = new cl_contacorrenteregravinculo;
$db_opcao = 1;
$db_botao = true;


if(isset($incluir)){
  
  $oDaoContaCorrenteRegraVinculo  = new cl_contacorrenteregravinculo();
  
  $sEstrutural = str_replace(".", "", ContaPlano::montaEstrutural($c27_estrutural));
  $sWhere      = "c27_estrutural = '{$sEstrutural}'";
  
  $sSqlContaCorrenteRegraVinculo  = $oDaoContaCorrenteRegraVinculo->sql_query_file(null, "*", null, $sWhere);
  $rsSqlContaCorrenteRegraVinculo = $oDaoContaCorrenteRegraVinculo->sql_record($sSqlContaCorrenteRegraVinculo);
  
  if ($oDaoContaCorrenteRegraVinculo->numrows > 0) {
    
    $iConta = db_utils::fieldsMemory($rsSqlContaCorrenteRegraVinculo, 0)->c27_contacorrente;
    
    db_msgbox("ERRO [ 1 ] - vincular estrutural - nivel estrutural {$sEstrutural} ja vinculado com a conta {$iConta} ");

  } else {
    
    db_inicio_transacao();
    
    $clcontacorrenteregravinculo->c27_estrutural = $sEstrutural;
    
    $clcontacorrenteregravinculo->incluir($c27_sequencial);
    db_fim_transacao();
    
  }
}


?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
    <center>
    	<?
    	$iDbUsuario = db_getsession("DB_id_usuario");
    	$sDbUsuario = db_getsession("DB_login");
    	/*
    	 * validamos o usuario e o login
    	* sendo a rotina exclusivamente para dbseller
    	*/
    	if ( ($iDbUsuario != 1) || ($sDbUsuario != 'dbseller') ) {
    	
    	  db_msgbox("Rotina exclusiva DBSeller, contate administrador !!");
    	  
    	} else {
    	  
    	  include("forms/db_frmcontacorrenteregravinculo.php");
    	}
    	
    	?>
    </center>

<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","c27_contacorrente",true,1,"c27_contacorrente",true);
</script>
<?
if(isset($incluir)){
  if($clcontacorrenteregravinculo->erro_status=="0"){
    $clcontacorrenteregravinculo->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcontacorrenteregravinculo->erro_campo!=""){
      echo "<script> document.form1.".$clcontacorrenteregravinculo->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcontacorrenteregravinculo->erro_campo.".focus();</script>";
    }
  }else{
    $clcontacorrenteregravinculo->erro(true,true);
  }
}
?>