---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO EDUCACAO ------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

select fc_executa_ddl('insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10252 ,\'Escolas da Rede\' ,\'Atestado para alunos da Rede\' ,\'\' ,\'1\' ,\'1\' ,\'Gera um atestado para alunos da Rede.\' ,\'true\' )');
select fc_executa_ddl('delete from db_menu where id_item_filho = 10252 AND modulo = 1100747');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1101103 ,10252 ,3 ,1100747 )');
select fc_executa_ddl('insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10253 ,\'Outras Escolas\' ,\'Atestado para alunos de fora da Rede.\' ,\'edu4_atestadovagafora001.php\' ,\'1\' ,\'1\' ,\'Gera um atestado para alunos de fora da Rede.\' ,\'true\' )');
select fc_executa_ddl('delete from db_menu where id_item_filho = 10253 AND modulo = 1100747');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1101103 ,10253 ,4 ,1100747 )');

select fc_executa_ddl('delete from db_menu where id_item_filho = 6981 AND modulo = 1100747');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10252 ,6981 ,1 ,1100747 )');

select fc_executa_ddl('delete from db_menu where id_item_filho = 6982 AND modulo = 1100747');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10252 ,6982 ,2 ,1100747 )');

---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL EDUCACAO ------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
--------------------------------------- INICIO FINANCEIRO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

update db_syscampo set rotulo = 'N�mero do Processo', rotulorel = 'N�mero do Processo' where nomecam = 'ac16_numeroprocesso';

insert into db_sysarquivo select 3954, 'empnotasuspensao', 'Informa��es referentes as notas de liquida��o suspensas das listas de classifica��o de credores.', 'cc36', '2016-08-03', 'Suspens�o de Nota de Liquida��o', 0, 'f', 'f', 'f', 'f' where not exists(select 1 from db_sysarquivo where codarq = 3954);
insert into db_sysarqmod select 38, 3954 where not exists (select 1 from db_sysarqmod where (codmod, codarq) = (38,3954));

insert into db_syscampo select 21966 ,'cc36_sequencial' ,'int4' ,'C�digo' ,'' ,'Codigo' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Codigo' where not exists (select 1 from db_syscampo where codcam = 21966);
insert into db_sysarqcamp select 3954 ,21966 ,1 ,0 where not exists (select 1 from db_sysarqcamp where (codarq, codcam, seqarq) = (3954 ,21966 ,1));

insert into db_syscampo select 21967 ,'cc36_empnota' ,'int4' ,'Nota de Liquida��o' ,'' ,'Nota de Liquida��o' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Nota de Liquida��o' where not exists (select 1 from db_syscampo where codcam = 21967 );
insert into db_sysarqcamp select 3954 ,21967 ,2 ,0  where not exists (select 1 from db_sysarqcamp where (codarq, codcam, seqarq) = (3954 ,21967 ,2));

insert into db_syscampo select 21968 ,'cc36_justificativasuspensao' ,'text' ,'Justificativa de Suspens�o' ,'' ,'Justificativa de Suspens�o' ,1 ,'false' ,'false' ,'false' ,0 ,'text' ,'Justificativa de Suspens�o' where not exists (select 1 from db_syscampo where codcam = 21968 );
insert into db_sysarqcamp select 3954 ,21968 ,3 ,0 where not exists (select 1 from db_sysarqcamp where (codarq, codcam, seqarq) = (3954 ,21968 ,3));

insert into db_syscampo select 21969 ,'cc36_datasuspensao' ,'date' ,'Data de Suspens�o' ,'' ,'Data de Suspens�o' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Data de Suspens�o' where not exists (select 1 from db_syscampo where codcam = 21969);
insert into db_sysarqcamp select 3954 ,21969 ,4 ,0 where not exists (select 1 from db_sysarqcamp where (codarq, codcam, seqarq) = (3954 ,21969 ,4));

insert into db_syscampo select 21970 ,'cc36_justificativaretorno' ,'text' ,'Justificativa de Retorno' ,'' ,'Justificativa de Retorno' ,1 ,'true' ,'false' ,'false' ,0 ,'text' ,'Justificativa de Retorno' where not exists (select 1 from db_syscampo where codcam = 21970);
insert into db_sysarqcamp select 3954 ,21970 ,5 ,0 where not exists (select 1 from db_sysarqcamp where (codarq, codcam, seqarq) = (3954 ,21970 ,5));

insert into db_syscampo select 21971 ,'cc36_dataretorno' ,'date' ,'Data de Retorno' ,'' ,'Data de Retorno' ,10 ,'true' ,'false' ,'false' ,1 ,'text' ,'Data de Retorno' where not exists (select 1 from db_syscampo where codcam = 21971);
insert into db_sysarqcamp select 3954 ,21971 ,6 ,0 where not exists (select 1 from db_sysarqcamp where (codarq, codcam, seqarq) = (3954 ,21971 ,6));

insert into db_sysprikey select 3954,21966,1,21966 where not exists (select 1 from db_sysprikey where (codarq, codcam, sequen) = (3954,21966,1));

