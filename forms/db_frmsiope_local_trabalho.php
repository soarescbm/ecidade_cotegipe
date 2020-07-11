<?
//MODULO: pessoal
$clsiope_local_trabalho->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhslt_escola?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhslt_escola?>
    </td>
    <td> 
<?
db_input('rhslt_escola',8,$Irhslt_escola,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhslt_municipio?>">
       <?=@$Lrhslt_municipio?>
    </td>
    <td> 
<?
db_input('rhslt_municipio',6,$Irhslt_municipio,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhslt_nomeescola?>">
       <?=@$Lrhslt_nomeescola?>
    </td>
    <td> 
<?
db_input('rhslt_nomeescola',100,$Irhslt_nomeescola,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_siope_local_trabalho','func_siope_local_trabalho.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_siope_local_trabalho.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
