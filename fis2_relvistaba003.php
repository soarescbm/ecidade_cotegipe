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
include("classes/db_db_usuarios_classe.php");
include("classes/db_empnota_classe.php");
$cldb_usuarios = new cl_db_usuarios;
$clempnota = new cl_empnota;
$cliframe_seleciona = new cl_iframe_seleciona;
$aux = new cl_arquivo_auxiliar;
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("q03_descr");
$clrotulo->label("j14_nome");
$clrotulo->label("j13_descr");
$clrotulo->label("j13_codi");
$clrotulo->label("y76_codvist");
$clrotulo->label("y70_id_usuario");
$clrotulo->label("y70_data");
$clrotulo->label("y70_tipovist");
$clrotulo->label("y77_descricao");
$clrotulo->label("y70_numbloco");
$clrotulo->label("y10_codigo");
$clrotulo->label("y10_codi");
$clrotulo->label("y11_codigo");
$clrotulo->label("y11_codi");
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
        <form name="form1" method="post" action="" target="">
           <center>
             <table border="0">
	       <tr>
	         <td height="2%">
		 </td>
	       </tr>
	       <tr>
                 <td align="left" colspan="3">
                   <table>
                   </table>
	         </td>
	       </tr>
	       <tr>
		 <td colspan="3" align="center">
		   <table>
		       <tr> 
          	        <td  align="center">
               		  <strong>Op��es:</strong>
               		  <select name="ver">
                   		 <option name="condicao3" value="com">Com os bairros selecionados</option>
                   		 <option name="condicao3" value="sem">Sem os bairros selecionados</option>
                	  </select>
          		</td>
       		       </tr>
		     <tr>
		       <td align="center">
			  <?
			    $aux->cabecalho = "<strong>Bairro da execu��o da vistoria</strong>";
			    $aux->codigo = "j13_codi";
			    $aux->descr  = "j13_descr";
			    $aux->nomeobjeto = 'bairro';
			    $aux->funcao_js = 'js_mostra';
			    $aux->funcao_js_hide = 'js_mostra1';
			    $aux->sql_exec  = "";
			    $aux->func_arquivo = "func_bairro.php";
			    $aux->nomeiframe = "iframe_bairros";
			    $aux->localjan = "";
			    $aux->db_opcao = 2;
			    $aux->tipo = 2;
			    $aux->linhas = 10;
			    $aux->vwhidth = 400;
  			    $aux->funcao_gera_formulario();			    
			  ?>
		       </td>
		     </tr>
		     <tr>
		       <td>
		       </td>
	             </tr>
		   </table>
		 </td>
	       </tr>
		 
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
</script>
</html>