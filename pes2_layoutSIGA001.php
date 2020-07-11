<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
include("dbforms/db_funcoes.php");
include("classes/db_inssirf_classe.php");
include("classes/db_rhcadregime_classe.php");
$clrotulo = new rotulocampo;
$clinssirf = new cl_inssirf;
$clrhcadrefime = new cl_rhcadregime;
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>


function js_emite(){
  //js_controlarodape(true);
  qry  = 'xano='+ document.form1.xano.value;
  qry += '&xmes='+ document.form1.xmes.value;
  js_OpenJanelaIframe('top.corpo','db_iframe_geraSIGA','pes2_layoutSIGA002.php?'+qry,'Gerando Arquivo',false);
}

function js_erro(msg){
  //js_controlarodape(false);
  top.corpo.db_iframe_geraSIGA.hide();
  alert(msg);
}
function js_fechaiframe(){
  db_iframe_geraSIGA.hide();
}
function js_controlarodape(mostra){
  if(mostra == true){
    document.form1.rodape.value = parent.bstatus.document.getElementById('st').innerHTML;
    parent.bstatus.document.getElementById('st').innerHTML = '&nbsp;&nbsp;<blink><strong><font color="red">GERANDO ARQUIVO</font></strong></blink>' ;
  }else{
    parent.bstatus.document.getElementById('st').innerHTML = document.form1.rodape.value;
  }
}
function js_detectaarquivo(arquivo,pdf,arquivo2,pdf2){
  //  js_controlarodape(false);
  top.corpo.db_iframe_geraSIGA.hide();
  listagem = arquivo+"#Download salario2 TXT|";
  listagem+= pdf+"#Download salario2 PDF|";

  listagem+= arquivo2+"#Download pessoal TXT|";
  //listagem+= pdf2+"#Download pessoal PDF";

  js_montarlista(listagem,"form1");
}

</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

  <table  align="center">
    <form name="form1" method="post" action="" >
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <table align="center">
        <tr >
            <td align="right" nowrap title="Digite o Ano / Mes " >
              <strong>Ano / Mês:</strong>
            </td>
            <td align="left">
              <?
              $xano = db_anofolha() ;
              db_input('xano',4,'',true,'text',2,'')
              ?>
              &nbsp;/&nbsp;
              <?
              $xmes = db_mesfolha();
              db_input('xmes',2,'',true,'text',2,'')
              ?>
            </td>
        </tr>
      </table>
      <table align="center">
        <tr>
	        <td colspan="2" align = "center"> 
            <input  name="gera" id="gera" type="button" value="Gerar" onclick="js_emite();" >
          </td>
        </tr>
      </table>
    </form>
   </table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>