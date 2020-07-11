<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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
include("classes/db_veiccadposto_classe.php");
include("classes/db_veiccadpostointerno_classe.php");
include("classes/db_veiccadpostoexterno_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clveiccadposto = new cl_veiccadposto;
$clveiccadpostointerno = new cl_veiccadpostointerno;
$clveiccadpostoexterno = new cl_veiccadpostoexterno;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  $sqlerro=false;
  db_inicio_transacao();
  $clveiccadposto->incluir($ve29_codigo);
  $erro_msg=$clveiccadposto->erro_msg;
  if($clveiccadposto->erro_status=="0"){
  	$sqlerro==true;
  }
  if($sqlerro==false){
  	if ($ve29_tipo==1){
  		$clveiccadpostointerno->ve35_veiccadposto=$clveiccadposto->ve29_codigo;
  		$clveiccadpostointerno->incluir(null);
  		if($clveiccadpostointerno->erro_status=="0"){
  			$sqlerro==true;
  			$erro_msg=$clveiccadpostointerno->erro_msg;
  		}
  	}else if($ve29_tipo==2){
  		$clveiccadpostoexterno->ve34_veiccadposto=$clveiccadposto->ve29_codigo;
  		$clveiccadpostoexterno->incluir(null);
  		if($clveiccadpostoexterno->erro_status=="0"){
  			$sqlerro==true;
  			$erro_msg=$clveiccadpostoexterno->erro_msg;
  		}
  	}  	
  }  
  db_fim_transacao();
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
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmveiccadposto.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","ve29_tipo",true,1,"ve29_tipo",true);
</script>
<?
if(isset($incluir)){	
  if($clveiccadposto->erro_status=="0"&&$sqlerro==true){
  	db_msgbox($erro_msg);
    //$clveiccadposto->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clveiccadposto->erro_campo!=""){
      echo "<script> document.form1.".$clveiccadposto->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clveiccadposto->erro_campo.".focus();</script>";
    }
  }else{
    $clveiccadposto->erro(true,true);
  }
}
?>