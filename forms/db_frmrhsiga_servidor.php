<?
//MODULO: pessoal
$clrhsiga_servidor->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhss_id_servidor?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhss_id_servidor?>
    </td>
    <td> 
<?
db_input('rhss_id_servidor',8,$Irhss_id_servidor,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhss_id_cargo?>">
       <?=@$Lrhss_id_cargo?>
    </td>
    <td> 
<?
db_input('rhss_id_cargo',8,$Irhss_id_cargo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhss_id_lotacao?>">
       <?=@$Lrhss_id_lotacao?>
    </td>
    <td> 
<?
db_input('rhss_id_lotacao',8,$Irhss_id_lotacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhss_id_tipo_funcao_siga?>">
       <?=@$Lrhss_id_tipo_funcao_siga?>
    </td>
    <td> 
<?
db_input('rhss_id_tipo_funcao_siga',2,$Irhss_id_tipo_funcao_siga,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhss_tipovinculo?>">
       <?=@$Lrhss_tipovinculo?>
    </td>
    <td> 
<?
db_input('rhss_tipovinculo',1,$Irhss_tipovinculo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_rhsiga_servidor','func_rhsiga_servidor.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_rhsiga_servidor.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
