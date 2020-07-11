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

//MODULO: Ambulatorial
//CLASSE DA ENTIDADE sau_agendaexameconfirmaresultado
class cl_sau_agendaexameconfirmaresultado { 
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
   var $s134_i_codigo = 0; 
   var $s134_i_agendaexameconfirma = 0; 
   var $s134_i_examesatributos = 0; 
   var $s134_c_valor = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 s134_i_codigo = int4 = C�digo Sequencial 
                 s134_i_agendaexameconfirma = int4 = C�digo da Conformacao do exame 
                 s134_i_examesatributos = int4 = C�digo do Atributo do Exame 
                 s134_c_valor = varchar(10) = Valor 
                 ";
   //funcao construtor da classe 
   function cl_sau_agendaexameconfirmaresultado() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("sau_agendaexameconfirmaresultado"); 
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
       $this->s134_i_codigo = ($this->s134_i_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["s134_i_codigo"]:$this->s134_i_codigo);
       $this->s134_i_agendaexameconfirma = ($this->s134_i_agendaexameconfirma == ""?@$GLOBALS["HTTP_POST_VARS"]["s134_i_agendaexameconfirma"]:$this->s134_i_agendaexameconfirma);
       $this->s134_i_examesatributos = ($this->s134_i_examesatributos == ""?@$GLOBALS["HTTP_POST_VARS"]["s134_i_examesatributos"]:$this->s134_i_examesatributos);
       $this->s134_c_valor = ($this->s134_c_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["s134_c_valor"]:$this->s134_c_valor);
     }else{
       $this->s134_i_codigo = ($this->s134_i_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["s134_i_codigo"]:$this->s134_i_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($s134_i_codigo){ 
      $this->atualizacampos();
     if($this->s134_i_agendaexameconfirma == null ){ 
       $this->erro_sql = " Campo C�digo da Conformacao do exame nao Informado.";
       $this->erro_campo = "s134_i_agendaexameconfirma";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->s134_i_examesatributos == null ){ 
       $this->erro_sql = " Campo C�digo do Atributo do Exame nao Informado.";
       $this->erro_campo = "s134_i_examesatributos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->s134_c_valor == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "s134_c_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($s134_i_codigo == "" || $s134_i_codigo == null ){
       $result = db_query("select nextval('sau_agendaexameconfirmaresultado_s134_i_codigo_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: sau_agendaexameconfirmaresultado_s134_i_codigo_seq do campo: s134_i_codigo"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->s134_i_codigo = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from sau_agendaexameconfirmaresultado_s134_i_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $s134_i_codigo)){
         $this->erro_sql = " Campo s134_i_codigo maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->s134_i_codigo = $s134_i_codigo; 
       }
     }
     if(($this->s134_i_codigo == null) || ($this->s134_i_codigo == "") ){ 
       $this->erro_sql = " Campo s134_i_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into sau_agendaexameconfirmaresultado(
                                       s134_i_codigo 
                                      ,s134_i_agendaexameconfirma 
                                      ,s134_i_examesatributos 
                                      ,s134_c_valor 
                       )
                values (
                                $this->s134_i_codigo 
                               ,$this->s134_i_agendaexameconfirma 
                               ,$this->s134_i_examesatributos 
                               ,'$this->s134_c_valor' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Confirmacao dos resultados do exame ($this->s134_i_codigo) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Confirmacao dos resultados do exame j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Confirmacao dos resultados do exame ($this->s134_i_codigo) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->s134_i_codigo;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->s134_i_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,14335,'$this->s134_i_codigo','I')");
       $resac = db_query("insert into db_acount values($acount,2522,14335,'','".AddSlashes(pg_result($resaco,0,'s134_i_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2522,14336,'','".AddSlashes(pg_result($resaco,0,'s134_i_agendaexameconfirma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2522,14337,'','".AddSlashes(pg_result($resaco,0,'s134_i_examesatributos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2522,14338,'','".AddSlashes(pg_result($resaco,0,'s134_c_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($s134_i_codigo=null) { 
      $this->atualizacampos();
     $sql = " update sau_agendaexameconfirmaresultado set ";
     $virgula = "";
     if(trim($this->s134_i_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["s134_i_codigo"])){ 
       $sql  .= $virgula." s134_i_codigo = $this->s134_i_codigo ";
       $virgula = ",";
       if(trim($this->s134_i_codigo) == null ){ 
         $this->erro_sql = " Campo C�digo Sequencial nao Informado.";
         $this->erro_campo = "s134_i_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->s134_i_agendaexameconfirma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["s134_i_agendaexameconfirma"])){ 
       $sql  .= $virgula." s134_i_agendaexameconfirma = $this->s134_i_agendaexameconfirma ";
       $virgula = ",";
       if(trim($this->s134_i_agendaexameconfirma) == null ){ 
         $this->erro_sql = " Campo C�digo da Conformacao do exame nao Informado.";
         $this->erro_campo = "s134_i_agendaexameconfirma";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->s134_i_examesatributos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["s134_i_examesatributos"])){ 
       $sql  .= $virgula." s134_i_examesatributos = $this->s134_i_examesatributos ";
       $virgula = ",";
       if(trim($this->s134_i_examesatributos) == null ){ 
         $this->erro_sql = " Campo C�digo do Atributo do Exame nao Informado.";
         $this->erro_campo = "s134_i_examesatributos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->s134_c_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["s134_c_valor"])){ 
       $sql  .= $virgula." s134_c_valor = '$this->s134_c_valor' ";
       $virgula = ",";
       if(trim($this->s134_c_valor) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "s134_c_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($s134_i_codigo!=null){
       $sql .= " s134_i_codigo = $this->s134_i_codigo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->s134_i_codigo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,14335,'$this->s134_i_codigo','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["s134_i_codigo"]) || $this->s134_i_codigo != "")
           $resac = db_query("insert into db_acount values($acount,2522,14335,'".AddSlashes(pg_result($resaco,$conresaco,'s134_i_codigo'))."','$this->s134_i_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["s134_i_agendaexameconfirma"]) || $this->s134_i_agendaexameconfirma != "")
           $resac = db_query("insert into db_acount values($acount,2522,14336,'".AddSlashes(pg_result($resaco,$conresaco,'s134_i_agendaexameconfirma'))."','$this->s134_i_agendaexameconfirma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["s134_i_examesatributos"]) || $this->s134_i_examesatributos != "")
           $resac = db_query("insert into db_acount values($acount,2522,14337,'".AddSlashes(pg_result($resaco,$conresaco,'s134_i_examesatributos'))."','$this->s134_i_examesatributos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["s134_c_valor"]) || $this->s134_c_valor != "")
           $resac = db_query("insert into db_acount values($acount,2522,14338,'".AddSlashes(pg_result($resaco,$conresaco,'s134_c_valor'))."','$this->s134_c_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Confirmacao dos resultados do exame nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->s134_i_codigo;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Confirmacao dos resultados do exame nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->s134_i_codigo;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->s134_i_codigo;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($s134_i_codigo=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($s134_i_codigo));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,14335,'$s134_i_codigo','E')");
         $resac = db_query("insert into db_acount values($acount,2522,14335,'','".AddSlashes(pg_result($resaco,$iresaco,'s134_i_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2522,14336,'','".AddSlashes(pg_result($resaco,$iresaco,'s134_i_agendaexameconfirma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2522,14337,'','".AddSlashes(pg_result($resaco,$iresaco,'s134_i_examesatributos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2522,14338,'','".AddSlashes(pg_result($resaco,$iresaco,'s134_c_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from sau_agendaexameconfirmaresultado
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($s134_i_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " s134_i_codigo = $s134_i_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Confirmacao dos resultados do exame nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$s134_i_codigo;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Confirmacao dos resultados do exame nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$s134_i_codigo;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$s134_i_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:sau_agendaexameconfirmaresultado";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $s134_i_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from sau_agendaexameconfirmaresultado ";
     $sql .= "      inner join sau_examesatributos  on  sau_examesatributos.s132_i_codigo = sau_agendaexameconfirmaresultado.s134_i_examesatributos";
     $sql .= "      inner join sau_agendaexameconfirma  on  sau_agendaexameconfirma.s133_i_codigo = sau_agendaexameconfirmaresultado.s134_i_agendaexameconfirma";
     $sql .= "      inner join sau_exames  on  sau_exames.s108_i_codigo = sau_examesatributos.s131_i_exames";
     $sql .= "      inner join sau_atributoexames  on  sau_atributoexames.s131_i_codigo = sau_examesatributos.s132_i_atributoexames";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = sau_agendaexameconfirma.s133_i_login";
     $sql .= "      inner join sau_agendaexames  on  sau_agendaexames.s113_i_codigo = sau_agendaexameconfirma.s133_i_agendaexames";
     $sql2 = "";
     if($dbwhere==""){
       if($s134_i_codigo!=null ){
         $sql2 .= " where sau_agendaexameconfirmaresultado.s134_i_codigo = $s134_i_codigo "; 
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
   function sql_query_file ( $s134_i_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from sau_agendaexameconfirmaresultado ";
     $sql2 = "";
     if($dbwhere==""){
       if($s134_i_codigo!=null ){
         $sql2 .= " where sau_agendaexameconfirmaresultado.s134_i_codigo = $s134_i_codigo "; 
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