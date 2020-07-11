<?
//MODULO: ambulatorial
//CLASSE DA ENTIDADE cgs_undendereco
class cl_cgs_undendereco { 
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
   var $sd109_sequencial = 0; 
   var $sd109_endereco = 0; 
   var $sd109_cgs_und = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 sd109_sequencial = int4 = C�digo 
                 sd109_endereco = int4 = C�digo do Endere�o 
                 sd109_cgs_und = int4 = CGS 
                 ";
   //funcao construtor da classe 
   function cl_cgs_undendereco() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("cgs_undendereco"); 
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
       $this->sd109_sequencial = ($this->sd109_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["sd109_sequencial"]:$this->sd109_sequencial);
       $this->sd109_endereco = ($this->sd109_endereco == ""?@$GLOBALS["HTTP_POST_VARS"]["sd109_endereco"]:$this->sd109_endereco);
       $this->sd109_cgs_und = ($this->sd109_cgs_und == ""?@$GLOBALS["HTTP_POST_VARS"]["sd109_cgs_und"]:$this->sd109_cgs_und);
     }else{
       $this->sd109_sequencial = ($this->sd109_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["sd109_sequencial"]:$this->sd109_sequencial);
     }
   }
   // funcao para Inclus�o
   function incluir ($sd109_sequencial){ 
      $this->atualizacampos();
     if($this->sd109_endereco == null ){ 
       $this->erro_sql = " Campo C�digo do Endere�o n�o informado.";
       $this->erro_campo = "sd109_endereco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->sd109_cgs_und == null ){ 
       $this->erro_sql = " Campo CGS n�o informado.";
       $this->erro_campo = "sd109_cgs_und";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($sd109_sequencial == "" || $sd109_sequencial == null ){
       $result = db_query("select nextval('cgs_undendereco_sd109_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cgs_undendereco_sd109_sequencial_seq do campo: sd109_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->sd109_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from cgs_undendereco_sd109_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $sd109_sequencial)){
         $this->erro_sql = " Campo sd109_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->sd109_sequencial = $sd109_sequencial; 
       }
     }
     if(($this->sd109_sequencial == null) || ($this->sd109_sequencial == "") ){ 
       $this->erro_sql = " Campo sd109_sequencial n�o declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into cgs_undendereco(
                                       sd109_sequencial 
                                      ,sd109_endereco 
                                      ,sd109_cgs_und 
                       )
                values (
                                $this->sd109_sequencial 
                               ,$this->sd109_endereco 
                               ,$this->sd109_cgs_und 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Endere�os do CGS ($this->sd109_sequencial) n�o Inclu�do. Inclus�o Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Endere�os do CGS j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Endere�os do CGS ($this->sd109_sequencial) n�o Inclu�do. Inclus�o Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->sd109_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->sd109_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,21871,'$this->sd109_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,3938,21871,'','".AddSlashes(pg_result($resaco,0,'sd109_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3938,21872,'','".AddSlashes(pg_result($resaco,0,'sd109_endereco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3938,21873,'','".AddSlashes(pg_result($resaco,0,'sd109_cgs_und'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   public function alterar ($sd109_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update cgs_undendereco set ";
     $virgula = "";
     if(trim($this->sd109_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["sd109_sequencial"])){ 
       $sql  .= $virgula." sd109_sequencial = $this->sd109_sequencial ";
       $virgula = ",";
       if(trim($this->sd109_sequencial) == null ){ 
         $this->erro_sql = " Campo C�digo n�o informado.";
         $this->erro_campo = "sd109_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->sd109_endereco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["sd109_endereco"])){ 
       $sql  .= $virgula." sd109_endereco = $this->sd109_endereco ";
       $virgula = ",";
       if(trim($this->sd109_endereco) == null ){ 
         $this->erro_sql = " Campo C�digo do Endere�o n�o informado.";
         $this->erro_campo = "sd109_endereco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->sd109_cgs_und)!="" || isset($GLOBALS["HTTP_POST_VARS"]["sd109_cgs_und"])){ 
       $sql  .= $virgula." sd109_cgs_und = $this->sd109_cgs_und ";
       $virgula = ",";
       if(trim($this->sd109_cgs_und) == null ){ 
         $this->erro_sql = " Campo CGS n�o informado.";
         $this->erro_campo = "sd109_cgs_und";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($sd109_sequencial!=null){
       $sql .= " sd109_sequencial = $this->sd109_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->sd109_sequencial));
       if ($this->numrows > 0) {

         for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,21871,'$this->sd109_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["sd109_sequencial"]) || $this->sd109_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,3938,21871,'".AddSlashes(pg_result($resaco,$conresaco,'sd109_sequencial'))."','$this->sd109_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["sd109_endereco"]) || $this->sd109_endereco != "")
             $resac = db_query("insert into db_acount values($acount,3938,21872,'".AddSlashes(pg_result($resaco,$conresaco,'sd109_endereco'))."','$this->sd109_endereco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["sd109_cgs_und"]) || $this->sd109_cgs_und != "")
             $resac = db_query("insert into db_acount values($acount,3938,21873,'".AddSlashes(pg_result($resaco,$conresaco,'sd109_cgs_und'))."','$this->sd109_cgs_und',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if (!$result) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Endere�os do CGS n�o Alterado. Altera��o Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->sd109_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Endere�os do CGS n�o foi Alterado. Altera��o Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->sd109_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->sd109_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   public function excluir ($sd109_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if (empty($dbwhere)) {

         $resaco = $this->sql_record($this->sql_query_file($sd109_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,21871,'$sd109_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,3938,21871,'','".AddSlashes(pg_result($resaco,$iresaco,'sd109_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,3938,21872,'','".AddSlashes(pg_result($resaco,$iresaco,'sd109_endereco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,3938,21873,'','".AddSlashes(pg_result($resaco,$iresaco,'sd109_cgs_und'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from cgs_undendereco
                    where ";
     $sql2 = "";
     if (empty($dbwhere)) {
        if (!empty($sd109_sequencial)){
          if (!empty($sql2)) {
            $sql2 .= " and ";
          }
          $sql2 .= " sd109_sequencial = $sd109_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result == false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Endere�os do CGS n�o Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$sd109_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Endere�os do CGS n�o Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$sd109_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$sd109_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   public function sql_record($sql) { 
     $result = db_query($sql);
     if (!$result) {
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_num_rows($result);
      if ($this->numrows == 0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:cgs_undendereco";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   public function sql_query ($sd109_sequencial = null,$campos = "*", $ordem = null, $dbwhere = "") { 

     $sql  = "select {$campos}";
     $sql .= "  from cgs_undendereco ";
     $sql .= "      inner join endereco  on  endereco.db76_sequencial = cgs_undendereco.sd109_endereco";
     $sql .= "      inner join cgs_und  on  cgs_und.z01_i_cgsund = cgs_undendereco.sd109_cgs_und";
     $sql .= "      inner join cadenderlocal  on  cadenderlocal.db75_sequencial = endereco.db76_cadenderlocal";
     $sql .= "      left  join familiamicroarea  on  familiamicroarea.sd35_i_codigo = cgs_und.z01_i_familiamicroarea";
     $sql .= "      inner join cgs  as a on   a.z01_i_numcgs = cgs_und.z01_i_cgsund";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($sd109_sequencial)) {
         $sql2 .= " where cgs_undendereco.sd109_sequencial = $sd109_sequencial "; 
       } 
     } else if (!empty($dbwhere)) {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if (!empty($ordem)) {
       $sql .= " order by {$ordem}";
     }
     return $sql;
  }
   // funcao do sql 
   public function sql_query_file ($sd109_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "") {

     $sql  = "select {$campos} ";
     $sql .= "  from cgs_undendereco ";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($sd109_sequencial)){
         $sql2 .= " where cgs_undendereco.sd109_sequencial = $sd109_sequencial "; 
       } 
     } else if (!empty($dbwhere)) {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if (!empty($ordem)) {
       $sql .= " order by {$ordem}";
     }
     return $sql;
  }

}
