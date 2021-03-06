<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
require_once("classes/db_db_confplan_classe.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

$cldb_confplan = new cl_db_confplan();
$db_opcao      = 22;
$db_botao      = false;

if ((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Alterar") {

  db_inicio_transacao();
  $db_opcao = 2;
  $cldb_confplan->alterar($oid);
  db_fim_transacao();
} else if (isset($chavepesquisa)) {

   $db_opcao = 2;
   $result   = $cldb_confplan->sql_record($cldb_confplan->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);
   $db_botao = true;
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
<body>
<div class="container">
  <?php
    include("forms/db_frmdb_confplan.php");
  ?>
</div>
<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?php
if ($db_opcao == 22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}

if ($cldb_confplan->erro_status == "0") {

  $cldb_confplan->erro(true, false);
  $db_botao = true;

  echo "<script> document.form1.db_opcao.disabled=false;</script>";

  if ($cldb_confplan->erro_campo != "") {

    echo "<script> document.form1.{$cldb_confplan->erro_campo}.style.backgroundColor='#99A9AE';</script>";
    echo "<script> document.form1.{$cldb_confplan->erro_campo}.focus();</script>";
  }
} else {
  $cldb_confplan->erro(true, true);
}
?>