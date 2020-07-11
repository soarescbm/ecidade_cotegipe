<?
//MODULO: pessoal
$clsiope_municipio->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhsm_codigo?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhsm_codigo?>
    </td>
    <td> 
<?
db_input('rhsm_codigo',6,$Irhsm_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsm_uf?>">
       <?=@$Lrhsm_uf?>
    </td>
    <td> 
<?
db_input('rhsm_uf',3,$Irhsm_uf,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsm_muni?>">
       <?=@$Lrhsm_muni?>
    </td>
    <td> 
<?
db_input('rhsm_muni',50,$Irhsm_muni,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_siope_municipio','func_siope_municipio.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_siope_municipio.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
