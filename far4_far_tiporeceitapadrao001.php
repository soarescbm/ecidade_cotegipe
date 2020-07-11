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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");
require_once("libs/db_utils.php");

db_postmemory($HTTP_POST_VARS);
$oDaofar_tiporeceitapadrao = db_utils::getdao('far_tiporeceitapadrao');
$oDaofar_tiporeceita = db_utils::getdao('far_tiporeceita');
$oIframeAE = new cl_iframe_alterar_excluir();

$db_opcao = 1;
$db_botao = true;

if(isset($opcao)) {
  
  if($opcao == 'alterar') {
    $db_opcao = 2;
  } else {
    $db_opcao = 3;
  }

}

if(isset($incluir)) {

  db_inicio_transacao();
  $oDaofar_tiporeceitapadrao->incluir($fa42_i_codigo);
  db_fim_transacao($oDaofar_tiporeceitapadrao->erro_status == '0' ? true : false);

}
if(isset($alterar)) {

  $db_opcao = 2;
  $opcao = 'alterar';
  db_inicio_transacao();
  $oDaofar_tiporeceitapadrao->alterar($fa42_i_codigo);
  db_fim_transacao($oDaofar_tiporeceitapadrao->erro_status == '0' ? true : false);

}
if(isset($excluir)) {

  $db_opcao = 3;
  $opcao = 'excluir';
  db_inicio_transacao();
  $oDaofar_tiporeceitapadrao->excluir($fa42_i_codigo);
  db_fim_transacao($oDaofar_tiporeceitapadrao->erro_status == '0' ? true : false);

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
<br>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
      <fieldset style='width: 75%;'> <legend><b>Tipo de Receita Padr�o</b></legend>
	      <?
        require_once("forms/db_frmfar_tiporeceitapadrao.php");
        ?>
      </fieldset>
    </center>
	</td>
  </tr>
</table>
</center>
<?
//db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","fa42_i_tiporeceita",true,1,"fa42_i_tiporeceita",true);
</script>
<?
if(isset($incluir) || isset($alterar) || isset($excluir)) {

  if($oDaofar_tiporeceitapadrao->erro_status == '0') {

    $oDaofar_tiporeceitapadrao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script> ";
    if($oDaofar_tiporeceitapadrao->erro_campo != '') {

      echo "<script> document.form1.".$oDaofar_tiporeceitapadrao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$oDaofar_tiporeceitapadrao->erro_campo.".focus();</script>";

    }

  } else {
    $oDaofar_tiporeceitapadrao->erro(true,true);
  }

}
?>