<?
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

include(modification("fpdf151/pdf.php"));
include(modification("libs/db_libpessoal.php"));
include(modification("dbforms/db_funcoes.php"));

$oParametros = db_utils::postMemory($_GET);
db_inicio_transacao();

$oCompetencia       = new DBCompetencia($oParametros->xano, $oParametros->xmes);

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <br><br><br>
</body>
<?


try {

  $aCamposConfig   = array();
  $aCamposConfig[] = "numero";
  $aCamposConfig[] = "ender";
  $aCamposConfig[] = "cgc";
  $aCamposConfig[] = "nomeinst";
  $aCamposConfig[] = "bairro";
  $aCamposConfig[] = "cep";
  $aCamposConfig[] = "munic";
  $aCamposConfig[] = "uf";
  $aCamposConfig[] = "telef";
  $aCamposConfig[] = "email";
  $aCamposConfig[] = "lower(trim(munic)) as d08_carnes";
  $aCamposConfig[] = "cgc";
  $sCamposConfig = implode(",", $aCamposConfig);

  $sWhereConfig = "codigo = ". db_getsession("DB_instit");

  $sSqlConfig = "SELECT {$sCamposConfig} FROM db_config WHERE {$sWhereConfig}";
  $rsConfig   = db_query($sSqlConfig);

  if(!$rsConfig) {
    throw new Exception("Ocorreu um erro ao consultar os dados da instituição.");
  }

  $oDadosConfig = db_utils::makeFromRecord($rsConfig, function($oConfig){
    return $oConfig;
  }, 0);

  $d08_ender  = $oDadosConfig->ender;
  $d08_cgc    = $oDadosConfig->cgc;
  $d08_nome   = $oDadosConfig->nomeinst;
  $d08_bairro = $oDadosConfig->bairro;
  $d08_cep    = $oDadosConfig->cep; // Esse está sendo usado
  $d08_munic  = $oDadosConfig->munic;
  $d08_uf     = $oDadosConfig->uf; // Esse está sendo usado
  $d08_telef  = $oDadosConfig->telef;
  $d08_email  = $oDadosConfig->email;
  $d08_numero = $oDadosConfig->numero;

  if(trim($oDadosConfig->cgc) == "90940172000138"){
    $d08_carnes = "daeb";
  }else{
    $d08_carnes = $oDadosConfig->d08_carnes;
  }

  $nomearq = "/tmp/layout_SIOPE.csv";
  $nomepdf = "/tmp/layout_SIOPE.pdf";

  emite_layoutSIOPE($nomearq, $nomepdf, $oCompetencia);
  echo "<script>parent.js_detectaarquivo('$nomearq','$nomepdf');</script>";
  db_redireciona("pes2_layoutSIOPE001.php");
} catch (Exception $e) {
  db_msgbox($e->getMessage());
}

db_fim_transacao();

