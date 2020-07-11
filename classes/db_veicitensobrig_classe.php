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

//MODULO: veiculos
//CLASSE DA ENTIDADE veicitensobrig
class cl_veicitensobrig { 
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
   var $ve09_sequencial = 0; 
   var $ve09_usuario = 0; 
   var $ve09_veiccaditensobrig = 0; 
   var $ve09_veiculos = 0; 
   var $ve09_dtinc_dia = null; 
   var $ve09_dtinc_mes = null; 
   var $ve09_dtinc_ano = null; 
   var $ve09_dtinc = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 ve09_sequencial = int4 = C�d. Sequencial 
                 ve09_usuario = int4 = Usu�rio 
                 ve09_veiccaditensobrig = int4 = Item 
                 ve09_veiculos = int4 = Veiculo 
                 ve09_dtinc = date = Data 
                 ";
   //funcao construtor da classe 
   function cl_veicitensobrig() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("veicitensobrig"); 
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
       $this->ve09_sequencial = ($this->ve09_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_sequencial"]:$this->ve09_sequencial);
       $this->ve09_usuario = ($this->ve09_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_usuario"]:$this->ve09_usuario);
       $this->ve09_veiccaditensobrig = ($this->ve09_veiccaditensobrig == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_veiccaditensobrig"]:$this->ve09_veiccaditensobrig);
       $this->ve09_veiculos = ($this->ve09_veiculos == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_veiculos"]:$this->ve09_veiculos);
       if($this->ve09_dtinc == ""){
         $this->ve09_dtinc_dia = ($this->ve09_dtinc_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_dtinc_dia"]:$this->ve09_dtinc_dia);
         $this->ve09_dtinc_mes = ($this->ve09_dtinc_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_dtinc_mes"]:$this->ve09_dtinc_mes);
         $this->ve09_dtinc_ano = ($this->ve09_dtinc_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_dtinc_ano"]:$this->ve09_dtinc_ano);
         if($this->ve09_dtinc_dia != ""){
            $this->ve09_dtinc = $this->ve09_dtinc_ano."-".$this->ve09_dtinc_mes."-".$this->ve09_dtinc_dia;
         }
       }
     }else{
       $this->ve09_sequencial = ($this->ve09_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ve09_sequencial"]:$this->ve09_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($ve09_sequencial){ 
      $this->atualizacampos();
     if($this->ve09_usuario == null ){ 
       $this->erro_sql = " Campo Usu�rio nao Informado.";
       $this->erro_campo = "ve09_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ve09_veiccaditensobrig == null ){ 
       $this->erro_sql = " Campo Item nao Informado.";
       $this->erro_campo = "ve09_veiccaditensobrig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ve09_veiculos == null ){ 
       $this->erro_sql = " Campo Veiculo nao Informado.";
       $this->erro_campo = "ve09_veiculos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ve09_dtinc == null ){ 
       $this->erro_sql = " Campo Data nao Informado.";
       $this->erro_campo = "ve09_dtinc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($ve09_sequencial == "" || $ve09_sequencial == null ){
       $result = db_query("select nextval('veicitensobrig_ve09_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: veicitensobrig_ve09_sequencial_seq do campo: ve09_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ve09_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from veicitensobrig_ve09_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $ve09_sequencial)){
         $this->erro_sql = " Campo ve09_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ve09_sequencial = $ve09_sequencial; 
       }
     }
     if(($this->ve09_sequencial == null) || ($this->ve09_sequencial == "") ){ 
       $this->erro_sql = " Campo ve09_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into veicitensobrig(
                                       ve09_sequencial 
                                      ,ve09_usuario 
                                      ,ve09_veiccaditensobrig 
                                      ,ve09_veiculos 
                                      ,ve09_dtinc 
                       )
                values (
                                $this->ve09_sequencial 
                               ,$this->ve09_usuario 
                               ,$this->ve09_veiccaditensobrig 
                               ,$this->ve09_veiculos 
                               ,".($this->ve09_dtinc == "null" || $this->ve09_dtinc == ""?"null":"'".$this->ve09_dtinc."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Itens orbigat�rios ($this->ve09_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Itens orbigat�rios j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Itens orbigat�rios ($this->ve09_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ve09_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->ve09_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,11093,'$this->ve09_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,1912,11093,'','".AddSlashes(pg_result($resaco,0,'ve09_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1912,11094,'','".AddSlashes(pg_result($resaco,0,'ve09_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1912,11095,'','".AddSlashes(pg_result($resaco,0,'ve09_veiccaditensobrig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1912,11096,'','".AddSlashes(pg_result($resaco,0,'ve09_veiculos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1912,11097,'','".AddSlashes(pg_result($resaco,0,'ve09_dtinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($ve09_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update veicitensobrig set ";
     $virgula = "";
     if(trim($this->ve09_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve09_sequencial"])){ 
       $sql  .= $virgula." ve09_sequencial = $this->ve09_sequencial ";
       $virgula = ",";
       if(trim($this->ve09_sequencial) == null ){ 
         $this->erro_sql = " Campo C�d. Sequencial nao Informado.";
         $this->erro_campo = "ve09_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ve09_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve09_usuario"])){ 
       $sql  .= $virgula." ve09_usuario = $this->ve09_usuario ";
       $virgula = ",";
       if(trim($this->ve09_usuario) == null ){ 
         $this->erro_sql = " Campo Usu�rio nao Informado.";
         $this->erro_campo = "ve09_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ve09_veiccaditensobrig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve09_veiccaditensobrig"])){ 
       $sql  .= $virgula." ve09_veiccaditensobrig = $this->ve09_veiccaditensobrig ";
       $virgula = ",";
       if(trim($this->ve09_veiccaditensobrig) == null ){ 
         $this->erro_sql = " Campo Item nao Informado.";
         $this->erro_campo = "ve09_veiccaditensobrig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ve09_veiculos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve09_veiculos"])){ 
       $sql  .= $virgula." ve09_veiculos = $this->ve09_veiculos ";
       $virgula = ",";
       if(trim($this->ve09_veiculos) == null ){ 
         $this->erro_sql = " Campo Veiculo nao Informado.";
         $this->erro_campo = "ve09_veiculos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ve09_dtinc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve09_dtinc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ve09_dtinc_dia"] !="") ){ 
       $sql  .= $virgula." ve09_dtinc = '$this->ve09_dtinc' ";
       $virgula = ",";
       if(trim($this->ve09_dtinc) == null ){ 
         $this->erro_sql = " Campo Data nao Informado.";
         $this->erro_campo = "ve09_dtinc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["ve09_dtinc_dia"])){ 
         $sql  .= $virgula." ve09_dtinc = null ";
         $virgula = ",";
         if(trim($this->ve09_dtinc) == null ){ 
           $this->erro_sql = " Campo Data nao Informado.";
           $this->erro_campo = "ve09_dtinc_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($ve09_sequencial!=null){
       $sql .= " ve09_sequencial = $this->ve09_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->ve09_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,11093,'$this->ve09_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve09_sequencial"]))
           $resac = db_query("insert into db_acount values($acount,1912,11093,'".AddSlashes(pg_result($resaco,$conresaco,'ve09_sequencial'))."','$this->ve09_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve09_usuario"]))
           $resac = db_query("insert into db_acount values($acount,1912,11094,'".AddSlashes(pg_result($resaco,$conresaco,'ve09_usuario'))."','$this->ve09_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve09_veiccaditensobrig"]))
           $resac = db_query("insert into db_acount values($acount,1912,11095,'".AddSlashes(pg_result($resaco,$conresaco,'ve09_veiccaditensobrig'))."','$this->ve09_veiccaditensobrig',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve09_veiculos"]))
           $resac = db_query("insert into db_acount values($acount,1912,11096,'".AddSlashes(pg_result($resaco,$conresaco,'ve09_veiculos'))."','$this->ve09_veiculos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve09_dtinc"]))
           $resac = db_query("insert into db_acount values($acount,1912,11097,'".AddSlashes(pg_result($resaco,$conresaco,'ve09_dtinc'))."','$this->ve09_dtinc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens orbigat�rios nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ve09_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens orbigat�rios nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ve09_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ve09_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($ve09_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($ve09_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,11093,'$ve09_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,1912,11093,'','".AddSlashes(pg_result($resaco,$iresaco,'ve09_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1912,11094,'','".AddSlashes(pg_result($resaco,$iresaco,'ve09_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1912,11095,'','".AddSlashes(pg_result($resaco,$iresaco,'ve09_veiccaditensobrig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1912,11096,'','".AddSlashes(pg_result($resaco,$iresaco,'ve09_veiculos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1912,11097,'','".AddSlashes(pg_result($resaco,$iresaco,'ve09_dtinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from veicitensobrig
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($ve09_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " ve09_sequencial = $ve09_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens orbigat�rios nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ve09_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens orbigat�rios nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ve09_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ve09_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:veicitensobrig";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $ve09_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from veicitensobrig ";
     $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = veicitensobrig.ve09_veiculos";
     $sql .= "      inner join veiccaditensobrig on veiccaditensobrig.ve08_sequencial = veicitensobrig.ve09_veiccaditensobrig";
     $sql .= "      inner join veiccentral       on veiccentral.ve40_veiculos      = veiculos.ve01_codigo";
     $sql .= "      inner join veiccadcentral    on veiccadcentral.ve36_sequencial = veiccentral.ve40_veiccadcentral";
     $sql .= "      inner join db_depart         on db_depart.coddepto             = veiccadcentral.ve36_coddepto";
     $sql .= "      inner join ceplocalidades  on  ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades";
     $sql .= "      inner join veiccadtipo  on  veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo";
     $sql .= "      inner join veiccadmarca  on  veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca";
     $sql .= "      inner join veiccadmodelo  on  veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo";
     $sql .= "      inner join veiccadcor  on  veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor";
     $sql .= "      inner join veiccadtipocapacidade  on  veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade";
     $sql .= "      inner join veiccadcategcnh  on  veiccadcategcnh.ve30_codigo = veiculos.ve01_veiccadcategcnh";
     $sql .= "      inner join veiccadproced  on  veiccadproced.ve25_codigo = veiculos.ve01_veiccadproced";
     $sql .= "      inner join veiccadpotencia  on  veiccadpotencia.ve31_codigo = veiculos.ve01_veiccadpotencia";
     $sql .= "      inner join veiccadcateg  as a on   a.ve32_codigo = veiculos.ve01_veiccadcateg";
     $sql .= "      inner join veictipoabast  on  veictipoabast.ve07_sequencial = veiculos.ve01_veictipoabast";
     $sql .= "      left  join veicitensobrigbaixa on veicitensobrigbaixa.ve10_veicitensobrig = veicitensobrig.ve09_sequencial";
     $sql2 = "";
     if($dbwhere==""){
       if($ve09_sequencial!=null ){
         $sql2 .= " where veicitensobrig.ve09_sequencial = $ve09_sequencial "; 
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
   function sql_query_file ( $ve09_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from veicitensobrig ";
     $sql2 = "";
     if($dbwhere==""){
       if($ve09_sequencial!=null ){
         $sql2 .= " where veicitensobrig.ve09_sequencial = $ve09_sequencial "; 
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
   function sql_query_naobaixados ( $ve09_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from veicitensobrig ";
     $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = veicitensobrig.ve09_veiculos";
     $sql .= "      inner join veiccaditensobrig  on  veiccaditensobrig.ve08_sequencial = veicitensobrig.ve09_veiccaditensobrig";
     $sql .= "      inner join veiccentral    on veiccentral.ve40_veiculos      = veiculos.ve01_codigo";
     $sql .= "      inner join veiccadcentral on veiccadcentral.ve36_sequencial = veiccentral.ve40_veiccadcentral";
     $sql .= "      inner join db_depart      on db_depart.coddepto             = veiccadcentral.ve36_coddepto";
     $sql .= "      inner join ceplocalidades  on  ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades";
     $sql .= "      inner join veiccadtipo  on  veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo";
     $sql .= "      inner join veiccadmarca  on  veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca";
     $sql .= "      inner join veiccadmodelo  on  veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo";
     $sql .= "      inner join veiccadcor  on  veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor";
     $sql .= "      inner join veiccadtipocapacidade  on  veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade";
     $sql .= "      inner join veiccadcategcnh  on  veiccadcategcnh.ve30_codigo = veiculos.ve01_veiccadcategcnh";
     $sql .= "      inner join veiccadproced  on  veiccadproced.ve25_codigo = veiculos.ve01_veiccadproced";
     $sql .= "      inner join veiccadpotencia  on  veiccadpotencia.ve31_codigo = veiculos.ve01_veiccadpotencia";
     $sql .= "      inner join veiccadcateg  as a on   a.ve32_codigo = veiculos.ve01_veiccadcateg";
     $sql .= "      inner join veictipoabast  on  veictipoabast.ve07_sequencial = veiculos.ve01_veictipoabast";
     $sql .= "      left  join veicitensobrigbaixa on veicitensobrigbaixa.ve10_veicitensobrig = veicitensobrig.ve09_sequencial";
     $sql2 = "";
     if($dbwhere==""){
       if($ve09_sequencial!=null ){
         $sql2 .= " where veicitensobrig.ve09_sequencial = $ve09_sequencial "; 
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
   function sql_query_obrigatorio( $ve09_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from veicitensobrig ";
     $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = veicitensobrig.ve09_veiculos";
     $sql .= "      inner join veiccaditensobrig on veiccaditensobrig.ve08_sequencial = veicitensobrig.ve09_veiccaditensobrig";
     $sql .= "      left join veiccentral       on veiccentral.ve40_veiculos      = veiculos.ve01_codigo";
     $sql .= "      left join veiccadcentral    on veiccadcentral.ve36_sequencial = veiccentral.ve40_veiccadcentral";
     $sql .= "      left join db_depart         on db_depart.coddepto             = veiccadcentral.ve36_coddepto";
     $sql .= "      inner join ceplocalidades  on  ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades";
     $sql .= "      inner join veiccadtipo  on  veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo";
     $sql .= "      inner join veiccadmarca  on  veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca";
     $sql .= "      inner join veiccadmodelo  on  veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo";
     $sql .= "      inner join veiccadcor  on  veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor";
     $sql .= "      inner join veiccadtipocapacidade  on  veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade";
     $sql .= "      inner join veiccadcategcnh  on  veiccadcategcnh.ve30_codigo = veiculos.ve01_veiccadcategcnh";
     $sql .= "      inner join veiccadproced  on  veiccadproced.ve25_codigo = veiculos.ve01_veiccadproced";
     $sql .= "      inner join veiccadpotencia  on  veiccadpotencia.ve31_codigo = veiculos.ve01_veiccadpotencia";
     $sql .= "      inner join veiccadcateg  as a on   a.ve32_codigo = veiculos.ve01_veiccadcateg";
     $sql .= "      inner join veictipoabast  on  veictipoabast.ve07_sequencial = veiculos.ve01_veictipoabast";
     $sql .= "      left  join veicitensobrigbaixa on veicitensobrigbaixa.ve10_veicitensobrig = veicitensobrig.ve09_sequencial";
     $sql2 = "";
if($dbwhere==""){
       if($ve09_sequencial!=null ){
         $sql2 .= " where veicitensobrig.ve09_sequencial = $ve09_sequencial ";
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