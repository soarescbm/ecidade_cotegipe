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

//MODULO: patrim
//CLASSE DA ENTIDADE benstransfdes
class cl_benstransfdes { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $t94_codtran = 0; 
   var $t94_depart = 0; 
   var $t94_divisao = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 t94_codtran = int8 = Transfer�ncia 
                 t94_depart = int4 = Departamento destino 
                 t94_divisao = int4 = Divis�o 
                 ";
   //funcao construtor da classe 
   function cl_benstransfdes() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("benstransfdes"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->t94_codtran = ($this->t94_codtran == ""?@$GLOBALS["HTTP_POST_VARS"]["t94_codtran"]:$this->t94_codtran);
       $this->t94_depart = ($this->t94_depart == ""?@$GLOBALS["HTTP_POST_VARS"]["t94_depart"]:$this->t94_depart);
       $this->t94_divisao = ($this->t94_divisao == ""?@$GLOBALS["HTTP_POST_VARS"]["t94_divisao"]:$this->t94_divisao);
     }else{
       $this->t94_codtran = ($this->t94_codtran == ""?@$GLOBALS["HTTP_POST_VARS"]["t94_codtran"]:$this->t94_codtran);
       $this->t94_depart = ($this->t94_depart == ""?@$GLOBALS["HTTP_POST_VARS"]["t94_depart"]:$this->t94_depart);
     }
   }
   // funcao para inclusao
   function incluir ($t94_codtran,$t94_depart){ 
      $this->atualizacampos();
     if($this->t94_divisao == null ){ 
       $this->t94_divisao = "0";
     }
       $this->t94_codtran = $t94_codtran; 
       $this->t94_depart = $t94_depart; 
     if(($this->t94_codtran == null) || ($this->t94_codtran == "") ){ 
       $this->erro_sql = " Campo t94_codtran nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->t94_depart == null) || ($this->t94_depart == "") ){ 
       $this->erro_sql = " Campo t94_depart nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into benstransfdes(
                                       t94_codtran 
                                      ,t94_depart 
                                      ,t94_divisao 
                       )
                values (
                                $this->t94_codtran 
                               ,$this->t94_depart 
                               ,$this->t94_divisao 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Departamento de destino da transfer�ncia ($this->t94_codtran."-".$this->t94_depart) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Departamento de destino da transfer�ncia j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Departamento de destino da transfer�ncia ($this->t94_codtran."-".$this->t94_depart) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->t94_codtran."-".$this->t94_depart;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->t94_codtran,$this->t94_depart));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,5827,'$this->t94_codtran','I')");
       $resac = db_query("insert into db_acountkey values($acount,5829,'$this->t94_depart','I')");
       $resac = db_query("insert into db_acount values($acount,931,5827,'','".AddSlashes(pg_result($resaco,0,'t94_codtran'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,931,5829,'','".AddSlashes(pg_result($resaco,0,'t94_depart'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,931,13774,'','".AddSlashes(pg_result($resaco,0,'t94_divisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($t94_codtran=null,$t94_depart=null) { 
      $this->atualizacampos();
     $sql = " update benstransfdes set ";
     $virgula = "";
     if(trim($this->t94_codtran)!="" || isset($GLOBALS["HTTP_POST_VARS"]["t94_codtran"])){ 
       $sql  .= $virgula." t94_codtran = $this->t94_codtran ";
       $virgula = ",";
       if(trim($this->t94_codtran) == null ){ 
         $this->erro_sql = " Campo Transfer�ncia nao Informado.";
         $this->erro_campo = "t94_codtran";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->t94_depart)!="" || isset($GLOBALS["HTTP_POST_VARS"]["t94_depart"])){ 
       $sql  .= $virgula." t94_depart = $this->t94_depart ";
       $virgula = ",";
       if(trim($this->t94_depart) == null ){ 
         $this->erro_sql = " Campo Departamento destino nao Informado.";
         $this->erro_campo = "t94_depart";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->t94_divisao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["t94_divisao"])){ 
        if(trim($this->t94_divisao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["t94_divisao"])){ 
           $this->t94_divisao = "0" ; 
        } 
       $sql  .= $virgula." t94_divisao = $this->t94_divisao ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($t94_codtran!=null){
       $sql .= " t94_codtran = $this->t94_codtran";
     }
     if($t94_depart!=null){
       $sql .= " and  t94_depart = $this->t94_depart";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->t94_codtran,$this->t94_depart));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,5827,'$this->t94_codtran','A')");
         $resac = db_query("insert into db_acountkey values($acount,5829,'$this->t94_depart','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["t94_codtran"]))
           $resac = db_query("insert into db_acount values($acount,931,5827,'".AddSlashes(pg_result($resaco,$conresaco,'t94_codtran'))."','$this->t94_codtran',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["t94_depart"]))
           $resac = db_query("insert into db_acount values($acount,931,5829,'".AddSlashes(pg_result($resaco,$conresaco,'t94_depart'))."','$this->t94_depart',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["t94_divisao"]))
           $resac = db_query("insert into db_acount values($acount,931,13774,'".AddSlashes(pg_result($resaco,$conresaco,'t94_divisao'))."','$this->t94_divisao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Departamento de destino da transfer�ncia nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->t94_codtran."-".$this->t94_depart;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Departamento de destino da transfer�ncia nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->t94_codtran."-".$this->t94_depart;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->t94_codtran."-".$this->t94_depart;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($t94_codtran=null,$t94_depart=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($t94_codtran,$t94_depart));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,5827,'$t94_codtran','E')");
         $resac = db_query("insert into db_acountkey values($acount,5829,'$t94_depart','E')");
         $resac = db_query("insert into db_acount values($acount,931,5827,'','".AddSlashes(pg_result($resaco,$iresaco,'t94_codtran'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,931,5829,'','".AddSlashes(pg_result($resaco,$iresaco,'t94_depart'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,931,13774,'','".AddSlashes(pg_result($resaco,$iresaco,'t94_divisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from benstransfdes
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($t94_codtran != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " t94_codtran = $t94_codtran ";
        }
        if($t94_depart != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " t94_depart = $t94_depart ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Departamento de destino da transfer�ncia nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$t94_codtran."-".$t94_depart;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Departamento de destino da transfer�ncia nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$t94_codtran."-".$t94_depart;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$t94_codtran."-".$t94_depart;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = db_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:benstransfdes";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $t94_codtran=null,$t94_depart=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from benstransfdes ";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = benstransfdes.t94_depart";
     $sql .= "      inner join benstransf  on  benstransf.t93_codtran = benstransfdes.t94_codtran";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = benstransf.t93_id_usuario";
     $sql .= "      inner join db_depart as a  on  a.coddepto = benstransf.t93_depart";
     $sql2 = "";
     if($dbwhere==""){
       if($t94_codtran!=null ){
         $sql2 .= " where benstransfdes.t94_codtran = $t94_codtran "; 
       } 
       if($t94_depart!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " benstransfdes.t94_depart = $t94_depart "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $t94_codtran=null,$t94_depart=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from benstransfdes ";
     $sql2 = "";
     if($dbwhere==""){
       if($t94_codtran!=null ){
         $sql2 .= " where benstransfdes.t94_codtran = $t94_codtran "; 
       } 
       if($t94_depart!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " benstransfdes.t94_depart = $t94_depart "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
  
   function sql_query_lote( $t94_codtran=null,$t94_depart=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from benstransfdes ";
     $sql .= "      inner join db_depart       on  db_depart.coddepto     = benstransfdes.t94_depart  ";
     $sql .= "      inner join benstransf      on  benstransf.t93_codtran = benstransfdes.t94_codtran ";
     $sql .= "      left  join departdiv       on  departdiv.t30_codigo   = benstransfdes.t94_divisao   ";
     $sql .= "      inner join db_usuarios     on  db_usuarios.id_usuario = benstransf.t93_id_usuario ";
     $sql .= "      inner join db_depart as a  on  a.coddepto             = benstransf.t93_depart     ";
     $sql .= "      left  join departdiv as b  on  b.t30_codigo           = benstransf.t93_divisao    ";
     $sql .= "      left  join clabens         on  clabens.t64_codcla     = benstransf.t93_clabens    ";
     $sql2 = "";
     if($dbwhere==""){
       if($t94_codtran!=null ){
         $sql2 .= " where benstransfdes.t94_codtran = $t94_codtran "; 
       } 
       if($t94_depart!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " benstransfdes.t94_depart = $t94_depart "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }  
  
}
?>