insert into db_syssequencia select 1000589, 'empnotasuspensao_cc36_sequencial_seq', 1, 1, 9223372036854775807, 1, 1 where not exists (select 1 from db_syssequencia  where codsequencia = 1000589);
update db_sysarqcamp set codsequencia = 1000589 where codarq = 3954 and codcam = 21966;

insert into db_sysforkey select 3954,21967,1,971,0 where not exists (select 1 from db_sysforkey where (codarq, codcam, sequen, referen) = (3954,21967,1,971));

insert into db_itensmenu select 10254 ,'Suspens�o da Classifica��o de Credores' ,'Suspens�o da Classifica��o de Credores' ,'emp4_suspensaopagamentonota001.php' ,'1' ,'1' ,'Suspens�o da Classifica��o de Credores' ,'true' where not exists (select 1 from db_itensmenu where id_item = 10254);
insert into db_menu select 32 ,10254 ,471 ,398 where not exists (select 1 from db_menu where (id_item, id_item_filho, modulo) = (32 ,10254 , 398));

insert into db_itensmenu select 10262, 'Notas de Liquida��o Suspensas', 'Notas de Liquida��o Suspensas', 'cai3_notaliquidacaosuspensa001.php', '1', '1', 'Nota de Liquida��o Suspensas', '1'	where not exists (select 1 from db_itensmenu where id_item = 10262);
insert into db_itensfilho select 10262,1 where not exists (select 1 from db_itensfilho where (id_item, codfilho) = (10262,1));
insert into db_menu select 30,10262,453,39 where not exists (select 1 from db_menu where (id_item, id_item_filho, modulo) = (30,10262,39));


select fc_executa_ddl('
  update db_itensmenu set descricao = \'Reprocessar Saldo de Contas\', help = \'Reprocessa o saldo das contas correntes j� existentes\', funcao = \'con4_reprocessacontacorrente001.php\', itemativo = \'1\', desctec = \'Reprocessa o saldo das contas correntes j� existentes\', libcliente = \'1\' where id_item = 9683;
  delete from db_itensfilho where id_item = 9683;
  insert into db_itensfilho values(9683,1);
  insert into db_itensmenu values( 10265, \'Processar\', \'Cria novas contas correntes\', \'con4_processarcontacorrente001.php\', \'1\', \'1\', \'\', true );
  insert into db_itensfilho (id_item, codfilho) values(10265,1);
  delete from db_menu where id_item_filho = 10265 AND modulo = 209;
  insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 9680 ,10265 ,3 ,209 );
');

---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL FINANCEIRO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
--------------------------------------- INICIO TRIBUTARIO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 21959 ,'k170_valor' ,'float4' ,'Valor Compensado' ,'' ,'k170_valor' ,10 ,'false' ,'false' ,'false' ,4 ,'text' ,'k170_valor' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3859 ,21959 ,7 ,0 );

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10256 ,'Compensa��o' ,'Compensa��o' ,'arr4_compensarCredito001.php' ,'1' ,'1' ,'Compensa��o' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 9625 ,10256 ,5 ,1985522 );

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10263 ,'Relat�rio de Compensa��es' ,'Relat�rio de Compensa��es' ,'arr2_relatoriocompensacoes001.php' ,'1' ,'1' ,'Relat�rio de Compensa��es' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 30 ,10263 ,454 ,1985522 );

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10264 ,'Relat�rio de Devolu��es' ,'Relat�rio de Devolu��es' ,'arr2_relatoriodevolucoes001.php' ,'1' ,'1' ,'Relat�rio de Devolu��es' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 30 ,10264 ,455 ,1985522 );

update db_syscampo set aceitatipo = 4 where codcam = 192;

---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL TRIBUTARIO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------


---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO FOLHA ---------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

--Menus e Dic Dados da tarefa de concess�o de direitos
select fc_executa_ddl('update db_syscampo set nulo = true where codcam = 21801');
select fc_executa_ddl('update db_syscampo set nulo = true where codcam = 21802;');
select fc_executa_ddl('insert into db_syscampo values (21954,\'h82_formulaprorrogafim\',\'int4\',\'Formula que calcula data final do afastamento, contando a prorroga��o da data fina por faltas, licen�as, etc\',\'0\', \'F�rmula de Prorroga��o do Fim\',10,\'t\',\'f\',\'f\',1,\'text\',\'F�rmula de Prorroga��o do Fim\');');
select fc_executa_ddl('insert into db_sysarqcamp values(3835,21954,9,0)');

