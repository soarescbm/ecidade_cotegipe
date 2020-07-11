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
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
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
  if(document.form1.mes_ani.value == ""){
    alert("Informe o mes dos aniversarios.");
  }else if(document.form1.DBtxt23.value == ""){
    alert("Informe o ano para pesquisa.");
  }else{
    qry = "?ano=" + document.form1.DBtxt23.value;
    qry+= "&mes=" + document.form1.DBtxt25.value;
    qry+= "&mes_ani=" + document.form1.mes_ani.value;
    qry+= "&lotaini=" + document.form1.DBtxt27.value;
    qry+= "&lotafim=" + document.form1.DBtxt28.value;
    if(document.form1.listainativ.checked == true){
      qry+= "&listainativo=s";
    }
    if(document.form1.listapens.checked == true){
      qry+= "&listapens=s";
    }
    jan = window.open('pes2_aniversariantesmes002.php'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
  }
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

  <table align="center">
    <form name="form1" method="post" action="">
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <tr >
        <td align="left" nowrap title="Digite o Ano / Mes de compet�ncia" >
        <strong>Ano / M�s :&nbsp;&nbsp;</strong>
        </td>
        <td>
          <?
           $DBtxt23 = db_anofolha();
           db_input('DBtxt23',4,$IDBtxt23,true,'text',2,'')
          ?>
          &nbsp;/&nbsp;
          <?
           $DBtxt25 = db_mesfolha();
           db_input('DBtxt25',2,$IDBtxt25,true,'text',2,'')
          ?>
        </td>
      </tr>
      <tr> 
        <td align="right" nowrap ><strong>Secretaria Inicial</strong>
        </td>
        <td>
          <?
            db_input('DBtxt27',4,$IDBtxt27,true,'text',2,'')
          ?>
	</td>
      </tr>
      <tr> 
        <td align="right" nowrap > <strong>Secretaria Final</strong>
        </td>
        <td>
          <?
            db_input('DBtxt28',4,$IDBtxt28,true,'text',2,'')
          ?>
	</td>
      </tr>
      <tr> 
        <td align="right" nowrap > <strong>M�s</strong>
        </td>
        <td>
          <?
            db_input('mes_ani',4,$IDBtxt25,true,'text',2,'')
          ?>
	</td>
      </tr>
      <td align="left">
            <input type="checkbox" name="listainativ" value="listainativ">Listar inativos
        </td>
      <tr>
        <td align="left">
	    <input type="checkbox" name="listapens" value="listapens">Listar pensionistas
	 </td>
				  
	
	
	<td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align = "center"> 
          <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
        </td>
      </tr>

  </form>
    </table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>