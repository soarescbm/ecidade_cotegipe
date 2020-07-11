<?
//MODULO: pessoal
$clrhsiga_tcm_cargo->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhstc_codigo?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhstc_codigo?>
    </td>
    <td> 
<?
db_input('rhstc_codigo',8,$Irhstc_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhstc_descricao?>">
       <?=@$Lrhstc_descricao?>
    </td>
    <td> 
<?
db_input('rhstc_descricao',50,$Irhstc_descricao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhstc_tipocargo?>">
       <?=@$Lrhstc_tipocargo?>
    </td>
    <td> 
<?
db_input('rhstc_tipocargo',1,$Irhstc_tipocargo,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_rhsiga_tcm_cargo','func_rhsiga_tcm_cargo.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_rhsiga_tcm_cargo.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