select fc_executa_ddl('insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10250 ,\'Concess�o de Direitos\' ,\'Concess�o de Direitos\' ,\'\' ,\'1\' ,\'1\' ,\'Concess�o de Direitos\' ,\'true\' );');
select fc_executa_ddl('delete from db_menu where id_item_filho = 10250 AND modulo = 2323;');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 32 ,10250 ,470 ,2323 );');
select fc_executa_ddl('update db_itensmenu set id_item = 10114 , descricao = \'Processamento\', help = \'Processamento\' where id_item = 10114;');
select fc_executa_ddl('delete from db_menu where id_item_filho = 10114 AND modulo = 2323;');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10250 ,10114 ,1 ,2323 );');
select fc_executa_ddl('update db_itensmenu set id_item = 10113 , descricao = \'Par�metros\' , help = \'Par�metros\' where id_item = 10113;');
select fc_executa_ddl('delete from db_menu where id_item_filho = 10113 AND modulo = 2323;');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10250 ,10113 ,2 ,2323 );');

select fc_executa_ddl('insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10251 ,\'Previs�o de Direitos\' ,\'Previs�o de Direitos\' ,\'rec2_previsaodedireitos001.php\' ,\'1\' ,\'1\' ,\'Previs�o de Direitos\' ,\'true\' );');
select fc_executa_ddl('delete from db_menu where id_item_filho = 10251 AND modulo = 2323;');
select fc_executa_ddl('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 30 ,10251 ,452 ,2323 );');
update db_syscampo set conteudo = 'float4' where codcam = 20927;


--Menu Evento financeiro Autom�tico
insert into db_itensmenu select 10255 ,'Evento Financeiro Autom�tico' ,'Configura��o de Eventos Financeiros Autom�ticos' ,'pes4_eventofinanceiroautomatico001.php' ,'1' ,'1' ,'Configura��o dos Eventos financeiros que devem ser lan�ados automaticamente em um determinado m�s.' ,'true' from db_itensmenu where not exists (select 1 from db_itensmenu where id_item = 10255) limit 1;
insert into db_menu select 3516 ,10255 ,15 ,952 from db_menu where not exists (select 1 from db_menu where id_item_filho = 10255) limit 1;

-- Tabela eventofinanceiroautomatico
insert into db_sysarquivo select 3955, 'eventofinanceiroautomatico', 'Tabela que armazena os dados de configura��o para eventos financeiros automaticos', 'rh181', '2016-08-04', 'Evento Financeiro Automatico', 0, 'f', 'f', 'f', 'f' from db_sysarquivo where not exists (select 1 from db_sysarquivo where codarq = 3955) limit 1;
insert into db_sysarqmod select 28,3955 from db_sysarqmod where not exists (select 1 from db_sysarqmod where codarq = 3955) limit 1;
insert into db_syscampo select 21972,'rh181_sequencial','int4','Sequencial da configura��o dos eventos financeiros automaticos','0', 'Sequ�ncial',10,'f','f','t',1,'text','Sequ�ncial' from db_syscampo where not exists (select 1 from db_syscampo where codcam = 21972) limit 1;
insert into db_syscampo select 21973,'rh181_descricao','varchar(56)','Descri��o do evento financeiro automatico','', 'Descri��o',56,'f','f','f',0,'text','Descri��o' from db_syscampo where not exists (select 1 from db_syscampo where codcam = 21973) limit 1;
insert into db_syscampo select 21974,'rh181_rubrica','varchar(4)','Rubrica a ser lan�ado no pondo de sal�rio','', 'Rubrica',4,'f','f','f',3,'text','Rubrica' from db_syscampo where not exists (select 1 from db_syscampo where codcam = 21974) limit 1;
insert into db_syscampo select 21975,'rh181_mes','int4','M�s de lan�amento do evento financeiro','0', 'M�s',2,'f','f','f',1,'text','M�s' from db_syscampo where not exists (select 1 from db_syscampo where codcam = 21975) limit 1;
insert into db_syscampo select 21976,'rh181_selecao','int4','Sele��o para qual deve ser lan�ado o evento financeiro','0', 'Sele��o',10,'f','f','f',1,'text','Sele��o' from db_syscampo where not exists (select 1 from db_syscampo where codcam = 21976) limit 1;
insert into db_syscampo select 21977,'rh181_instituicao','int4','Institui��o a qual esta configura��o pertence','0', 'Institui��o',20,'f','f','f',1,'text','Institui��o' from db_syscampo where not exists (select 1 from db_syscampo where codcam = 21977) limit 1;
insert into db_sysarqcamp select 3955,21972,1,0 from db_sysarqcamp where not exists (select 1 from db_sysarqcamp where codcam = 21972) limit 1;
insert into db_sysarqcamp select 3955,21973,2,0 from db_sysarqcamp where not exists (select 1 from db_sysarqcamp where codcam = 21973) limit 1;
insert into db_sysarqcamp select 3955,21974,3,0 from db_sysarqcamp where not exists (select 1 from db_sysarqcamp where codcam = 21974) limit 1;
insert into db_sysarqcamp select 3955,21975,4,0 from db_sysarqcamp where not exists (select 1 from db_sysarqcamp where codcam = 21975) limit 1;
insert into db_sysarqcamp select 3955,21976,5,0 from db_sysarqcamp where not exists (select 1 from db_sysarqcamp where codcam = 21976) limit 1;
insert into db_sysarqcamp select 3955,21977,6,0 from db_sysarqcamp where not exists (select 1 from db_sysarqcamp where codcam = 21977) limit 1;
insert into db_sysprikey (codarq,codcam,sequen,camiden) select 3955,21972,1,21972 from db_sysprikey where not exists (select 1 from db_sysprikey where codarq = 3955) limit 1;
insert into db_sysindices select 4372,'eventofinanceiroautomatico_rubrica_mes_selecao_instituicao_un',3955,'1' from db_sysindices where not exists (select 1 from db_sysindices where codind = 4372) limit 1;
insert into db_syscadind select 4372,21974,1 from db_syscadind where not exists(select 1 from db_syscadind where codcam = 21974) limit 1;
insert into db_syscadind select 4372,21975,2 from db_syscadind where not exists(select 1 from db_syscadind where codcam = 21975) limit 1;
insert into db_syscadind select 4372,21976,3 from db_syscadind where not exists(select 1 from db_syscadind where codcam = 21976) limit 1;
insert into db_syscadind select 4372,21977,4 from db_syscadind where not exists(select 1 from db_syscadind where codcam = 21977) limit 1;
insert into db_sysforkey select 3955,21976,1,591,0 from db_sysforkey where not exists (select 1 from db_sysforkey where codcam = 21976 and referen = 591) limit 1;
insert into db_sysforkey select 3955,21977,2,591,0 from db_sysforkey where not exists (select 1 from db_sysforkey where codcam = 21977 and referen = 591) limit 1;
insert into db_sysforkey select 3955,21977,1,83,0 from db_sysforkey where not exists (select 1 from db_sysforkey where codcam = 21977 and referen = 83) limit 1;
insert into db_sysforkey select 3955,21974,1,1177,0 from db_sysforkey where not exists (select 1 from db_sysforkey where codcam = 21974 and referen = 1177) limit 1;
insert into db_sysforkey select 3955,21977,2,1177,0 from db_sysforkey where not exists (select 1 from db_sysforkey where codcam = 21977 and referen = 1177) limit 1;
insert into db_syssequencia select 1000590, 'eventofinanceiroautomatico_rh181_sequencial_seq', 1, 1, 9223372036854775807, 1, 1 from db_syssequencia where not exists (select 1 from db_syssequencia where codsequencia = 1000590) limit 1;
update db_sysarqcamp set codsequencia = 1000590 where codarq = 3955 and codcam = 21972;


