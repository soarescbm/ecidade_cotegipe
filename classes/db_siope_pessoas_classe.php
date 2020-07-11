<?
//MODULO: pessoal
//CLASSE DA ENTIDADE siope_pessoas
class cl_siope_pessoas { 
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
   var $rhsp_regist = 0; 
   var $rhsp_categoria_profissional = 0; 
   var $rhsp_local_trabalho = 0; 
   var $rhsp_fundeb60 = null; 
   var $rhsp_fundeb40 = null; 
   var $rhsp_recproc = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 rhsp_regist = int4 = Matrícula 
                 rhsp_categoria_profissional = int4 = CODIGO DA CATEGORIA 
                 rhsp_local_trabalho = int8 = CODIGO DA ESCOLA 
                 rhsp_fundeb60 = char(1) = FUNDEB 60% 
                 rhsp_fundeb40 = char(1) = FUNDEB 40% 
                 rhsp_recproc = char(1) = REC. PROC. 
                 ";
   //funcao construtor da classe 
   function cl_siope_pessoas() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("siope_pessoas"); 
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
       $this->rhsp_regist = ($this->rhsp_regist == ""?@$GLOBALS["HTTP_POST_VARS"]["rhsp_regist"]:$this->rhsp_regist);
       $this->rhsp_categoria_profissional = ($this->rhsp_categoria_profissional == ""?@$GLOBALS["HTTP_POST_VARS"]["rhsp_categoria_profissional"]:$this->rhsp_categoria_profissional);
       $this->rhsp_local_trabalho = ($this->rhsp_local_trabalho == ""?@$GLOBALS["HTTP_POST_VARS"]["rhsp_local_trabalho"]:$this->rhsp_local_trabalho);
       $this->rhsp_fundeb60 = ($this->rhsp_fundeb60 == ""?@$GLOBALS["HTTP_POST_VARS"]["rhsp_fundeb60"]:$this->rhsp_fundeb60);
       $this->rhsp_fundeb40 = ($this->rhsp_fundeb40 == ""?@$GLOBALS["HTTP_POST_VARS"]["rhsp_fundeb40"]:$this->rhsp_fundeb40);
       $this->rhsp_recproc = ($this->rhsp_recproc == ""?@$GLOBALS["HTTP_POST_VARS"]["rhsp_recproc"]:$this->rhsp_recproc);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){ 
      $this->atualizacampos();
     if($this->rhsp_regist == null ){ 
       $this->erro_sql = " Campo Matrícula não informado.";
       $this->erro_campo = "rhsp_regist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rhsp_categoria_profissional == null ){ 
       $this->erro_sql = " Campo CODIGO DA CATEGORIA não informado.";
       $this->erro_campo = "rhsp_categoria_profissional";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rhsp_local_trabalho == null ){ 
       $this->erro_sql = " Campo CODIGO DA ESCOLA não informado.";
       $this->erro_campo = "rhsp_local_trabalho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rhsp_fundeb60 == null ){ 
       $this->erro_sql = " Campo FUNDEB 60% não informado.";
       $this->erro_campo = "rhsp_fundeb60";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rhsp_fundeb40 == null ){ 
       $this->erro_sql = " Campo FUNDEB 40% não informado.";
       $this->erro_campo = "rhsp_fundeb40";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rhsp_recproc == null ){ 
       $this->erro_sql = " Campo REC. PROC. não informado.";
       $this->erro_campo = "rhsp_recproc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into siope_pessoas(
                                       rhsp_regist 
                                      ,rhsp_categoria_profissional 
                                      ,rhsp_local_trabalho 
                                      ,rhsp_fundeb60 
                                      ,rhsp_fundeb40 
                                      ,rhsp_recproc 
                       )
                values (
                                $this->rhsp_regist 
                               ,$this->rhsp_categoria_profissional 
                               ,$this->rhsp_local_trabalho 
                               ,'$this->rhsp_fundeb60' 
                               ,'$this->rhsp_fundeb40' 
                               ,'$this->rhsp_recproc' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "SIOPE PESSOAS () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "SIOPE PESSOAS já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "SIOPE PESSOAS () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

     }
     return true;
   } 
   // funcao para alteracao
   function alterar ( $oid=null ) { 
      $this->atualizacampos();
     $sql = " update siope_pessoas set ";
     $virgula = "";
     if(trim($this->rhsp_regist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rhsp_regist"])){ 
       $sql  .= $virgula." rhsp_regist = $this->rhsp_regist ";
       $virgula = ",";
       if(trim($this->rhsp_regist) == null ){ 
         $this->erro_sql = " Campo Matrícula não informado.";
         $this->erro_campo = "rhsp_regist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rhsp_categoria_profissional)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rhsp_categoria_profissional"])){ 
       $sql  .= $virgula." rhsp_categoria_profissional = $this->rhsp_categoria_profissional ";
       $virgula = ",";
       if(trim($this->rhsp_categoria_profissional) == null ){ 
         $this->erro_sql = " Campo CODIGO DA CATEGORIA não informado.";
         $this->erro_campo = "rhsp_categoria_profissional";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rhsp_local_trabalho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rhsp_local_trabalho"])){ 
       $sql  .= $virgula." rhsp_local_trabalho = $this->rhsp_local_trabalho ";
       $virgula = ",";
       if(trim($this->rhsp_local_trabalho) == null ){ 
         $this->erro_sql = " Campo CODIGO DA ESCOLA não informado.";
         $this->erro_campo = "rhsp_local_trabalho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rhsp_fundeb60)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rhsp_fundeb60"])){ 
       $sql  .= $virgula." rhsp_fundeb60 = '$this->rhsp_fundeb60' ";
       $virgula = ",";
       if(trim($this->rhsp_fundeb60) == null ){ 
         $this->erro_sql = " Campo FUNDEB 60% não informado.";
         $this->erro_campo = "rhsp_fundeb60";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rhsp_fundeb40)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rhsp_fundeb40"])){ 
       $sql  .= $virgula." rhsp_fundeb40 = '$this->rhsp_fundeb40' ";
       $virgula = ",";
       if(trim($this->rhsp_fundeb40) == null ){ 
         $this->erro_sql = " Campo FUNDEB 40% não informado.";
         $this->erro_campo = "rhsp_fundeb40";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rhsp_recproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rhsp_recproc"])){ 
       $sql  .= $virgula." rhsp_recproc = '$this->rhsp_recproc' ";
       $virgula = ",";
       if(trim($this->rhsp_recproc) == null ){ 
         $this->erro_sql = " Campo REC. PROC. não informado.";
         $this->erro_campo = "rhsp_recproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "SIOPE PESSOAS nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "SIOPE PESSOAS nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ( $oid=null ,$dbwhere=null) { 

     $sql = " delete from siope_pessoas
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
       $sql2 = "oid = '$oid'";
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "SIOPE PESSOAS nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "SIOPE PESSOAS nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:siope_pessoas";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $oid = null,$campos="siope_pessoas.oid,*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from siope_pessoas ";
     $sql2 = "";
     if($dbwhere==""){
       if( $oid != "" && $oid != null){
          $sql2 = " where siope_pessoas.oid = '$oid'";
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
   function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from siope_pessoas ";
     $sql2 = "";
     if($dbwhere==""){
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
