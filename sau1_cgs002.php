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
include("classes/db_cgs_classe.php");
include("classes/db_cgm_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clcgs = new cl_cgs;
$clcgm = new cl_cgm;
$db_opcao = 22;
$db_botao = false;
if($cgm == "" || $cgm == null){
 db_redireciona("sau1_cgm001.php");
}
if(isset($cgm)){
   @$result = $clcgs->sql_record($clcgs->sql_query($cgm));
   @db_fieldsmemory($result,0);
   $db_botao = true;
   $db_opcao = 2;
 if($clcgs->numrows == 0){
  @$result1 = $clcgm->sql_record($clcgm->sql_query($cgm));
  @db_fieldsmemory($result1,0);
  $db_opcao = 1;
 }
}
if(isset($incluir)){
  db_inicio_transacao();
  $clcgs->incluir($z01_numcgm);
  $db_opcao = 2;
  db_fim_transacao();
}
if(isset($alterar)){
  db_inicio_transacao();
  $clcgs->sd01_i_cgm = $cgm;
  $clcgm->z01_numcgm = $cgm;
  $clcgs->alterar($cgm);
  $clcgm->alterar($cgm);
  $db_opcao = 2;
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
    <br>
	<?
	include("forms/db_frmcgs.php");
	?>
    </center>
    </td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($incluir)){
  if($clcgs->erro_status=="0"){
    $clcgs->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcgs->erro_campo!=""){
      echo "<script> document.form1.".$clcgs->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcgs->erro_campo.".focus();</script>";
    }
  }else{
   db_msgbox($clcgs->erro_msg);
   db_redireciona(basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?cgm=".$cgm."&numero=".$numero."&tp=".$tp);
  }
}
?>