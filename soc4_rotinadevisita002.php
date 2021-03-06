<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_cidadao_classe.php");
require_once("classes/db_cidadaofamilia_classe.php");
require_once("classes/db_cidadaofamiliavisita_classe.php");

$db_opcao = 2;
?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("prototype.js, scripts.js, strings.js, prototype.maskedinput.js");
    db_app::load("estilos.css");
    ?>
  </head>
  <body bgcolor="#CCCCCC" style="margin-top: 25px;" >
    <center>
      <form method="post" name='form1'>
        <div style="display: table">
          <fieldset>
            <legend><b>Rotina de Visita</b></legend>
            <?php 
              require_once('forms/db_frmrotinavisita.php');
            ?>
          </fieldset>
        </div>
        <input type="button" id="btnSalvarVisita" value="Alterar" onclick="return js_validarCampos(2);" />
        <input type="button" id="btnPesquisar" value="Pesquisar" onclick="js_pesquisaVisita(true);" />
      </form>
    </center>
    <?php
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
  </body>
</html>
<script>
</script>
<?php
if ($db_opcao == 2) {
  echo "<script>document.form1.btnPesquisar.click();</script>";
}
?>