--
-- Melhoria para consignados
-- Menus
update db_itensmenu set id_item = 10232 , descricao = 'Manuten��o de Empr�stimos Consignados' where id_item = 10232;
delete from db_menu where id_item_filho = 10232;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (1818, 10232, 10, 952);

insert into db_itensmenu select 10257 ,'Conv�nios' ,'Outras integra��es de consignados' ,'' ,'1' ,'1' ,'Outras integra��es de consignados, exemplo: consignet e e-consig' ,'true' from db_itensmenu where not exists (select 1 from db_itensmenu where id_item = 10257) limit 1;
delete from db_menu where id_item_filho = 10257 AND modulo = 952;
insert into db_menu select 10232 ,10257 ,5 ,952 from db_menu where not exists (select 1 from db_menu where id_item = 10232 and id_item_filho = 10257 and menusequencia = 5 and modulo = 952) limit 1;
delete from db_menu where id_item_filho = 10049 AND modulo = 952;
insert into db_menu select 10257, 10049, 1, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10257 and id_item_filho = 10049 and menusequencia = 1 and modulo = 952) limit 1;
delete from db_menu where id_item_filho = 9866 AND modulo = 952;
insert into db_menu select 10257, 9866, 2, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10257 and id_item_filho = 9866 and menusequencia = 2 and modulo = 952) limit 1;

insert into db_itensmenu select 10258 ,'Gest�o de Consignados' ,'Gest�o de Consignados' ,'' ,'1' ,'1' ,'Menu para a ger�ncia/gest�o de contratos consignados que n�o s�o realizados via importa��o de arquivo.' ,'true' from db_itensmenu where not exists (select 1 from db_itensmenu where id_item = 10258) limit 1;
delete from db_menu where id_item_filho = 10258 AND modulo = 952;
insert into db_menu select 10232, 10258, 6, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10232 and id_item_filho = 10258 and menusequencia = 6 and modulo = 952) limit 1;
insert into db_itensmenu select 10259 ,'Manuten��o de Contratos' ,'Manuten��o de Contratos' ,'pes4_manutencaocontratosconsignados.php' ,'1' ,'1' ,'Rotina para gerenciar manualmente a inclus�o de descontos consignados.' ,'true' from db_itensmenu where not exists (select 1 from db_itensmenu where id_item = 10259) limit 1;
delete from db_menu where id_item_filho = 10259 AND modulo = 952;
insert into db_menu select 10258, 10259, 1, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10258 and id_item_filho = 10259 and menusequencia = 1 and modulo = 952) limit 1;
delete from db_menu where id_item_filho = 10238 AND modulo = 952;
insert into db_menu select 10258, 10238, 2, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10258 and id_item_filho = 10238 and menusequencia = 2 and modulo = 952) limit 1;

