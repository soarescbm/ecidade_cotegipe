<?
//MODULO: pessoal
$clsiope_pessoas->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trhsp_regist?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lrhsp_regist?>
    </td>
    <td> 
<?
db_input('rhsp_regist',9,$Irhsp_regist,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsp_categoria_profissional?>">
       <?=@$Lrhsp_categoria_profissional?>
    </td>
    <td> 
<?
db_input('rhsp_categoria_profissional',3,$Irhsp_categoria_profissional,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsp_local_trabalho?>">
       <?=@$Lrhsp_local_trabalho?>
    </td>
    <td> 
<?
db_input('rhsp_local_trabalho',8,$Irhsp_local_trabalho,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsp_fundeb60?>">
       <?=@$Lrhsp_fundeb60?>
    </td>
    <td> 
<?
$x = array('N'=>'','S'=>'');
db_select('rhsp_fundeb60',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsp_fundeb40?>">
       <?=@$Lrhsp_fundeb40?>
    </td>
    <td> 
<?
$x = array('N'=>'','S'=>'');
db_select('rhsp_fundeb40',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trhsp_recproc?>">
       <?=@$Lrhsp_recproc?>
    </td>
    <td> 
<?
$x = array('N'=>'','S'=>'');
db_select('rhsp_recproc',$x,true,$db_opcao,"");
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
  js_OpenJanelaIframe('top.corpo','db_iframe_siope_pessoas','func_siope_pessoas.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_siope_pessoas.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
