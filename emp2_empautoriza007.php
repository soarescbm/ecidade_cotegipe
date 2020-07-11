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
include("libs/db_usuariosonline.php");
include("classes/db_caracter_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_db_config_classe.php");
$cldb_config = new cl_db_config;
$cliframe_seleciona = new cl_iframe_seleciona;
$clrotulo = new rotulocampo;
$cldb_config->rotulo->label();
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
      <center>
        <form name="form1" method="post" action="cad2_iptuconstr002.php" target="rel">
           <center>
             <table border="0">
	       <tr>
	         <td height="2%">
		 </td>
	       </tr>
	       <tr>
                 <td align="left" colspan="3">
                   <table>
                     <tr>
	               <td valign='center' nowrap align="left" colspan="1" title="<?=@$Tcodigo?>">
	               <strong>Institui��es de</strong>
		       </td>
		       <td valign='center'>      
		     <?
                 db_input('codigo',8,$Icodigo,true,'text',1,"onChange=\"js_testa('i',this.value)\"","codigoINI","");
	             ?>
		       <strong>&nbsp;�&nbsp;</strong>
		     <?
		 db_input('codigo',8,$Icodigo,true,'text',1,"onChange=\"js_testa('f',this.value)\"","codigoFIM","");
		     ?>
		       </td>
                     </tr>
                   </table>
	         </td>
	       </tr>
	       <tr>
		 <td colspan="3" align="center">
		   <table>
		     <tr>
		       <td align="center">
			  <?
			  $aux = new cl_arquivo_auxiliar;
			  $aux->cabecalho = "<strong>INSTITUI��ES</strong>";
			  $aux->codigo = "codigo";
			  $aux->descr  = "nomeinst";
			  $aux->nomeobjeto = 'db_config';
			  $aux->funcao_js = 'js_mostra';
			  $aux->funcao_js_hide = 'js_mostra1';
			  $aux->sql_exec  = "";
			  $aux->func_arquivo = "func_db_config.php";
			  $aux->nomeiframe = "db_iframe";
			  $aux->localjan = "";
			  $aux->db_opcao = 2;
			  $aux->tipo = 2;
			  $aux->top = 2;
			  $aux->linhas = 10;
			  $aux->vwhidth = 400;
			  $aux->funcao_gera_formulario();
			  ?>
		       </td>
		     </tr>
		   </table>
		 </td>
	       </tr>
               <tr>
	         <td align="right"> <strong>Op��o de Sele��o :<strong></td>
		 <td align="left">&nbsp;&nbsp;&nbsp;
		   <?
		   $xxx = array("S"=>"Somente Selecionados","N"=>"Menos os Selecionados");
		   db_select('param_db_config',$xxx,true,2);		   
		   ?>
		 </td>
	       </tr>
	     </table>
	   </center>
	 </form>
       </center>
     </td>
   </tr>
</table>
</body>
<script>
function js_testa(campo,valor){
  msg = "Informe um intervalo de c�digo v�lido!";
  erro = false;
  if(campo=="i"){
    if(document.form1.codigoFIM.value!="" && parseInt(valor)>=parseInt(document.form1.codigoFIM.value)){
      erro=true;
    }
  }else if(campo=="f"){
    if(document.form1.codigoINI.value!="" && parseInt(valor)<=parseInt(document.form1.codigoINI.value)){
      erro=true;
    }
  }
  if(erro==true){
    alert(msg);
    document.form1.codigoINI.value="";
    document.form1.codigoFIM.value="";
    document.form1.codigoINI.focus();
  }
}
</script>
</html>