function queryServidores($nomearq, $oCompetencia) {

  $result_princ = db_query("SELECT 
    rhsp_regist, 
    rhsp_categoria_profissional, 
    rhsp_local_trabalho, 
    rhsp_fundeb60,
    rhsp_fundeb40,
    rhsp_recproc,

    -- rhpessoalmov
    rh02_hrssem,
    rh02_tpcont,
    
    -- cgm
    z01_nome,
    z01_cgccpf,

    -- categoria do profissional
    rhscp_tipo,
    rhscp_nome

    FROM siope_pessoas

    INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = siope_pessoas.rhsp_regist and rhpessoalmov.rh02_anousu = ".$oCompetencia->getAno()." and rhpessoalmov.rh02_mesusu = ".$oCompetencia->getMes()."
    INNER JOIN rhpessoal ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist 
    INNER JOIN protocolo.cgm ON cgm.z01_numcgm = rh01_numcgm
    INNER JOIN siope_categoria_profissional ON siope_categoria_profissional.rhscp_codigo = rhsp_categoria_profissional
    
    ORDER BY z01_nome ASC");
  

  return $result_princ;
}


// Uemerson Santana
function formatMes ($mes_num) {
  if($mes_num == 01){
    $mes_nome = "Janeiro";
  }elseif($mes_num == 02){
    $mes_nome = "Fevereiro";
  }elseif($mes_num == 03){
    $mes_nome = "Março";
  }elseif($mes_num == 04){
    $mes_nome = "Abril";
  }elseif($mes_num == 05){
    $mes_nome = "Maio";
  }elseif($mes_num == 06){
    $mes_nome = "Junho";
  }elseif($mes_num == 07){
    $mes_nome = "Julho";
  }elseif($mes_num == 08){
    $mes_nome = "Agosto";
  }elseif($mes_num == 09){
    $mes_nome = "Setembro";
  }elseif($mes_num == 10){
    $mes_nome = "Outubro";
  }elseif($mes_num == 11){
    $mes_nome = "Novembro";
  }else{
    $mes_nome = "Dezembro";
  }
  return $mes_nome;
}
function maskCPF($mask,$str){

    $str = str_replace(" ","",$str);

    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }

    return $mask;

}
//---

