<?php
/*
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

require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/db_utils.php"));
require_once(modification("libs/db_app.utils.php"));
require_once(modification("libs/db_usuariosonline.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("dbforms/db_classesgenericas.php"));
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?php db_app::load("scripts.js, strings.js, prototype.js,estilos.css, grid.style.css"); ?>
<script type="text/javascript" src="scripts/widgets/DBDownload.widget.js"></script>
</head>
<body bgcolor="#CCCCCC">

  <fieldset style="width: 300px; margin:30px auto 10px auto;">

    <legend><strong>Processar inconsist�ncias dos alunos:</strong></legend>

    <div style="text-align: center">
      <input type="button" name="btnProcessar" id="btnProcessar" value="Processar" onclick="js_processar()"/>
    </div>

  </fieldset>
    
  <?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>

</body>
</html>

<script type="text/javascript">

function js_processar() {
   
  var oParametro               = new Object();  
      oParametro.sExec         = "processar";  
      oParametro.lTabelasAluno = true;

  var oDadosRequest            = new Object();
      oDadosRequest.method     = 'post';
      oDadosRequest.parameters = 'json='+Object.toJSON(oParametro);
      oDadosRequest.onComplete = js_retornoProcessar;

  js_divCarregando("Processando inconsist�ncias...\nAguarde", "msgBox");
  new Ajax.Request ( 'con4_registrosinconsistentes.RPC.php', oDadosRequest ); 
}

function js_retornoProcessar( oResponse ) {

  js_removeObj("msgBox");

  var oRetorno = eval("("+oResponse.responseText+")");
  var sMensagem = oRetorno.sMessage.urlDecode().replace(/\\n/g, "\n");

  if(    oRetorno.lProcessamentoOK
      || !oRetorno.lProcessamentoOK && !oRetorno.lPermiteDownload
    ) {
    alert( sMensagem );
  }

  if( oRetorno.lPermiteDownload && confirm( sMensagem ) ) {
    
    var oDBDownload = new DBDownload();
        oDBDownload.setWindowLabel('Arquivo de Log de Inconsist�ncias')
        oDBDownload.addGroups('log', "Arquivos de Log");
        oDBDownload.addFile(oRetorno.sArquivoLog.urlDecode() + ".txt", 'Clique aqui para baixar o arquivo.', 'log');
        oDBDownload.show();
  }
}

</script>