insert into db_itensmenu select 10260 ,'Arquivos' ,'Importa��o de arquivos consignados' ,'' ,'1' ,'1' ,'Importa��o de arquivos consignados' ,'true' from db_itensmenu where not exists (select 1 from db_itensmenu where id_item = 10260) limit 1;
delete from db_menu where id_item_filho = 10260 AND modulo = 952;
insert into db_menu select 10232, 10260, 7, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10232 and id_item_filho = 10260 and menusequencia = 7 and modulo = 952) limit 1;
delete from db_menu where id_item_filho = 10234 AND modulo = 952;
insert into db_menu select 10260, 10234, 1, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10260 and id_item_filho = 10234 and menusequencia = 1 and modulo = 952) limit 1;
update db_itensmenu set id_item = 10235 , descricao = 'Exportar' where id_item = 10235;
delete from db_menu where id_item_filho = 10235 AND modulo = 952;
insert into db_menu select 10260, 10235, 2, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10260 and id_item_filho = 10235 and menusequencia = 2 and modulo = 952) limit 1;

insert into db_itensmenu select 10261 ,'Par�metros' ,'Par�metros' ,'' ,'1' ,'1' ,'Par�metros de configura��o para importa��o de arquivos, rubrica layout e banco s�o configurados.' ,'true' from db_itensmenu where not exists (select 1 from db_itensmenu where id_item = 10261) limit 1;
delete from db_menu where id_item_filho = 10261 AND modulo = 952;
insert into db_menu select 10232, 10261, 8, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10232 and id_item_filho = 10261 and menusequencia = 8 and modulo = 952) limit 1;
delete from db_menu where id_item_filho = 10231 AND modulo = 952;
insert into db_menu select 10261, 10231, 1, 952 from db_menu where not exists (select 1 from db_menu where id_item = 10261 and id_item_filho = 10231 and menusequencia = 1 and modulo = 952) limit 1;


update db_itensmenu set id_item = 10232 , descricao = 'Consignados' where id_item = 10232;
delete from db_menu where id_item_filho IN (10032, 10066, 10059);
delete from db_menu where id_item_filho IN (10232, 9866, 10049, 10238, 10234, 10235, 10231);

insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (5106, 10049, 17, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (5106, 10232, 18, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (5106,  9866, 15, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10232, 10234, 1, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10232, 10238, 2, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10232, 10235, 3, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (1818, 10032, 105, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (1818, 10059, 106, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (1818, 10066, 107, 952);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (3516, 10231, 14, 952);

insert into db_itensmenu select 10270,'Manuten��o de Empr�stimos Consignados','Rotina para manuten��o de empr�stimos consignados.','','1','1','Rotina para manuten��o de empr�stimos consignados.','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10270) limit 1;
delete from db_menu where id_item_filho = 10270 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (1818, 10270, 10, 952);

insert into db_itensmenu select 10271,'Consignet','Rotinas de arquivos de consigna��o para DB1','','1','1','Menu com as rotinas de gera��o, importa��o e exporta��o de arquivos para o consignet da empresa DB1','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10271) limit 1;
delete from db_menu where id_item_filho = 10271 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (10257, 10271, 3, 952);

insert into db_itensmenu select 10272,'E-Consig','E-Consig','','1','1','Menu criado para gera��o de arquivo do e-consig','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10272) limit 1;
delete from db_menu where id_item_filho = 10272 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (10257, 10272, 4, 952);

insert into db_itensmenu select 10273,'Confer�ncia de Dados','Confer�ncia de Dados','pes4_conferenciaconsignados001.php','1','1','Confer�ncia de Dados','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10273) limit 1;
delete from db_menu where id_item_filho = 10273 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (10258, 10273, 3, 952);

insert into db_itensmenu select 10274,'Importar','Importar dados do arquivo','pes4_importararquivoconsignado001.php','1','1','Importar dados do arquivo','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10274) limit 1;
delete from db_menu where id_item_filho = 10274 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (10260, 10274, 3, 952);

insert into db_itensmenu select 10275,'Exportar','Exportar os dados do arquivo','pes4_exportararquivoconsignado001.php','1','1','Exportar os dados do arquivo','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10275) limit 1;
delete from db_menu where id_item_filho = 10275 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (10260, 10275, 4, 952);

insert into db_itensmenu select 10276,'Configura��o Consignados','Configura��o Consignados','pes4_configurararquivoconsignado001.php','1','1','Configura�ao das consigna�oes em folha','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10276) limit 1;
delete from db_menu where id_item_filho = 10276 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo ) values (10261, 10276, 2, 952);

delete from db_menu where id_item_filho = 10257 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10270, 10257, 1, 952);
delete from db_menu where id_item_filho = 10258 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10270, 10258, 2, 952);
delete from db_menu where id_item_filho = 10260 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10270, 10260, 3, 952);
delete from db_menu where id_item_filho = 10261 AND modulo = 952;
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values (10270, 10261, 4, 952);

insert into db_itensmenu select 10277,'Processamento de Dados do Ponto','Processamento de Dados do Ponto','pes4_processamentodadosponto001.php','1','1','Rotina responsav�l pelo lan�amento dos dados nas tabelas do ponto.','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10277) limit 1;
delete from db_menu where id_item_filho = 10277 AND modulo = 952;
insert into db_menu (id_item ,id_item_filho,menusequencia, modulo) values (4504, 10277, 6, 952);
insert into db_itensmenu select 10278,'Registros do Ponto em Lote','Lan�ar rubricas em lote','','1','1','Menu para lan�amento de r�bricas em lote, lan�amento pode ser feito por r�brica ou por servidor.','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10278) limit 1;
delete from db_menu where id_item_filho = 10278 AND modulo = 952;
insert into db_menu (id_item ,id_item_filho,menusequencia, modulo) values (4504, 10278, 7, 952);
insert into db_itensmenu select 10279,'Manuten��o do Lote','Manuten��o do Lote','pes4_manutencaolotesinicio001.php','1','1','Menu para criar e fechar lotes e lancar, alterar e excluir registros de um lote. Registro seria um lan�amento do ponto.','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10279) limit 1;
delete from db_menu where id_item_filho = 10279 AND modulo = 952;
insert into db_menu (id_item ,id_item_filho,menusequencia, modulo) values (10278, 10279, 1, 952);
insert into db_itensmenu select 10280,'Processar Lote','Processar Lote','pes4_processamento_loteregistroponto.php','1','1','Menu utilizado para confirmar, cancelar, excluir um lote de registros do ponto.','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10280) limit 1;
delete from db_menu where id_item_filho = 10280 AND modulo = 952;
insert into db_menu (id_item ,id_item_filho,menusequencia, modulo) values (10278, 10280, 2, 952);
insert into db_itensmenu select 10281,'Lan�amento de Assentamentos no Ponto','Lan�amento de Assentamentos no Ponto','pes4_assentaloteregistroponto001.php','1','1','Menu utilizado para selecionar os assentamentos que ser�o pagos.','true' from db_itensmenu where NOT EXISTS (select 1 from db_itensmenu where id_item = 10281) limit 1;
delete from db_menu where id_item_filho = 10281 AND modulo = 952;
insert into db_menu (id_item ,id_item_filho,menusequencia, modulo) values (4504, 10281, 8, 952);

update db_itensmenu set funcao = funcao||'?menuDepreciado=true' where id_item IN (10061,10032,10060,10234,10235,10231,10238,10066);



--TABELA
insert into db_sysarquivo select 3956, 'rhconsignadomovimentomanual', 'Tabela para guardar os contratos consignados inclu�dos manualmente sem rotina de importa��o', 'rh182', '2016-08-11', 'rhconsignadomovimentomanual', 0, 'f', 'f', 'f', 'f' from db_sysarquivo where NOT EXISTS (select 1 from db_sysarquivo where codarq = 3956) limit 1;
delete from db_sysarqmod where codmod = 28 and codarq = 3956;
insert into db_sysarqmod values (28,3956);
insert into db_syscampo select 21869,'rh151_arquivo','oid','Conteudo do Arquivo','','Conteudo do Arquivo',1,'true','false','false',1,'text','Conteudo do Arquivo' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21869) limit 1;
insert into db_syscampo select 21870,'rh151_banco','varchar(10)','Banco','','Banco',10,'true','false','false',0,'text','Banco' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21870) limit 1;
insert into db_syscampo select 21978,'rh182_rhconsignadomovimento','int4','Sequencial da tabela rhconsignadomovimento','0', 'Sequencial Contrato',19,'f','f','f',1,'text','Sequencial Contrato' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21978) limit 1;
insert into db_syscampo select 21979,'rh182_rhconsignadomovimentoservidor','int4','Sequencial da tabela rhconsignadomovimentoservidor','0', 'Sequencial da Parcela',19,'f','f','f',1,'text','Sequencial da Parcela' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21979) limit 1;
insert into db_syscampo select 21980,'rh182_processado','bool','Campo que determina se a parcela foi ou n�o processada.','f', 'Flag de processamento',1,'f','f','f',5,'text','Flag de processamento' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21980) limit 1;
insert into db_syscampo select 21981,'rh182_ano','int4','Ano da compet�ncia','0', 'Ano da compet�ncia',4,'f','f','f',1,'text','Ano da compet�ncia' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21981) limit 1;
insert into db_syscampo select 21982,'rh182_mes','int4','M�s da compet�ncia','0', 'M�s da compet�ncia',2,'f','f','f',1,'text','M�s da compet�ncia' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21982) limit 1;
insert into db_syscampo select 21983,'rh182_sequencial','int4','Sequencial da tabela para falicitar manuten��o','0', 'Sequencial',19,'f','f','f',1,'text','Sequencial' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21983) limit 1;
insert into db_syscampodef select 21980,'0','' from db_syscampodef where NOT EXISTS (select 1 from db_syscampodef where codcam = 21980) limit 1;
delete from db_sysarqcamp where codarq = 3956;
insert into db_sysarqcamp values(3956,21983,1,0);
insert into db_sysarqcamp values(3956,21978,2,0);
insert into db_sysarqcamp values(3956,21979,3,0);
insert into db_sysarqcamp values(3956,21980,4,0);
insert into db_sysarqcamp values(3956,21981,5,0);
insert into db_sysarqcamp values(3956,21982,6,0);
delete from db_sysprikey where codarq = 3956 and codcam = 21983 and sequen = 1;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3956,21983,1,21983);
delete from db_sysforkey where codarq = 3956;
insert into db_sysforkey values(3956,21978,1,3785,0);
insert into db_sysforkey values(3956,21979,1,3786,0);
insert into db_sysindices select 4374,'rhconsignadomovimentomanual_un_in',3956,'1' from db_sysindices where NOT EXISTS (select 1 from db_sysindices where codind = 4374) limit 1;
delete from db_syscadind where codind = 4374;
insert into db_syscadind values(4374,21978,1);
insert into db_syscadind values(4374,21979,2);
insert into db_syscadind values(4374,21981,3);
insert into db_syscadind values(4374,21982,4);
insert into db_syssequencia select 1000591, 'rhconsignadomovimentomanual_rh182_sequencial_seq', 1, 1, 9223372036854775807, 1, 1 from db_syssequencia where NOT EXISTS (select 1 from db_syssequencia where codsequencia = 1000591) limit 1;
update db_sysarqcamp set codsequencia = 1000591 where codarq = 3956 and codcam = 21983;