function emite_layoutSIOPE($nomearq, $nomepdf, DBCompetencia $oCompetencia, $oParametros, $sSeparador = ';') {

  $ano        = db_str($oCompetencia->getAno(),4);
  $mes        = db_str($oCompetencia->getMes(),2,0,"0");

  $rsDadosServidores = queryServidores($nomearq, $oCompetencia);

  $pdf = new PDF('L');
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->setfillcolor(235);
  $pdf->setfont('arial','b',8);
  $troca = 1;
  $alt   = 4;

  global $head2;
  $head2 = "RELATORIO SIOPE";
  $head3 = "COMPETENCIA: ".$oCompetencia->getAno().'/'.db_str($oCompetencia->getMes(),2,0,"0")."-".formatMes(db_str($oCompetencia->getMes(),2,0,"0"));


  $arquivo = fopen($nomearq,"w");

  $sLinha .= "T;Dados Gerais \ Remuneração dos Profissionais de Educação \ ".db_str($oCompetencia->getMes(),2,0,"0")."-".formatMes(db_str($oCompetencia->getMes(),2,0,"0"))."";
  
  $sLinha .= PHP_EOL;
  fputs($arquivo,$sLinha);
  $sLinha = '';
  

  $f60 = 0;
  $f40 = 0;
  $rec = 0;


  $aDadosServidores = array();
  $aDadosServidores = db_utils::makeCollectionFromRecord($rsDadosServidores, function($oItemServidor){
    return $oItemServidor;
  });

  $pdf->addpage();
  $pdf->setfont('arial','b',8);
  $troca = 0;
  $pdf->cell(25,$alt,"CPF ",0,0,"L",0);
  
  $pdf->cell(125,$alt,"Nome  ",0,0,"L",0);
  $pdf->cell(25,$alt,"Base. ",0,0,"L",0);
  $pdf->cell(25,$alt,"Fundeb 60%",0,0,"L",0);
  $pdf->cell(25,$alt,"Fundeb 40%",0,0,"L",0);
  $pdf->cell(25,$alt,"Rec. Prop",0,0,"L",0);
  $pdf->cell(25,$alt,"Total",0,0,"L",0);
  $pdf->Ln(8);

  foreach ($aDadosServidores as $oDadosServidor) {

    $cadastrou++;

    //$oServidor = ServidorRepository::getInstanciaByCodigo($oDadosServidor->rhsp_regist);
    $aLinhas   = array();
    $sLinha    = '';

    $nTotalValoresServidor  = 0;
    $nTotalValoresServidor += $oDadosServidor->rhsp_regist;

    if($nTotalValoresServidor == 0) {
      continue;
    }

    //  Destroi variável para envitar que afete o valor do novo registro.
    unset($valor1,$valor2,$valorSalario);

    //  Pega somente os proventos: r14_pd=1(provento)
    $gerfsal  = "SELECT r14_regist, r14_valor, r14_rubric FROM gerfsal WHERE r14_anousu = ".$oCompetencia->getAno()." and r14_mesusu = ".$oCompetencia->getMes()." and r14_regist = $oDadosServidor->rhsp_regist and r14_pd = 1";
    $rsgerfsal         =  db_query($gerfsal);
    $iLinhasGerfsal    =  pg_num_rows( $rsgerfsal );
    for( $iCont2=0; $iCont2<$iLinhasGerfsal; $iCont2++ ){
        $ogerfsal = db_utils::fieldsmemory($rsgerfsal, $iCont2);
        if ( $ogerfsal->r14_rubric == '0001' ) {
            $valorSalario = $ogerfsal->r14_valor;
        }
        $valor1 = $valor1 + $ogerfsal->r14_valor;
    }

    //  Pega somente os proventos: r48_pd=1(provento)
    $gerfcom  = "SELECT r48_regist, r48_valor FROM gerfcom WHERE r48_anousu = ".$oCompetencia->getAno()." and r48_mesusu = ".$oCompetencia->getMes()." and r48_regist = $oDadosServidor->rhsp_regist and r48_pd = 1";
    $rsgerfcom         =  db_query($gerfcom);
    $iLinhasGerfcom    =  pg_num_rows($rsgerfcom);
    for( $iCont3=0; $iCont3<$iLinhasGerfcom; $iCont3++ ){
        $ogerfcom = db_utils::fieldsmemory($rsgerfcom, $iCont3);
        
        $valor2 = $valor2 + $ogerfcom->r48_valor;
    }

    //  caso o servidor tenha somente a nota complementar.
    if ( $valorSalario <= 0 ) {
      $valorSalario = $valor2;
    }
    //---
/*
    I;0;12;00608324523;ABENILIO TAVARES DA CAMARA JUNIOR;29335981;GRUPO ESCOLAR BARAO DE COTEGIPE;40;2;OUTROS PROFISSIONAIS;15;PROFISSIONAIS QUE EXERCEM FUNCOES DE SECRETARIA ESCOLAR, ALIMENTACAO ESCOLAR (MERENDEIRAS), MULTIMEIOS DIDATICOS E INFRAESTRUTURA;1033,05;0,00;1236,36;0,00;1236,36
*/
    $aLinhas[] =  'I';
    $aLinhas[] =  '0';
    $aLinhas[] =  intval($oCompetencia->getMes());
    $aLinhas[] =  $oDadosServidor->z01_cgccpf;
    $aLinhas[] =  $oDadosServidor->z01_nome;

    $descLocal   = "SELECT * FROM siope_local_trabalho WHERE siope_local_trabalho.rhslt_escola = '$oDadosServidor->rhsp_local_trabalho' and rhslt_municipio = 290940";
    $rsdescLocal  = db_query($descLocal);
    $odescLocal   = db_utils::fieldsmemory($rsdescLocal, 0);

    $aLinhas[] =  $oDadosServidor->rhsp_local_trabalho;
    $aLinhas[] =  $odescLocal->rhslt_nomeescola;

    $aLinhas[] =  $oDadosServidor->rh02_hrssem;
    $aLinhas[] =  $oDadosServidor->rhscp_tipo;

    if ( $oDadosServidor->rhscp_tipo == 1 ) {
        $aLinhas[] =  'PROFISSIONAIS DO MAGISTÉRIO';
    } else {
        $aLinhas[] =  'OUTROS PROFISSIONAIS';
    }
    
    $aLinhas[] =  $oDadosServidor->rhsp_categoria_profissional;
    $aLinhas[] =  $oDadosServidor->rhscp_nome;

    if ( $oDadosServidor->rh02_tpcont == 7 ) {
      $aLinhas[] = 1;
      $aLinhas[] = 'Efetivo';
    } else if ( $oDadosServidor->rh02_tpcont == 4 ) {
      $aLinhas[] = 2;
      $aLinhas[] = 'Temporário';
    } else {
      $aLinhas[] = 4;
      $aLinhas[] = 'Outros';
    }

    $aLinhas[] =  str_replace('.', ',', $valorSalario);

    // Fundeb 60%
    if ( $oDadosServidor->rhsp_fundeb60 == 'S' ) {
        $aLinhas[] =  str_replace('.', ',', ($valor1+$valor2));
        $total60 = $total60 + ($valor1+$valor2);
        $f60++;
    } else {
        $aLinhas[] =  '0';
    }
    // Fundeb 40%
    if ( $oDadosServidor->rhsp_fundeb40 == 'S' ) {
        $aLinhas[] =  str_replace('.', ',', ($valor1+$valor2));
        $total40 = $total40 + ($valor1+$valor2);
        $f40++;
    } else {
        $aLinhas[] =  '0';
    }
    // Rec. Prop.
    if ( $oDadosServidor->rhsp_recproc == 'S' ) {
        $aLinhas[] =  str_replace('.', ',', ($valor1+$valor2));
        $totalrec = $totalrec + ($valor1+$valor2);
        $rec++;
    } else {
        $aLinhas[] =  '0';
    }
    

    $aLinhas[] =  str_replace('.', ',', ($valor1+$valor2));
    
    $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
    fputs($arquivo, $sLinha);

    $pdf->cell(25,$alt,maskCPF("###.###.###-##",$oDadosServidor->z01_cgccpf),0,0,"L",0);
    $pdf->cell(125,$alt,db_substr($oDadosServidor->z01_nome,1,30),0,0,"L",0);
    $pdf->cell(25,$alt,db_formatar($valorSalario,'f') ,0,0,"L",0);
    if ( $oDadosServidor->rhsp_fundeb60 == 'S' ) {
        $pdf->cell(25,$alt,db_formatar(($valor1+$valor2),'f') ,0,0,"L",0);
    } else {
        $pdf->cell(25,$alt,db_formatar(0,'f') ,0,0,"L",0);
    }
    if ( $oDadosServidor->rhsp_fundeb40 == 'S' ) {
        $pdf->cell(25,$alt,db_formatar(($valor1+$valor2),'f') ,0,0,"L",0);
    } else {
        $pdf->cell(25,$alt,db_formatar(0,'f') ,0,0,"L",0);
    }
    if ( $oDadosServidor->rec_proc == 'S' ) {
        $pdf->cell(25,$alt,db_formatar(($valor1+$valor2),'f') ,0,0,"L",0);
    } else {
        $pdf->cell(25,$alt,db_formatar(0,'f') ,0,0,"L",0);
    }
    $pdf->cell(25,$alt,db_formatar(($valor1+$valor2),'f') ,0,0,"L",0);
    
    $pdf->Ln(5);
  }



  

  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(125,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'TOTAIS SERVIDORES',0,0,"R",0);
  $pdf->cell(25,$alt,$f60,0,0,"L",0);
  $pdf->cell(25,$alt,$f40,0,0,"L",0);
  $pdf->cell(25,$alt,$rec,0,0,"L",0);
  $pdf->cell(25,$alt,$cadastrou,0,0,"L",0);

  $pdf->ln(5);

  //$pdf->SetFont('','',8);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(125,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'TOTAIS',0,0,"R",0);
  $pdf->cell(25,$alt,db_formatar( $total60,'f' ),0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar( $total40,'f' ),0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar( $totalrec,'f'),0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar( ($total60+$total40+$totalrec) ,'f' ),0,0,"L",0);

  $pdf->Output($nomepdf,false,true);
  fclose($arquivo);
}

