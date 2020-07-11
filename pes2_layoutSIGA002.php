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

function inteiro_decimal_br($numero)
{
    $numero = number_format($numero, 2, '', ''); 
    return $numero;
}


function tratamentoData($data) {
  $ano = substr($data, 0, 4);
  $mes = substr($data, 5, 2);
  $dia = substr($data, 8, 2);

  return $dia.$mes.$ano;
}

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

  $ano        = db_str($oCompetencia->getAno(),4);
  $mes        = db_str($oCompetencia->getMes(),2,0,"0");

  $nomearq = "/tmp/salario2_".$ano.$mes.".txt";
  $nomepdf = "/tmp/salario2_".$ano.$mes.".pdf";

  $nomearq2 = "/tmp/pessoal_".$ano.$mes.".txt";
  $nomepdf2 = "/tmp/pessoal_".$ano.$mes.".pdf";


  emite_layout_salario2($nomearq, $nomepdf, $oCompetencia);
  emite_layout_pessoal($nomearq2, $nomepdf2, $oCompetencia);
  echo "<script>
    parent.js_detectaarquivo('$nomearq','$nomepdf','$nomearq2','$nomepdf2');
  </script>";
  db_redireciona("pes2_layoutSIGA001.php");
} catch (Exception $e) {
  db_msgbox($e->getMessage());
}

db_fim_transacao();

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

