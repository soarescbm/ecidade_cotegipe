<?
//MODULO: acordos
//CLASSE DA ENTIDADE acordocomissaomembro
class cl_acordocomissaomembro {
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
   var $ac07_sequencial = 0;
   var $ac07_acordocomissao = 0;
   var $ac07_numcgm = 0;
   var $ac07_tipomembro = 0;
   var $ac07_datainicio_dia = null;
   var $ac07_datainicio_mes = null;
   var $ac07_datainicio_ano = null;
   var $ac07_datainicio = null;
   var $ac07_datatermino_dia = null;
   var $ac07_datatermino_mes = null;
   var $ac07_datatermino_ano = null;
   var $ac07_datatermino = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 ac07_sequencial = int4 = Sequencial
                 ac07_acordocomissao = int4 = Acordo Comiss�o
                 ac07_numcgm = int4 = N�mero CGM
                 ac07_tipomembro = int4 = Tipo Membro
                 ac07_datainicio = date = Data de In�cio
                 ac07_datatermino = date = Data de T�rmino
                 ";
   //funcao construtor da classe
   function cl_acordocomissaomembro() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("acordocomissaomembro");
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
       $this->ac07_sequencial = ($this->ac07_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_sequencial"]:$this->ac07_sequencial);
       $this->ac07_acordocomissao = ($this->ac07_acordocomissao == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_acordocomissao"]:$this->ac07_acordocomissao);
       $this->ac07_numcgm = ($this->ac07_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_numcgm"]:$this->ac07_numcgm);
       $this->ac07_tipomembro = ($this->ac07_tipomembro == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_tipomembro"]:$this->ac07_tipomembro);
       if($this->ac07_datainicio == ""){
         $this->ac07_datainicio_dia = ($this->ac07_datainicio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_datainicio_dia"]:$this->ac07_datainicio_dia);
         $this->ac07_datainicio_mes = ($this->ac07_datainicio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_datainicio_mes"]:$this->ac07_datainicio_mes);
         $this->ac07_datainicio_ano = ($this->ac07_datainicio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_datainicio_ano"]:$this->ac07_datainicio_ano);
         if($this->ac07_datainicio_dia != ""){
            $this->ac07_datainicio = $this->ac07_datainicio_ano."-".$this->ac07_datainicio_mes."-".$this->ac07_datainicio_dia;
         }
       }
       if($this->ac07_datatermino == ""){
         $this->ac07_datatermino_dia = ($this->ac07_datatermino_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_datatermino_dia"]:$this->ac07_datatermino_dia);
         $this->ac07_datatermino_mes = ($this->ac07_datatermino_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_datatermino_mes"]:$this->ac07_datatermino_mes);
         $this->ac07_datatermino_ano = ($this->ac07_datatermino_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_datatermino_ano"]:$this->ac07_datatermino_ano);
         if($this->ac07_datatermino_dia != ""){
            $this->ac07_datatermino = $this->ac07_datatermino_ano."-".$this->ac07_datatermino_mes."-".$this->ac07_datatermino_dia;
         }
       }
     }else{
       $this->ac07_sequencial = ($this->ac07_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ac07_sequencial"]:$this->ac07_sequencial);
     }
   }
   // funcao para Inclus�o
   function incluir ($ac07_sequencial){
      $this->atualizacampos();
     if($this->ac07_acordocomissao == null ){
       $this->erro_sql = " Campo Acordo Comiss�o n�o informado.";
       $this->erro_campo = "ac07_acordocomissao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac07_numcgm == null ){
       $this->erro_sql = " Campo N�mero CGM n�o informado.";
       $this->erro_campo = "ac07_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac07_tipomembro == null ){
       $this->erro_sql = " Campo Tipo Membro n�o informado.";
       $this->erro_campo = "ac07_tipomembro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($ac07_sequencial == "" || $ac07_sequencial == null ){
       $result = db_query("select nextval('acordocomissaomembro_ac07_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: acordocomissaomembro_ac07_sequencial_seq do campo: ac07_sequencial";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->ac07_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from acordocomissaomembro_ac07_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $ac07_sequencial)){
         $this->erro_sql = " Campo ac07_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ac07_sequencial = $ac07_sequencial;
       }
     }
     if(($this->ac07_sequencial == null) || ($this->ac07_sequencial == "") ){
       $this->erro_sql = " Campo ac07_sequencial n�o declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into acordocomissaomembro(
                                       ac07_sequencial
                                      ,ac07_acordocomissao
                                      ,ac07_numcgm
                                      ,ac07_tipomembro
                                      ,ac07_datainicio
                                      ,ac07_datatermino
                       )
                values (
                                $this->ac07_sequencial
                               ,$this->ac07_acordocomissao
                               ,$this->ac07_numcgm
                               ,$this->ac07_tipomembro
                               ,".($this->ac07_datainicio == "null" || $this->ac07_datainicio == ""?"null":"'".$this->ac07_datainicio."'")."
                               ,".($this->ac07_datatermino == "null" || $this->ac07_datatermino == ""?"null":"'".$this->ac07_datatermino."'")."
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Acordo Comiss�o Membro ($this->ac07_sequencial) n�o Inclu�do. Inclus�o Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Acordo Comiss�o Membro j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Acordo Comiss�o Membro ($this->ac07_sequencial) n�o Inclu�do. Inclus�o Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ac07_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->ac07_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,16141,'$this->ac07_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,2831,16141,'','".AddSlashes(pg_result($resaco,0,'ac07_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2831,16142,'','".AddSlashes(pg_result($resaco,0,'ac07_acordocomissao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2831,16143,'','".AddSlashes(pg_result($resaco,0,'ac07_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2831,16144,'','".AddSlashes(pg_result($resaco,0,'ac07_tipomembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2831,21841,'','".AddSlashes(pg_result($resaco,0,'ac07_datainicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2831,21842,'','".AddSlashes(pg_result($resaco,0,'ac07_datatermino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   }
   // funcao para alteracao
   public function alterar ($ac07_sequencial=null) {
      $this->atualizacampos();
     $sql = " update acordocomissaomembro set ";
     $virgula = "";
     if(trim($this->ac07_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac07_sequencial"])){
       $sql  .= $virgula." ac07_sequencial = $this->ac07_sequencial ";
       $virgula = ",";
       if(trim($this->ac07_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial n�o informado.";
         $this->erro_campo = "ac07_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac07_acordocomissao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac07_acordocomissao"])){
       $sql  .= $virgula." ac07_acordocomissao = $this->ac07_acordocomissao ";
       $virgula = ",";
       if(trim($this->ac07_acordocomissao) == null ){
         $this->erro_sql = " Campo Acordo Comiss�o n�o informado.";
         $this->erro_campo = "ac07_acordocomissao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac07_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac07_numcgm"])){
       $sql  .= $virgula." ac07_numcgm = $this->ac07_numcgm ";
       $virgula = ",";
       if(trim($this->ac07_numcgm) == null ){
         $this->erro_sql = " Campo N�mero CGM n�o informado.";
         $this->erro_campo = "ac07_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac07_tipomembro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac07_tipomembro"])){
       $sql  .= $virgula." ac07_tipomembro = $this->ac07_tipomembro ";
       $virgula = ",";
       if(trim($this->ac07_tipomembro) == null ){
         $this->erro_sql = " Campo Tipo Membro n�o informado.";
         $this->erro_campo = "ac07_tipomembro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac07_datainicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac07_datainicio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ac07_datainicio_dia"] !="") ){
       $sql  .= $virgula." ac07_datainicio = '$this->ac07_datainicio' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["ac07_datainicio_dia"])){
         $sql  .= $virgula." ac07_datainicio = null ";
         $virgula = ",";
       }
     }
     if(trim($this->ac07_datatermino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac07_datatermino_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ac07_datatermino_dia"] !="") ){
       $sql  .= $virgula." ac07_datatermino = '$this->ac07_datatermino' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["ac07_datatermino_dia"])){
         $sql  .= $virgula." ac07_datatermino = null ";
         $virgula = ",";
       }
     }
     $sql .= " where ";
     if($ac07_sequencial!=null){
       $sql .= " ac07_sequencial = $this->ac07_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->ac07_sequencial));
       if ($this->numrows > 0) {

         for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,16141,'$this->ac07_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ac07_sequencial"]) || $this->ac07_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,2831,16141,'".AddSlashes(pg_result($resaco,$conresaco,'ac07_sequencial'))."','$this->ac07_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ac07_acordocomissao"]) || $this->ac07_acordocomissao != "")
             $resac = db_query("insert into db_acount values($acount,2831,16142,'".AddSlashes(pg_result($resaco,$conresaco,'ac07_acordocomissao'))."','$this->ac07_acordocomissao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ac07_numcgm"]) || $this->ac07_numcgm != "")
             $resac = db_query("insert into db_acount values($acount,2831,16143,'".AddSlashes(pg_result($resaco,$conresaco,'ac07_numcgm'))."','$this->ac07_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ac07_tipomembro"]) || $this->ac07_tipomembro != "")
             $resac = db_query("insert into db_acount values($acount,2831,16144,'".AddSlashes(pg_result($resaco,$conresaco,'ac07_tipomembro'))."','$this->ac07_tipomembro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ac07_datainicio"]) || $this->ac07_datainicio != "")
             $resac = db_query("insert into db_acount values($acount,2831,21841,'".AddSlashes(pg_result($resaco,$conresaco,'ac07_datainicio'))."','$this->ac07_datainicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["ac07_datatermino"]) || $this->ac07_datatermino != "")
             $resac = db_query("insert into db_acount values($acount,2831,21842,'".AddSlashes(pg_result($resaco,$conresaco,'ac07_datatermino'))."','$this->ac07_datatermino',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if (!$result) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Acordo Comiss�o Membro n�o Alterado. Altera��o Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ac07_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Acordo Comiss�o Membro n�o foi Alterado. Altera��o Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ac07_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ac07_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   public function excluir ($ac07_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if (empty($dbwhere)) {

         $resaco = $this->sql_record($this->sql_query_file($ac07_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,16141,'$ac07_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,2831,16141,'','".AddSlashes(pg_result($resaco,$iresaco,'ac07_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2831,16142,'','".AddSlashes(pg_result($resaco,$iresaco,'ac07_acordocomissao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2831,16143,'','".AddSlashes(pg_result($resaco,$iresaco,'ac07_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2831,16144,'','".AddSlashes(pg_result($resaco,$iresaco,'ac07_tipomembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2831,21841,'','".AddSlashes(pg_result($resaco,$iresaco,'ac07_datainicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2831,21842,'','".AddSlashes(pg_result($resaco,$iresaco,'ac07_datatermino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from acordocomissaomembro
                    where ";
     $sql2 = "";
     if (empty($dbwhere)) {
        if (!empty($ac07_sequencial)){
          if (!empty($sql2)) {
            $sql2 .= " and ";
          }
          $sql2 .= " ac07_sequencial = $ac07_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result == false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Acordo Comiss�o Membro n�o Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ac07_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Acordo Comiss�o Membro n�o Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ac07_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ac07_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:acordocomissaomembro";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   public function sql_query ($ac07_sequencial = null,$campos = "*", $ordem = null, $dbwhere = "") {

     $sql  = "select {$campos}";
     $sql .= "  from acordocomissaomembro ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = acordocomissaomembro.ac07_numcgm";
     $sql .= "      inner join acordocomissao  on  acordocomissao.ac08_sequencial = acordocomissaomembro.ac07_acordocomissao";
     $sql .= "      inner join acordocomissaotipomembro  on  acordocomissaotipomembro.ac42_sequencial = acordocomissaomembro.ac07_tipomembro";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($ac07_sequencial)) {
         $sql2 .= " where acordocomissaomembro.ac07_sequencial = $ac07_sequencial ";
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
   public function sql_query_file ($ac07_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "") {

     $sql  = "select {$campos} ";
     $sql .= "  from acordocomissaomembro ";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($ac07_sequencial)){
         $sql2 .= " where acordocomissaomembro.ac07_sequencial = $ac07_sequencial ";
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

  public function sql_query_acordo($sCampos = "*", $sWhere = null, $sOrdem = null) {

    $sSql  = "select {$sCampos}";
    $sSql .= "  from acordocomissaomembro ";
    $sSql .= "      inner join acordocomissao  on  acordocomissao.ac08_sequencial = acordocomissaomembro.ac07_acordocomissao";
    $sSql .= "      inner join acordo on ac08_sequencial = ac16_acordocomissao";
    $sSql .= "      inner join acordoposicao         on ac26_acordo          = ac16_sequencial";
    $sSql .= "      inner join acordoitem            on ac20_acordoposicao   = ac26_sequencial";
    $sSql .= "      inner join cgm  on  cgm.z01_numcgm =   acordocomissaomembro.ac07_numcgm";
    $sSql .= "      inner join acordocomissaotipomembro  on  acordocomissaotipomembro.ac42_sequencial = acordocomissaomembro.ac07_tipomembro";
    $sSql .= "      left join acordoencerramentolicitacon on ac16_sequencial = ac58_acordo";

    if ($sWhere) {
      $sSql .= " where {$sWhere} ";
    }

    if ($sOrdem) {
      $sSql .= " order by {$sOrdem} ";
    }

    return $sSql;
  }
}
