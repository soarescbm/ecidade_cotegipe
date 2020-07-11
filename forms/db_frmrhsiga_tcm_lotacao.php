<?
//MODULO: pessoal
$clrhsiga_tcm_lotacao->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhstl_codigo?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhstl_codigo?>
    </td>
    <td> 
<?
db_input('rhstl_codigo',2,$Irhstl_codigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhstl_descricao?>">
       <?=@$Lrhstl_descricao?>
    </td>
    <td> 
<?
db_input('rhstl_descricao',50,$Irhstl_descricao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhstl_orgao_sigla?>">
       <?=@$Lrhstl_orgao_sigla?>
    </td>
    <td> 
<?
db_input('rhstl_orgao_sigla',1,$Irhstl_orgao_sigla,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhstl_tipo_secretaria?>">
       <?=@$Lrhstl_tipo_secretaria?>
    </td>
    <td> 
<?
db_input('rhstl_tipo_secretaria',1,$Irhstl_tipo_secretaria,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_rhsiga_tcm_lotacao','func_rhsiga_tcm_lotacao.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_rhsiga_tcm_lotacao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
