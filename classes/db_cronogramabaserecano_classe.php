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

//MODULO: orcamento
//CLASSE DA ENTIDADE cronogramabaserecano
class cl_cronogramabaserecano { 
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
   var $o129_sequencial = 0; 
   var $o129_cronogramaperspectivareceita = 0; 
   var $o129_ano = 0; 
   var $o129_valor = 0; 
   var $o129_usamedia = 'f'; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o129_sequencial = int4 = C�digo Sequencial 
                 o129_cronogramaperspectivareceita = int4 = Receita do Cronograma 
                 o129_ano = int4 = Ano 
                 o129_valor = float8 = Valor 
                 o129_usamedia = bool = usa no Calculo da M�dia 
                 ";
   //funcao construtor da classe 
   function cl_cronogramabaserecano() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("cronogramabaserecano"); 
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
       $this->o129_sequencial = ($this->o129_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o129_sequencial"]:$this->o129_sequencial);
       $this->o129_cronogramaperspectivareceita = ($this->o129_cronogramaperspectivareceita == ""?@$GLOBALS["HTTP_POST_VARS"]["o129_cronogramaperspectivareceita"]:$this->o129_cronogramaperspectivareceita);
       $this->o129_ano = ($this->o129_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o129_ano"]:$this->o129_ano);
       $this->o129_valor = ($this->o129_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["o129_valor"]:$this->o129_valor);
       $this->o129_usamedia = ($this->o129_usamedia == "f"?@$GLOBALS["HTTP_POST_VARS"]["o129_usamedia"]:$this->o129_usamedia);
     }else{
       $this->o129_sequencial = ($this->o129_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o129_sequencial"]:$this->o129_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($o129_sequencial){ 
      $this->atualizacampos();
     if($this->o129_cronogramaperspectivareceita == null ){ 
       $this->erro_sql = " Campo Receita do Cronograma nao Informado.";
       $this->erro_campo = "o129_cronogramaperspectivareceita";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o129_ano == null ){ 
       $this->erro_sql = " Campo Ano nao Informado.";
       $this->erro_campo = "o129_ano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o129_valor == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "o129_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o129_usamedia == null ){ 
       $this->erro_sql = " Campo usa no Calculo da M�dia nao Informado.";
       $this->erro_campo = "o129_usamedia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($o129_sequencial == "" || $o129_sequencial == null ){
       $result = db_query("select nextval('cronogramabasecalculoanoreceita_o129_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cronogramabasecalculoanoreceita_o129_sequencial_seq do campo: o129_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->o129_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from cronogramabasecalculoanoreceita_o129_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $o129_sequencial)){
         $this->erro_sql = " Campo o129_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->o129_sequencial = $o129_sequencial; 
       }
     }
     if(($this->o129_sequencial == null) || ($this->o129_sequencial == "") ){ 
       $this->erro_sql = " Campo o129_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into cronogramabaserecano(
                                       o129_sequencial 
                                      ,o129_cronogramaperspectivareceita 
                                      ,o129_ano 
                                      ,o129_valor 
                                      ,o129_usamedia 
                       )
                values (
                                $this->o129_sequencial 
                               ,$this->o129_cronogramaperspectivareceita 
                               ,$this->o129_ano 
                               ,$this->o129_valor 
                               ,'$this->o129_usamedia' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Ano da base da calculo da receita ($this->o129_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Ano da base da calculo da receita j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Ano da base da calculo da receita ($this->o129_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o129_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o129_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,14907,'$this->o129_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2624,14907,'','".AddSlashes(pg_result($resaco,0,'o129_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2624,14908,'','".AddSlashes(pg_result($resaco,0,'o129_cronogramaperspectivareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2624,14909,'','".AddSlashes(pg_result($resaco,0,'o129_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2624,14910,'','".AddSlashes(pg_result($resaco,0,'o129_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2624,14911,'','".AddSlashes(pg_result($resaco,0,'o129_usamedia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o129_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update cronogramabaserecano set ";
     $virgula = "";
     if(trim($this->o129_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o129_sequencial"])){ 
       $sql  .= $virgula." o129_sequencial = $this->o129_sequencial ";
       $virgula = ",";
       if(trim($this->o129_sequencial) == null ){ 
         $this->erro_sql = " Campo C�digo Sequencial nao Informado.";
         $this->erro_campo = "o129_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o129_cronogramaperspectivareceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o129_cronogramaperspectivareceita"])){ 
       $sql  .= $virgula." o129_cronogramaperspectivareceita = $this->o129_cronogramaperspectivareceita ";
       $virgula = ",";
       if(trim($this->o129_cronogramaperspectivareceita) == null ){ 
         $this->erro_sql = " Campo Receita do Cronograma nao Informado.";
         $this->erro_campo = "o129_cronogramaperspectivareceita";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o129_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o129_ano"])){ 
       $sql  .= $virgula." o129_ano = $this->o129_ano ";
       $virgula = ",";
       if(trim($this->o129_ano) == null ){ 
         $this->erro_sql = " Campo Ano nao Informado.";
         $this->erro_campo = "o129_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o129_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o129_valor"])){ 
       $sql  .= $virgula." o129_valor = $this->o129_valor ";
       $virgula = ",";
       if(trim($this->o129_valor) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "o129_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o129_usamedia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o129_usamedia"])){ 
       $sql  .= $virgula." o129_usamedia = '$this->o129_usamedia' ";
       $virgula = ",";
       if(trim($this->o129_usamedia) == null ){ 
         $this->erro_sql = " Campo usa no Calculo da M�dia nao Informado.";
         $this->erro_campo = "o129_usamedia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($o129_sequencial!=null){
       $sql .= " o129_sequencial = $this->o129_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o129_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,14907,'$this->o129_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o129_sequencial"]) || $this->o129_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2624,14907,'".AddSlashes(pg_result($resaco,$conresaco,'o129_sequencial'))."','$this->o129_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o129_cronogramaperspectivareceita"]) || $this->o129_cronogramaperspectivareceita != "")
           $resac = db_query("insert into db_acount values($acount,2624,14908,'".AddSlashes(pg_result($resaco,$conresaco,'o129_cronogramaperspectivareceita'))."','$this->o129_cronogramaperspectivareceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o129_ano"]) || $this->o129_ano != "")
           $resac = db_query("insert into db_acount values($acount,2624,14909,'".AddSlashes(pg_result($resaco,$conresaco,'o129_ano'))."','$this->o129_ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o129_valor"]) || $this->o129_valor != "")
           $resac = db_query("insert into db_acount values($acount,2624,14910,'".AddSlashes(pg_result($resaco,$conresaco,'o129_valor'))."','$this->o129_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o129_usamedia"]) || $this->o129_usamedia != "")
           $resac = db_query("insert into db_acount values($acount,2624,14911,'".AddSlashes(pg_result($resaco,$conresaco,'o129_usamedia'))."','$this->o129_usamedia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Ano da base da calculo da receita nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o129_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Ano da base da calculo da receita nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o129_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o129_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o129_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o129_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,14907,'$o129_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2624,14907,'','".AddSlashes(pg_result($resaco,$iresaco,'o129_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2624,14908,'','".AddSlashes(pg_result($resaco,$iresaco,'o129_cronogramaperspectivareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2624,14909,'','".AddSlashes(pg_result($resaco,$iresaco,'o129_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2624,14910,'','".AddSlashes(pg_result($resaco,$iresaco,'o129_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2624,14911,'','".AddSlashes(pg_result($resaco,$iresaco,'o129_usamedia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from cronogramabaserecano
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o129_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o129_sequencial = $o129_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Ano da base da calculo da receita nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o129_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Ano da base da calculo da receita nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o129_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o129_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:cronogramabaserecano";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $o129_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cronogramabaserecano ";
     $sql .= "      inner join cronogramaperspectivareceita  on  cronogramaperspectivareceita.o126_sequencial = cronogramabaserecano.o129_cronogramaperspectivareceita";
     $sql .= "      inner join orcreceita  on  orcreceita.o70_anousu = cronogramaperspectivareceita.o126_anousu and  orcreceita.o70_codrec = cronogramaperspectivareceita.o126_codrec";
     $sql .= "      inner join cronogramaperspectiva  on  cronogramaperspectiva.o124_sequencial = cronogramaperspectivareceita.o126_cronogramaperspectiva";
     $sql2 = "";
     if($dbwhere==""){
       if($o129_sequencial!=null ){
         $sql2 .= " where cronogramabaserecano.o129_sequencial = $o129_sequencial "; 
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
   function sql_query_file ( $o129_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from cronogramabaserecano ";
     $sql2 = "";
     if($dbwhere==""){
       if($o129_sequencial!=null ){
         $sql2 .= " where cronogramabaserecano.o129_sequencial = $o129_sequencial "; 
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