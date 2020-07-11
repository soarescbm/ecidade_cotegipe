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

include("classes/db_orcimpactovalmov_classe.php");
include("classes/db_orcimpactovalmovmes_classe.php");
include("classes/db_orcimpactovalmovele_classe.php");
include("classes/db_orcimpactotiporec_classe.php");
include("classes/db_orcimpactomov_classe.php");
include("classes/db_orcelemento_classe.php");

include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clorcimpactovalmov     = new cl_orcimpactovalmov;
$clorcimpactovalmovmes  = new cl_orcimpactovalmovmes;
$clorcimpactovalmovele  = new cl_orcimpactovalmovele;
$clorcimpactotiporec = new cl_orcimpactotiporec;
$clorcelemento   = new cl_orcelemento;
$clorcimpactomov = new cl_orcimpactomov;
$db_opcao = 22;
$db_botao = false;
if(isset($atualizar)){

  
  db_inicio_transacao();
  $sqlerro = false;
  
  $result = $clorcimpactomov->sql_record($clorcimpactomov->sql_query_compl($o65_codimpmov,"o63_codperiodo,o96_anoini,o96_anofim"));
  db_fieldsmemory($result,0);
  $numrows= $clorcimpactomov->numrows;    





  
  
  for($i=$o96_anoini; $i<= $o96_anofim; $i++){
    $str = "o64_codseqimpmov_".$i; 
    if($sqlerro == true){
      break;
    } 


    //rotina que exclui os registros
      $clorcimpactovalmovmes->sql_record($clorcimpactovalmovmes->sql_query_file($$str)); 
      if($clorcimpactovalmovmes->numrows>0){ 
	$clorcimpactovalmovmes->o65_codseqimpmov = $$str;
	$clorcimpactovalmovmes->excluir($$str);
	$erro_msg = $clorcimpactovalmovmes->erro_msg;  
	if($clorcimpactovalmovmes->erro_status==0){
	  $sqlerro  = true;
	  break;
	}
      }  
    //----------------------------------
    
    for($r=1; $r<13; $r++){
      $c = "o64_valor_".$i."_".$r;  
      $clorcimpactovalmovmes->o65_codseqimpmov = $$str; 
      $clorcimpactovalmovmes->o65_mes       = $r;
      $clorcimpactovalmovmes->o65_valor     = $$c;
      $clorcimpactovalmovmes->incluir($$str,$r);
      $erro_msg = $clorcimpactovalmovmes->erro_msg;  
      if($clorcimpactovalmovmes->erro_status==0){
	$sqlerro  = true;
	break;
      }
    }  
  }
  db_fim_transacao($sqlerro);
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <br>
    <center>
	<?
	include("forms/db_frmorcimpactovalmovmes.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($atualizar)){
//    db_msgbox($erro_msg);
    if($clorcimpacvalmes->erro_campo!=""){
        echo "<script> document.form1.".$clorcimpactovalmovmes->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clorcimpactovalmovmes->erro_campo.".focus();</script>";
    }
}
?>