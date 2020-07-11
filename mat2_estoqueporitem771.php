<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
$clcriaabas = new cl_criaabas;
?>
  <html>
  <head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
     <td>
     <?
       $clcriaabas->identifica = array("g1"=>"Departamentos","g2"=>"Materiais", "g3"=>"Instituições");
       $clcriaabas->title = array("g1"=>"Selecionar Departamentos","g2"=>"Selecionar materiais", "g3"=>"Selecionar Instituições");
       $clcriaabas->src = array("g1"=>"mat2_estoqueporitemnovo771.php","g2"=>"mat2_estoqueporitem002.php", "g3"=>"mat2_estoque003.php");
       $clcriaabas->cria_abas();
     ?> 
     </td>
  </tr>
<tr>
</tr>
</table>


<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
<script>
  document.formaba.g1.size = 25; 
  document.formaba.g2.size = 20;
  document.formaba.g3.size = 20;  
  
</script>
</html>
