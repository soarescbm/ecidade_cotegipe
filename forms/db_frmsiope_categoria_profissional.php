<?
//MODULO: pessoal
$clsiope_categoria_profissional->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhscp_codigo?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhscp_codigo?>
    </td>
    <td> 
<?
db_input('rhscp_codigo',3,$Irhscp_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhscp_tipo?>">
       <?=@$Lrhscp_tipo?>
    </td>
    <td> 
<?
db_input('rhscp_tipo',3,$Irhscp_tipo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhscp_nome?>">
       <?=@$Lrhscp_nome?>
    </td>
    <td> 
<?
db_input('rhscp_nome',255,$Irhscp_nome,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_siope_categoria_profissional','func_siope_categoria_profissional.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_siope_categoria_profissional.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
