<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);


include("classes/db_orcunidade_classe.php");

$clorcunidade = new cl_orcunidade;
$clorcunidade->rotulo->label();

$rotulocampo = new rotulocampo;
$rotulocampo->label("o40_descr");

$result = $clorcunidade->sql_record($clorcunidade->sql_query(db_getsession("DB_anousu"), null, null, "*", "orcunidade.o41_orgao, orcunidade.o41_unidade" ));

$head3 = "RELAT�RIO DE ORG�OS/UNIDADES";
$head5 = "EXERC�CIO: ".db_getsession("DB_anousu");

$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=N�o existem Org�os/Unidades cadastrados.');
   exit;
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$orgao=0;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,$RLo41_orgao,1,0,"C",1);
      $pdf->cell(60,$alt,$RLo41_descr,1,0,"L",1);
      $pdf->cell(15,$alt,$RLo41_unidade,1,0,"C",1);
      $pdf->cell(60,$alt,$RLo41_descr,1,1,"L",1);
      $total = 0;
      $troca = 0;
   }
   $pdf->setfont('arial','',7);
   $lista=false;
   if($o41_orgao!=$orgao){
     $lista=true;
     $orgao=$o41_orgao;
   }
   if($lista==true){
     $pdf->cell(15,$alt,db_formatar($o41_orgao,'orgao'),0,0,"C",0);
     $pdf->cell(60,$alt,$o40_descr,0,0,"L",0);
   }else{
     $pdf->cell(15,$alt,'',0,0,"C",0);
     $pdf->cell(60,$alt,'',0,0,"L",0);
   }
   $pdf->cell(15,$alt,db_formatar($o41_unidade,'unidade'),0,0,"C",0);
   $pdf->cell(60,$alt,$o41_descr,0,1,"L",0);
}
$pdf->Output();
?>