insert into db_syscampo select 21984,'rh151_tipoconsignado','char(1)','Informa se o tipo de consignado � de origem de importa��o de arquivo ou inclu�do manualmente.','', 'Tipo do Consignado',1,'t','t','f',0,'text','Tipo do Consignado' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21984) limit 1;
insert into db_syscampo select 21985,'rh151_consignadoorigem','int4','Campo utilizado para referenciar quem � o consignado que deu origem a este, utilizado em casos de refinanciamentos e portabilidades.','0', 'C�digo do consignado de origem',19,'t','f','f',1,'text','C�digo do consignado de origem' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21985) limit 1;
insert into db_syscampo select 21986,'rh151_situacao','char(1)','Informa se � um consignado normal, ou refinanciamento ou portabilidade ou se foi cancelado.','', 'Situa��o do consignado',1,'t','t','f',0,'text','Situa��o do consignado' from db_syscampo where NOT EXISTS (select 1 from db_syscampo where codcam = 21986) limit 1;
delete from db_sysarqcamp where codarq = 3785;
insert into db_sysarqcamp values(3785,21005,1,1000441);
insert into db_sysarqcamp values(3785,21006,2,0);
insert into db_sysarqcamp values(3785,21007,3,0);
insert into db_sysarqcamp values(3785,21008,4,0);
insert into db_sysarqcamp values(3785,21009,5,0);
insert into db_sysarqcamp values(3785,21010,6,0);
insert into db_sysarqcamp values(3785,21011,7,0);
insert into db_sysarqcamp values(3785,21869,8,0);
insert into db_sysarqcamp values(3785,21870,9,0);
insert into db_sysarqcamp values(3785,21984,10,0);
insert into db_sysarqcamp values(3785,21985,11,0);
insert into db_sysarqcamp values(3785,21986,12,0);