function emite_layout_salario2($nomearq, $nomepdf, DBCompetencia $oCompetencia, $oParametros, $sSeparador = '') {

  $ano        = db_str($oCompetencia->getAno(),4);
  $mes        = db_str($oCompetencia->getMes(),2,0,"0");

  $rsDadosServidores = db_query("SELECT * FROM rhpessoalmov 
      LEFT JOIN rhpessoal ON rh01_regist = rh02_regist
      LEFT JOIN cgm ON z01_numcgm = rhpessoal.rh01_numcgm
      INNER JOIN rhsiga_servidor ON rhsiga_servidor.rhss_id_servidor = rhpessoalmov.rh02_regist
      LEFT JOIN rhsiga_tcm_cargo ON rhsiga_tcm_cargo.rhstc_codigo = rhsiga_servidor.rhss_id_cargo
      LEFT JOIN rhsiga_tipofuncao ON rhsiga_tipofuncao.rhstif_codigo = rhsiga_servidor.rhss_id_tipo_funcao_siga

    WHERE rh02_anousu = ".$oCompetencia->getAno()." and rh02_mesusu = ".$oCompetencia->getMes()." ORDER BY z01_nome ASC");


  $pdf = new PDF('L');
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->setfillcolor(235);
  $pdf->setfont('arial','b',8);
  $troca = 1;
  $alt   = 4;

  global $head2;
  $head2 = "RELATORIO SIGA";
  $head3 = "COMPETENCIA: ".$oCompetencia->getAno().'/'.db_str($oCompetencia->getMes(),2,0,"0")."-".formatMes(db_str($oCompetencia->getMes(),2,0,"0"));


  $arquivo = fopen($nomearq,"w");

  //$sLinha .= "T;Dados Gerais \ Remuneração dos Profissionais de Educação \ ".db_str($oCompetencia->getMes(),2,0,"0")."-".formatMes(db_str($oCompetencia->getMes(),2,0,"0"))."";
  
  //$sLinha .= PHP_EOL;
  //fputs($arquivo,$sLinha);
  //$sLinha = '';


  $aDadosServidores = array();
  $aDadosServidores = db_utils::makeCollectionFromRecord($rsDadosServidores, function($oItemServidor){
    return $oItemServidor;
  });

  $pdf->addpage();
  $pdf->setfont('arial','b',8);
  $troca = 0;
  
  $pdf->cell(125,$alt,"Servidor ",0,0,"L",0);
  $pdf->cell(25,$alt,"Bruto",0,0,"L",0);
  $pdf->cell(25,$alt,"Base",0,0,"L",0);
  $pdf->cell(25,$alt,"13",0,0,"L",0);
  $pdf->cell(25,$alt,"Outros. Desc.",0,0,"L",0);
  $pdf->cell(25,$alt,"INSS",0,0,"L",0);
  $pdf->cell(25,$alt,"I.R.",0,0,"L",0);
  $pdf->Ln(8);

  $Ptotal = 0;
  $PvdemaisVantagens = 0;
  $PvGratificacoes = 0;
  $PvSalarioFamilia = 0;
  $PvFerias = 0;
  $PvHorasExtras = 0;
  $subsidio = 0;

  $Dtotal = 0;
  $DvdemaisDescontos = 0;
  $DvIR = 0;
  $DvCONSIGNADOB1 = 0;
  $DvCONSIGNADOB2 = 0;
  $DvCONSIGNADOB3 = 0;
  $DvINSS = 0;
  $DvPensaoAlimenticia = 0;
  $SalarioLiquido = 0;

  $proPagamento = 0;


  $sequencial  = 1;
  $sequencial2 = 0;



  // Cabeçalho
  $aLinhas   = array();
  $aLinhasCabeca = '0Salario2       '.date('d/m/Y').date('H:i:s').'   1SIGA       111PREFEITURA MUNICIPAL DE COTEGIPE                                                                             1';
  $aLinhas[] = $aLinhasCabeca;
  $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
  fputs($arquivo, $sLinha);
  unset($aLinhas);
  //---

  foreach ($aDadosServidores as $oDadosServidor) {
    
    $aLinhas   = array(); 
    $sLinha    = '';
    /*
    echo substr('1 111   52 71ADELAIDE TAVARES DA CAMARA                        47328010134        82       1300000000000000000000000000036481800000000000912050000000000000000000000000000000000000000000000000000000000000000000000000007683700000000000277060000000000000000000000000000000000000000000000000000000000000000000000000005016200000000000000000000000000000000000000000000000000000000000000000000000000000000000000000030131830 40 40            2017120  ', 222,16);exit();

    echo inteiro_decimal_br(4000.14);
    exit();
    */

    // Para evitar que cargos zerados seram exibidos no txt.
    if ( $oDadosServidor->rhss_id_cargo == 0 ) {
      $oDadosServidor->rhss_id_cargo = null;
    }

    $gerfsal  = "SELECT r14_regist, r14_valor, r14_rubric, r14_quant, r14_pd FROM gerfsal WHERE r14_anousu = $ano and r14_mesusu = $mes and r14_regist = $oDadosServidor->rh02_regist";
    $rsgerfsal = db_query($gerfsal);
    $iLinhas2  = pg_num_rows($rsgerfsal);
    for( $iCont2=0; $iCont2<$iLinhas2; $iCont2++ ){
        $ogerfsal = db_utils::fieldsmemory($rsgerfsal, $iCont2);
        
        if ( $ogerfsal->r14_rubric == '0001' or 
          $ogerfsal->r14_rubric == '1913' or
          $ogerfsal->r14_rubric == '1940' or
          $ogerfsal->r14_rubric == '0110' ) {
          if ( $ogerfsal->r14_quant == 31 ) {
            $proPagamento = 30;
          } else {
            $proPagamento = $ogerfsal->r14_quant;
          }

          if ( (INT)$proPagamento == 0 ) {
            $proPagamento = 30;
          }
        }
        if ( $ogerfsal->r14_rubric == '1901' or 
          $ogerfsal->r14_rubric == '1902' or 
          $ogerfsal->r14_rubric == '1905' or 
          $ogerfsal->r14_rubric == '1912' or 
          $ogerfsal->r14_rubric == '1926' or 
          $ogerfsal->r14_rubric == '1927' or 
          $ogerfsal->r14_rubric == '1934' or 
          $ogerfsal->r14_rubric == '1936' or
          $ogerfsal->r14_rubric == '1937' or 
          $ogerfsal->r14_rubric == '1938' or
          //  LICENCA PREMIO (M)
          $ogerfsal->r14_rubric == '1940' ) {
            $PvdemaisVantagens = $PvdemaisVantagens + $ogerfsal->r14_valor;
            $proPagamento = 30;
          }

        if ( $ogerfsal->r14_rubric == '1907' or
           $ogerfsal->r14_rubric == '1908' or
           $ogerfsal->r14_rubric == '1909' or
           $ogerfsal->r14_rubric == '1915' or
           $ogerfsal->r14_rubric == '1918' or
           $ogerfsal->r14_rubric == '1921' or
           $ogerfsal->r14_rubric == '1929' or
           $ogerfsal->r14_rubric == '1930' or
           $ogerfsal->r14_rubric == '1931' ) {
          $PvGratificacoes = $PvGratificacoes + $ogerfsal->r14_valor;
        }

        if ( $ogerfsal->r14_rubric == '1917' ) {
          $PvSalarioFamilia = $ogerfsal->r14_valor;
        }
        
    if ( $ogerfsal->r14_rubric == '1924' or $ogerfsal->r14_rubric == '0143' ) {
          $PvFerias = $PvFerias + $ogerfsal->r14_valor;
        }

    
    if ( $ogerfsal->r14_rubric == '1916' ) {
          $PvHorasExtras = $ogerfsal->r14_valor;
        }

    if ( $ogerfsal->r14_rubric == '1913' ) {
      $subsidio = $ogerfsal->r14_valor;
    } else if ( $ogerfsal->r14_rubric == '0001' ) {
      $subsidio = $ogerfsal->r14_valor;
    } 


    if ( $ogerfsal->r14_rubric == '1925' or
           $ogerfsal->r14_rubric == '1928' or
           $ogerfsal->r14_rubric == '1932' or
           $ogerfsal->r14_rubric == '1939' or 
           $ogerfsal->r14_rubric == '1903' ) {
            $DvdemaisDescontos = $DvdemaisDescontos + $ogerfsal->r14_valor;
        }

        if ( $ogerfsal->r14_rubric == 'R913' ) {
      $DvIR = $ogerfsal->r14_valor;
    }

    if ( $ogerfsal->r14_rubric == 'R901' ) {
      $DvINSS = $ogerfsal->r14_valor;
    }

    if ( $ogerfsal->r14_rubric == '1910' or 
     $ogerfsal->r14_rubric == '1911' ) {
      $DvPensaoAlimenticia = $DvPensaoAlimenticia + $ogerfsal->r14_valor;
    }
    

    if ( $ogerfsal->r14_pd == '1' ) {
      $Ptotal = $Ptotal + $ogerfsal->r14_valor;
    }

    if ( $ogerfsal->r14_pd == '2' ) {
      $Dtotal = $Dtotal + $ogerfsal->r14_valor;
    }
        
        //$valor1 = $valor1 + $ogerfsal->r14_valor;
    }

    $SalarioLiquido = str_replace('.', '', ($Ptotal-$Dtotal));

    
    if ( (INT)$iLinhas2 > 0 ) {
      $sequencial++;
      $sequencial2++;

      $Ptotal_t   = $Ptotal_t + $Ptotal; 
      $subsidio_t = $subsidio_t + $subsidio; 
      $Dtotal2_t  = $Dtotal2_t + $Dtotal2;

      $DvdemaisDescontos_t = $DvdemaisDescontos_t + $DvdemaisDescontos;
      $DvINSS_t   = $DvINSS_t + $DvINSS;
      $DvIR_t   = $DvIR_t + $DvIR;

      $SalarioLiquido_t = $SalarioLiquido_t + $SalarioLiquido;

      //  Tipo de Registro
      $aLinhas[] = str_pad('1', 1, ' ');

      // Unidade Gestora
      $aLinhas[] = str_pad('111', 4, ' ', STR_PAD_LEFT);
      
      // Código do Orgão. 
      $aLinhas[] = str_pad($oDadosServidor->rhss_id_lotacao, 4, ' ', STR_PAD_LEFT);

      // Tipo de cargo. 
      $aLinhas[] = str_pad($oDadosServidor->rhss_cargoemprego, 1, ' ');

      // Função Atual do Servidor: tipo_funcao_siga
      $aLinhas[] = str_pad($oDadosServidor->rhss_id_tipo_funcao_siga, 2, ' ',STR_PAD_LEFT);

      // Classe do servidor: 
      $aLinhas[] = str_pad($oDadosServidor->rhss_tipovinculo, 1, ' ');

      // Nome do servidor
      $aLinhas[] = str_pad($oDadosServidor->z01_nome, 50, ' ');

      // CPF do servidor
      $aLinhas[] = str_pad($oDadosServidor->z01_cgccpf, 11, ' ');

      // Matricula do servidor
      $aLinhas[] = str_pad($oDadosServidor->rh02_regist, 10, ' ',STR_PAD_LEFT);

      // Cargo do servidor codigo_cargo->cargo->cargo_tcm
      $aLinhas[] = str_pad($oDadosServidor->rhss_id_cargo, 10, ' ',STR_PAD_LEFT);

      // Base - Todas as pessoas que recebem subsidio são diferentes de 0.
      $aLinhas[] = str_pad(inteiro_decimal_br($subsidio), 16, '0',STR_PAD_LEFT);

      //  Valor total das demais vantagens
      $aLinhas[] = str_pad(inteiro_decimal_br($PvdemaisVantagens), 16, '0',STR_PAD_LEFT);

      //  Valor gratificacoes
      $aLinhas[] = str_pad(inteiro_decimal_br($PvGratificacoes), 16, '0',STR_PAD_LEFT);

      //  Valor do salário família
      $aLinhas[] = str_pad(inteiro_decimal_br($PvSalarioFamilia), 16, '0',STR_PAD_LEFT);

      //  Valor ferias
      $aLinhas[] = str_pad(inteiro_decimal_br($PvFerias), 16, '0',STR_PAD_LEFT);

      //  Valor horas extras trabalhadas
      $aLinhas[] = str_pad(inteiro_decimal_br($PvHorasExtras), 16, '0',STR_PAD_LEFT);

      //  Valor 13 salario
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Informar o total dos demais descontos.
      $aLinhas[] = str_pad(inteiro_decimal_br($DvdemaisDescontos), 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do imposto de renda.
      $aLinhas[] = str_pad(inteiro_decimal_br($DvIR), 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do imposto de renda do 13 salario.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do emprestimo consignado banco 1.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do emprestimo consignado banco 2.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do emprestimo consignado banco 2.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do INSS.
      $aLinhas[] = str_pad(inteiro_decimal_br($DvINSS), 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do imposto de renda sobre férias.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do INSS 13.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do INSS sobre ferias.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor da pensao alimenticia.
      $aLinhas[] = str_pad(inteiro_decimal_br($DvPensaoAlimenticia), 16, '0',STR_PAD_LEFT);

      //  Desconto do plano de saude / odontologico.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Salario líquido a receber.
      $aLinhas[] = str_pad($SalarioLiquido, 16, '0',STR_PAD_LEFT);

      if ( $proPagamento == null ) {
        $proPagamento = 30;
      }

      //  Proporcionalidade de pagamento 31 para ciclo mensal completo ou menos para ciclo mensal incompleto.
      $aLinhas[] = str_pad(round($proPagamento), 2, ' ',STR_PAD_LEFT);

      //  Carga horária Trabalhada.
      $aLinhas[] = str_pad($oDadosServidor->rh02_hrssem, 3, ' ',STR_PAD_LEFT);

      //  Carga horária do cargo 20 ou 40.
      $aLinhas[] = str_pad($oDadosServidor->rh02_hrssem, 3, ' ',STR_PAD_LEFT);

      //  Codigo de compensação do banco que fez o emprestimo consignado. Banco 1
      $aLinhas[] = str_pad('', 4, ' ',STR_PAD_LEFT);

      //  Codigo de compensação do banco que fez o emprestimo consignado. Banco 2
      $aLinhas[] = str_pad('', 4, ' ',STR_PAD_LEFT);

      //  Codigo de compensação do banco que fez o emprestimo consignado. Banco 3
      $aLinhas[] = str_pad('', 4, ' ',STR_PAD_LEFT);

      //  Competência: anomes
      $aLinhas[] = str_pad($ano.$mes, 6, ' ',STR_PAD_LEFT);

      //  Indicador de Folha Complementar. 
      $aLinhas[] = str_pad('0', 1, ' ',STR_PAD_LEFT);

      //  Função servidor temporário.
      $aLinhas[] = str_pad('', 8, ' ',STR_PAD_LEFT);

      //  Número Sequencial de Registros. Obs. Usar ++
      $aLinhas[] = str_pad($sequencial, 10, ' ', STR_PAD_LEFT);


      // Funções para o PDF
      $pdf->cell(125,$alt,$oDadosServidor->z01_nome,0,0,"L",0);
      $pdf->cell(25,$alt,db_formatar($Ptotal,'f'),0,0,"L",0);
      $pdf->cell(25,$alt,db_formatar($subsidio,'f') ,0,0,"L",0);
      $pdf->cell(25,$alt,0,0,0,"L",0);
      $pdf->cell(25,$alt,db_formatar($DvdemaisDescontos,'f') ,0,0,"L",0);
      $pdf->cell(25,$alt,db_formatar($DvINSS,'f') ,0,0,"L",0);
      $pdf->cell(25,$alt,db_formatar($DvIR,'f') ,0,0,"L",0);
      
      $pdf->Ln(5);
      //---

      unset($Ptotal,
      $PvdemaisVantagens,
      $PvGratificacoes,
      $PvSalarioFamilia,
      $PvFerias,
      $PvHorasExtras,
      $subsidio
      );

      unset($Dtotal,
      $DvdemaisDescontos,
      $DvIR,
      $DvCONSIGNADOB1,
      $DvCONSIGNADOB2,
      $DvCONSIGNADOB3,
      $DvINSS,
      $DvPensaoAlimenticia,
      $SalarioLiquido
      );

      unset($proPagamento,$SalarioLiquido,$OrgaoRelatorio,$classeRelatorio);

      $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
      fputs($arquivo, $sLinha);
      unset($aLinhas);
    }
    

    $gerfsal  = "SELECT r48_regist, r48_valor, r48_rubric, r48_pd FROM gerfcom WHERE r48_anousu = $ano and r48_mesusu = $mes and r48_regist = $oDadosServidor->rh02_regist ";
    $rsgerfsal = db_query($gerfsal);
    $iLinhas2  = pg_num_rows($rsgerfsal);
    for( $iCont2=0; $iCont2<$iLinhas2; $iCont2++ ){
        $ogerfsal = db_utils::fieldsmemory($rsgerfsal, $iCont2);
        
         
        $proPagamento = 10;

        
    if ( $ogerfsal->r48_rubric == '1924' or
      $ogerfsal->r48_rubric == '0138' or
      $ogerfsal->r48_rubric == '0141' or 
      $ogerfsal->r48_rubric == '0143' or 
      $ogerfsal->r48_rubric == '0305'  ) {
          $PvFerias = $PvFerias + $ogerfsal->r48_valor;
        }

    
    if ( $ogerfsal->r48_rubric == '0140' or $ogerfsal->r48_rubric == '0142'  ) {
      $DvIR = $DvIR + $ogerfsal->r48_valor;
    }

    if ( $ogerfsal->r48_pd == '1' ) {
      $Ptotal = $Ptotal + $ogerfsal->r48_valor;
    }

    if ( $ogerfsal->r48_pd == '2' ) {
      $Dtotal = $Dtotal + $ogerfsal->r48_valor;
    }
        
        //$valor1 = $valor1 + $ogerfsal->r48_valor;
    }

    $SalarioLiquido = str_replace('.', '', ($Ptotal-$Dtotal));

    if ( (INT)$iLinhas2 > 0 ) {
      $sequencial++;

      $Ptotal_t   = $Ptotal_t + $Ptotal; 
      $subsidio_t = $subsidio_t + $subsidio; 
      $Dtotal2_t  = $Dtotal2_t + $Dtotal2;

      $DvINSS_t   = $DvINSS_t + $DvINSS;
      $DvIR_t   = $DvIR_t + $DvIR;

      $SalarioLiquido_t = $SalarioLiquido_t + $SalarioLiquido;

      //  Tipo de Registro
      $aLinhas[] = str_pad('1', 1, ' ');

      // Unidade Gestora
      $aLinhas[] = str_pad('111', 4, ' ', STR_PAD_LEFT);

      // Código do Orgão. 
      $aLinhas[] = str_pad($oDadosServidor->rhss_id_lotacao, 4, ' ', STR_PAD_LEFT);

      // Tipo de cargo. 
      $aLinhas[] = str_pad($oDadosServidor->rhss_cargoemprego, 1, ' ');

      // Função Atual do Servidor: tipo_funcao_siga
      $aLinhas[] = str_pad($oDadosServidor->rhss_id_tipo_funcao_siga, 2, ' ',STR_PAD_LEFT);

      // Classe do servidor: 
      $aLinhas[] = str_pad($oDadosServidor->rhss_tipovinculo, 1, ' ');

      // Nome do servidor
      $aLinhas[] = str_pad($oDadosServidor->z01_nome, 50, ' ');

      // CPF do servidor
      $aLinhas[] = str_pad($oDadosServidor->z01_cgccpf, 11, ' ');

      // Matricula do servidor
      $aLinhas[] = str_pad($oDadosServidor->rh02_regist, 10, ' ',STR_PAD_LEFT);

      // Cargo do servidor codigo_cargo->cargo->cargo_tcm
      $aLinhas[] = str_pad($oDadosServidor->rhss_id_cargo, 10, ' ',STR_PAD_LEFT);

      // Base - Todas as pessoas que recebem subsidio são diferentes de 0.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Valor total das demais vantagens
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Valor gratificacoes
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Valor do salário família
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Valor ferias
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Valor horas extras trabalhadas
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Valor 13 salario
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Informar o total dos demais descontos.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do imposto de renda.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do imposto de renda do 13 salario.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do emprestimo consignado banco 1.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do emprestimo consignado banco 2.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do emprestimo consignado banco 2.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do INSS.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor do imposto de renda sobre férias.
      $aLinhas[] = str_pad(str_replace('.', '', $DvIR), 16, '0',STR_PAD_LEFT);

      //  Desconto do INSS 13.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do INSS sobre ferias.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do valor da pensao alimenticia.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Desconto do plano de saude / odontologico.
      $aLinhas[] = str_pad('', 16, '0',STR_PAD_LEFT);

      //  Salario líquido a receber.
      $aLinhas[] = str_pad($SalarioLiquido, 16, '0',STR_PAD_LEFT);

      //  Proporcionalidade de pagamento 31 para ciclo mensal completo ou menos para ciclo mensal incompleto.
      $aLinhas[] = str_pad(round($proPagamento), 2, ' ',STR_PAD_LEFT);

      //  Carga horária Trabalhada.
      $aLinhas[] = str_pad($oDadosServidor->rh02_hrssem, 3, ' ',STR_PAD_LEFT);

      //  Carga horária do cargo 20 ou 40.
      $aLinhas[] = str_pad($oDadosServidor->rh02_hrssem, 3, ' ',STR_PAD_LEFT);

      //  Codigo de compensação do banco que fez o emprestimo consignado. Banco 1
      $aLinhas[] = str_pad('', 4, ' ',STR_PAD_LEFT);

      //  Codigo de compensação do banco que fez o emprestimo consignado. Banco 2
      $aLinhas[] = str_pad('', 4, ' ',STR_PAD_LEFT);

      //  Codigo de compensação do banco que fez o emprestimo consignado. Banco 3
      $aLinhas[] = str_pad('', 4, ' ',STR_PAD_LEFT);

      //  Competência: anomes
      $aLinhas[] = str_pad($ano.$mes, 6, ' ',STR_PAD_LEFT);

      //  Indicador de Folha Complementar. 
      $aLinhas[] = str_pad('2', 1, ' ',STR_PAD_LEFT);

      //  Função servidor temporário.
      $aLinhas[] = str_pad('', 8, ' ',STR_PAD_LEFT);

      //  Número Sequencial de Registros. Obs. Usar ++
      $aLinhas[] = str_pad($sequencial, 10, ' ', STR_PAD_LEFT);

      unset($Ptotal,
      $PvdemaisVantagens,
      $PvGratificacoes,
      $PvSalarioFamilia,
      $PvFerias,
      $PvHorasExtras,
      $subsidio
      );

      unset($Dtotal,
      $DvdemaisDescontos,
      $DvIR,
      $DvCONSIGNADOB1,
      $DvCONSIGNADOB2,
      $DvCONSIGNADOB3,
      $DvINSS,
      $DvPensaoAlimenticia,
      $SalarioLiquido
      );

      unset($proPagamento,$SalarioLiquido,$OrgaoRelatorio,$classeRelatorio);

      $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
      fputs($arquivo, $sLinha);
      unset($aLinhas);
    }
    
  }
  

  $pdf->cell(125,$alt,'TOTAL DE SERVIDORES ('.$sequencial2.')',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);

 

  $pdf->ln(5);

  $pdf->cell(125,$alt,'TOTAIS',0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($Ptotal_t,'f'),0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($subsidio_t,'f') ,0,0,"L",0);
  $pdf->cell(25,$alt,0,0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($DvdemaisDescontos_t,'f') ,0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($DvINSS_t,'f') ,0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($DvIR_t,'f') ,0,0,"L",0);

  $pdf->Output($nomepdf,false,true);

  $sequencial++;

  // Rodapé
  $aLinhas   = array();
  $aLinhasCabeca = '9'.str_pad($sequencial, 10, ' ',STR_PAD_LEFT);
  $aLinhas[] = $aLinhasCabeca;
  $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
  fputs($arquivo, $sLinha);
  unset($aLinhas);
  //---

  fclose($arquivo);


  // ler no formato de array
  $list = file("/tmp/salario2_".$ano.$mes.".txt");

  // array unique remove as arrays(linhas) duplicadas
  $list = array_unique($list);

  //  escreve de volta no arquivo
  file_put_contents("/tmp/salario2_".$ano.$mes.".txt", implode('', $list));
}

function emite_layout_pessoal($nomearq, $nomepdf, DBCompetencia $oCompetencia, $oParametros, $sSeparador = '') {

  $ano        = db_str($oCompetencia->getAno(),4);
  $mes        = db_str($oCompetencia->getMes(),2,0,"0");

  $rsDadosServidores = db_query("SELECT * FROM afasta 

      LEFT JOIN rhpessoal ON rh01_regist = afasta.r45_regist
      LEFT JOIN rhpessoalmov ON rh02_regist = rh01_regist and rh02_anousu = $ano and rh02_mesusu = $mes
      LEFT JOIN cgm ON z01_numcgm = rhpessoal.rh01_numcgm 


      WHERE r45_anousu = ".$oCompetencia->getAno()." and r45_mesusu = ".$oCompetencia->getMes()."");


  $pdf = new PDF('L');
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->setfillcolor(235);
  $pdf->setfont('arial','b',8);
  $troca = 1;
  $alt   = 4;

  global $head2;
  $head2 = "RELATORIO SIGA";
  $head3 = "COMPETENCIA: ".$oCompetencia->getAno().'/'.db_str($oCompetencia->getMes(),2,0,"0")."-".formatMes(db_str($oCompetencia->getMes(),2,0,"0"));


  $arquivo = fopen($nomearq,"w");

  //$sLinha .= "T;Dados Gerais \ Remuneração dos Profissionais de Educação \ ".db_str($oCompetencia->getMes(),2,0,"0")."-".formatMes(db_str($oCompetencia->getMes(),2,0,"0"))."";
  
  $aDadosServidores = array();
  $aDadosServidores = db_utils::makeCollectionFromRecord($rsDadosServidores, function($oItemServidor){
    return $oItemServidor;
  });

  $pdf->addpage();
  $pdf->setfont('arial','b',8);
  $troca = 0;
  
  $pdf->cell(125,$alt,"Servidor ",0,0,"L",0);
  $pdf->cell(25,$alt,"Bruto",0,0,"L",0);
  $pdf->cell(25,$alt,"Base",0,0,"L",0);
  $pdf->cell(25,$alt,"13",0,0,"L",0);
  $pdf->cell(25,$alt,"Outros. Desc.",0,0,"L",0);
  $pdf->cell(25,$alt,"INSS",0,0,"L",0);
  $pdf->cell(25,$alt,"I.R.",0,0,"L",0);
  $pdf->Ln(8);

  $sequencial  = 0;
  
  // Cabeçalho
  $aLinhas   = array();
  $aLinhasCabeca = '0Pessoal        '.date('d/m/Y').date('H:i:s').'   1SIGA       111PREFEITURA MUNICIPAL DE COTEGIPE                                                                             1';
  $aLinhas[] = $aLinhasCabeca;
  $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
  fputs($arquivo, $sLinha);
  unset($aLinhas);
  //---
  $sequencial = 1;

  foreach ($aDadosServidores as $oDadosServidor) {
    
    $sequencial++;
    
    $aLinhas   = array();
    $sLinha    = '';

    //db_log("processando matricula $orhpessoalmov->rh02_regist sequencia $cadastrou de $iLinhas", $sArquivoLog, 1, true, true); 


    //  Tipo de Registro
    $aLinhas[] = str_pad('1', 1, ' ');

    // Unidade Gestora
    $aLinhas[] = str_pad('111', 4, ' ', STR_PAD_LEFT);

    //  Cargo
    $aLinhas[] = str_pad('', 10, ' ');

    //  Tipo do Ato - 24  Contratação por prazo determinado (Término Contrato)
    $aLinhas[] =  str_pad('24', 2, ' ');

    //  Matricula
    $aLinhas[] = str_pad($oDadosServidor->rh01_regist, 10, ' ');

    //  Data de início de vigência do ato. Obs: No caso de afastamentos, pegue a data de afastamento.
    $aLinhas[] = str_pad(tratamentoData($oDadosServidor->r45_dtafas), 8, ' ');

    //  Nome do empregado. 50 caracteres.
    $aLinhas[] = str_pad($oDadosServidor->z01_nome, 50, ' ');

    //  CPF - 11 Caracteres
    $aLinhas[] = str_pad($oDadosServidor->z01_cgccpf, 11, ' ');

    //  Data nascimento.
    $aLinhas[] = str_pad(tratamentoData($oDadosServidor->z01_nasc), 8, ' ');

    //  Número do ato.  Obs: No caso de afastamento, colocar apenas o ano. - 12 caracteres.
    $aLinhas[] = str_pad($mes.$ano, 12, ' ');

    //  Data do ato - Obs: No caso de afastamentos, pegue a data de afastamento.
    $aLinhas[] = str_pad(tratamentoData($oDadosServidor->r45_dtafas), 8, ' ');

    //  Número do DOM / Imprensa Oficial
    $aLinhas[] = str_pad('', 30, ' ');

    //  Número do Edital do Concuso / Processo seletivo.
    $aLinhas[] = str_pad('', 16, ' ');

    //  Número do ato de afastamento. Obs: No caso de afastamento, colocar apenas o ano. - 12 caracteres.
    $aLinhas[] = str_pad($mes.$ano, 12, ' ');

    //  Reservado TCM
    $aLinhas[] = str_pad('0', 8, ' ');

    //  Número do DOM / Imprensa Oficial - Atos de afastamentos
    $aLinhas[] = str_pad('', 30, ' ');

    //  Ocupa Cargo Efetivo. Verificar se a pessoal é efetiva.
    if ( $orhpessoalmov->rh02_tpcont == 21 ) {
      $aLinhas[] = str_pad('S', 1, ' ');
    } else {
      $aLinhas[] = str_pad('N', 1, ' ');
    } 

    //  Competencia: ano/mes
    $aLinhas[] = str_pad($ano.$mes, 6, ' ');

    //  Fundamentacao Legal
    $aLinhas[] = str_pad('', 75, ' ');

    //  Reservado TCM
    $aLinhas[] = str_pad('', 1, ' ');

    //  Tipo Regime
    $aLinhas[] = str_pad('', 1, ' ');

    //  Data Efetivacao
    $aLinhas[] = str_pad('', 8, ' ');

    //  Indicador de acumulo de cargos.
    $aLinhas[] = str_pad('2', 1, ' ');

    //  Orgão/Entidade.
    $aLinhas[] = str_pad('', 40, ' ');

    //  Função Servidor Temporário
    $aLinhas[] = str_pad('', 8, ' ');

    //  Reservador TCM
    $aLinhas[] = str_pad('', 32, ' ');

    //  Função desempenhada
    $aLinhas[] = str_pad('', 40, ' ');

    //  Lotação
    $aLinhas[] = str_pad('', 40, ' ');

    //  Ônus para cedente
    $aLinhas[] = str_pad('1', 1, ' ');

    //  Orgão/Entidade
    $aLinhas[] = str_pad('', 40, ' ');

    //  Número do processo
    $aLinhas[] = str_pad('', 16, ' ');

    //  Nome do cargo acumulado.
    $aLinhas[] = str_pad('', 40, ' ');

    //  Data de publicação.
    $aLinhas[] = str_pad('', 8, ' ');

    //  Data de publicação do afastamento. Obs: No caso de afastamentos, pegue a data de afastamento.
    $aLinhas[] = str_pad(tratamentoData($oDadosServidor->r45_dtafas), 8, ' ');

    //  Justificativa para contratação.
    $aLinhas[] = str_pad('', 255, ' ');

    //  Data previsão término contrato.
    $aLinhas[] = str_pad('', 8, ' ');

    //  Cargo Anterior.
    $aLinhas[] = str_pad('', 10, ' ');

    //  Processo TCM - Número.
    $aLinhas[] = str_pad('', 6, ' ');

    //  Processo TCM - dígito verificado.
    $aLinhas[] = str_pad('', 1, ' ');

    //  Processo TCM - ano.
    $aLinhas[] = str_pad('', 4, ' ');

    //  Cargo origem / destino-cessão.
    $aLinhas[] = str_pad('', 40, ' ');

    //  Status concurso.
    $aLinhas[] = str_pad('T', 1, ' ');

    //  Anterior SIGA.
    $aLinhas[] = str_pad('1', 1, ' ');

    //  Número Sequencial de Registros. Obs. Usar ++
    $aLinhas[] = str_pad($sequencial, 10, ' ', STR_PAD_LEFT);



    $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
    fputs($arquivo, $sLinha);    
  }
  
  $pdf->cell(125,$alt,'TOTAL DE SERVIDORES ('.$sequencial2.')',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);
  $pdf->cell(25,$alt,'',0,0,"L",0);

  $pdf->ln(5);

  $pdf->cell(125,$alt,'TOTAIS',0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($Ptotal_t,'f'),0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($subsidio_t,'f') ,0,0,"L",0);
  $pdf->cell(25,$alt,0,0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($DvdemaisDescontos_t,'f') ,0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($DvINSS_t,'f') ,0,0,"L",0);
  $pdf->cell(25,$alt,db_formatar($DvIR_t,'f') ,0,0,"L",0);

  $pdf->Output($nomepdf,false,true);
  
  $sequencial++;

  // Rodapé
  $aLinhas   = array();
  $aLinhasCabeca = '9'.str_pad($sequencial, 10, ' ',STR_PAD_LEFT);
  $aLinhas[] = $aLinhasCabeca;
  $sLinha   .= implode($sSeparador, $aLinhas) . PHP_EOL;
  fputs($arquivo, $sLinha);
  unset($aLinhas);
  //---

  fclose($arquivo);

  // ler no formato de array
  $list = file("/tmp/pessoal_".$ano.$mes.".txt");

  // array unique remove as arrays(linhas) duplicadas
  $list = array_unique($list);

  //  escreve de volta no arquivo
  file_put_contents("/tmp/pessoal_".$ano.$mes.".txt", implode('', $list));
}