insert into db_sysarquivo
     values (3950, 'atolegalprevidencia', 'Atos legais cadastrados para previd�ncia com base no Siprev.', 'rh179', '2016-07-13', 'Ato Legal da Previd�ncia', 0, 'f', 'f', 'f', 'f' ),
            (3951, 'atolegalprevidenciainssirf', 'V�nculo do ato legal com uma previd�ncia', 'rh180', '2016-07-13', 'Previd�ncia do Ato Legal', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod
     values (28,3950),
            (28,3951);
insert into db_syscampo
     values (21941,'rh179_sequencial','int4','C�digo do Ato Legal','0', 'C�digo do Ato Legal',10,'f','f','f',1,'text','C�digo do Ato Legal'),
            (21942,'rh179_descricao','varchar(60)','Descri��o do Ato Legal.','', 'Descri��o',60,'f','t','f',0,'text','Descri��o'),
            (21943,'rh180_sequencial','int4','C�digo sequencial de atolegalprevidenciainssirf','0', 'C�digo',10,'f','f','f',1,'text','C�digo'),
            (21950,'rh180_instituicao','int4','C�digo da Institui��o','0', 'C�digo da Institui��o',10,'f','f','f',1,'text','C�digo da Institui��o'),
            (21944,'rh180_inssirf','int4','C�digo de v�nculo da tabela inssirf','0', 'INSSIRF',10,'f','f','f',1,'text','INSSIRF'),
            (21945,'rh180_atolegal','int4','C�digo referente a tabela atolegalprevidencia','0', 'Ato Legal',10,'f','f','f',1,'text','Ato Legal'),
            (21946,'rh180_numero','int8','N�mero do Ato','0', 'N�mero do Ato',10,'f','f','f',1,'text','N�mero do Ato'),
            (21947,'rh180_ano','int4','Ano do Ato Legal','0', 'Ano',10,'f','f','f',1,'text','Ano'),
            (21948,'rh180_datapublicacao','date','Data de Publica��o do Ato Legal','null', 'Data de Publica��o',10,'f','f','f',1,'text','Data de Publica��o'),
            (21949,'rh180_datainiciovigencia','date','Data de In�cio de Vig�ncia do Ato Legal','null', 'Data de In�cio de Vig�ncia',10,'f','f','f',1,'text','Data de In�cio de Vig�ncia'),
            (21955,'h36_tempocontribuicaorgps','int4','Tipo de assentamento para o tempo de contribui��o do RGPS na integra��o com o SIPREV.','0', 'Tempo de Contribui��o RGPS',10,'t','f','f',1,'text','Tempo de Contribui��o RGPS'),
            (21956,'h36_tempocontribuicaorpps','int4','Tipo de assentamento para o tempo de contribui��o do RPPS na integra��o com o SIPREV.','0', 'Tempo de Contribui��o RPPS',10,'t','f','f',1,'text','Tempo de Contribui��o RPPS'),
            (21957,'h36_temposficticios','int4','Tipo de assentamento para os tempos fict�cios na integra��o com o SIPREV.','0', 'Tempos Fict�cios',10,'t','f','f',1,'text','Tempos Fict�cios'),
            (21958,'h36_temposemcontribuicao','int4','Tipo de assentamento para o tempo sem contribui��o na integra��o com o SIPREV.','0', 'Tempo sem Contribui��o',10,'t','f','f',1,'text','Tempo sem Contribui��o'),
            (21963,'r11_basefgintegral','int4','Base Fun��o Gratificada Integral','0', 'Base Fun��o Gratificada Integral',10,'t','f','f',1,'text','Base Fun��o Gratificada Integral'),
            (21964,'r11_basefgparcial','int4','Base Fun��o Gratificada Parcial','0', 'Base Fun��o Gratificada Parcial',10,'t','f','f',1,'text','Base Fun��o Gratificada Parcial');
insert into db_syssequencia
     values (1000585, 'atolegalprevidencia_rh179_sequencial_seq', 1, 1, 9223372036854775807, 1, 1),
            (1000586, 'atolegalprevidenciainssirf_rh180_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
insert into db_sysarqcamp
     values (3950,    21941,    1,      1000585),
            (3950,    21942,    2,      0),
            (3951,    21943,    1,      1000586),
            (3951,    21950,    2,      0),
            (3951,    21944,    3,      0),
            (3951,    21945,    4,      0),
            (3951,    21946,    5,      0),
            (3951,    21947,    6,      0),
            (3951,    21948,    7,      0),
            (3951,    21949,    8,      0),
            (2117,    21955,    8,      0),
            (2117,    21956,    9,      0),
            (2117,    21957,    10,     0),
            (536,     21963,    97,     0),
            (536,     21964,    98,     0),
            (2117,    21958,    11,     0);
insert into db_sysprikey (codarq,codcam,sequen,camiden)
    values (3950,21941,1,21942),
           (3951,21943,1,21944);
insert into db_sysforkey
     values (2117,21955,1,596,0),
            (2117,21956,1,596,0),
            (2117,21957,1,596,0),
            (2117,21958,1,596,0),
            (3951,21944,1,561,0),
            (3951,21950,2,561,0),
            (3951,21945,1,3950,0);
insert into db_sysindices
     values (4366,'rhparam_tempocontribuicaorgps_in',2117,'0'),
            (4367,'rhparam_tempocontribuicaorpps_in',2117,'0'),
            (4368,'rhparam_temposficticios_in',2117,'0'),
            (4369,'rhparam_temposemcontribuicao_in',2117,'0'),
            (4364,'atolegalprevidenciainssirf_atolegal_in',3951,'0'),
            (4363,'atolegalprevidenciainssirf_inssirf_instituicao_in',3951,'1');
insert into db_syscadind
     values (4366,21955,1),
            (4367,21956,1),
            (4368,21957,1),
            (4369,21958,1),
            (4363,21944,1),
            (4364,21945,1),
            (4363,21950,2);
update db_itensmenu set descricao = 'SIPREV' WHERE id_item = 8747;
---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL FOLHA ----------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO SAUDE ---------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
insert into db_syscampo
     select 21987,'z01_registromunicipio','bool','Controla se o CGS � do munic�pio','t', 'CGS do Munic�pio',1,'f','f','f',5,'text','CGS do Munic�pio'
       from db_syscampo
      where not exists(select 1 from db_syscampo where nomecam = 'z01_registromunicipio') limit 1;

insert into db_sysarqcamp
     select 1010144, 21987, 80, 0
       from db_sysarqcamp
      where not exists(select 1 from db_sysarqcamp where codarq = 1010144 and codcam = 21987) limit 1;
---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL SAUDE ----------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
