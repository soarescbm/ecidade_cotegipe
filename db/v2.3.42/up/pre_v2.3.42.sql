delete from db_menu where id_item_filho in(9793,9794,9795,9788,9789,9790,9791,9827,9795);
delete from db_menu where id_item_filho = 9827 AND modulo = 952;
delete from db_sysarqcamp where codarq = 3374 and codcam in(19062, 19063);

insert into db_sysarquivo values (3872, 'tipoassentamentoferias', 'Tipos de Assentamentos para F�rias', 'rh168', '2015-09-03', 'Tipos de Assentamentos para F�rias', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (29,3872);
insert into db_syscampo values(21573,'rh168_sequencial','int4','C�digo Sequencial','0', 'C�digo Sequencial',10,'f','f','f',1,'text','C�digo Sequencial');
insert into db_syscampo values(21574,'rh168_tipoassentamentoferias','int4','Assentamento para F�rias','0', 'Assentamento para F�rias',10,'t','f','f',1,'text','Assentamento para F�rias');
insert into db_syscampo values(21575,'rh168_tipoassentamentoabono','int4','Assentamento para Abono','0', 'Assentamento para Abono',10,'t','f','f',1,'text','Assentamento para Abono');
insert into db_sysarqcamp values(3872,21573,1,0);
insert into db_sysarqcamp values(3872,21574,2,0);
insert into db_sysarqcamp values(3872,21575,3,0);
delete from db_sysprikey where codarq = 3872;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3872,21573,1,21574);
delete from db_sysforkey where codarq = 3872 and referen = 0;
insert into db_sysforkey values(3872,21574,1,596,0);
insert into db_sysindices values(4287,'tipoassentamentoferias_assenta_ferias_in',3872,'0');
insert into db_syscadind values(4287,21574,1);
insert into db_sysindices values(4288,'tipoassentamentoferias_assenta_abono_in',3872,'0');
insert into db_syscadind values(4288,21575,1);
insert into db_syssequencia values(1000520, 'tipoassentamentoferias_rh168_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000520 where codarq = 3872 and codcam = 21573;

--tabela rhferiasperiodoassentamento
insert into db_sysarquivo values (3873, 'rhferiasperiodoassentamento', 'Assentamos do Periodo de gozo', 'rh169', '2015-09-03', 'Assentamos do Periodo de gozo', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (29,3873);
insert into db_syscampo values(21576,'rh169_sequencial','int4','C�digo Sequencial','0', 'C�digo Sequencial',10,'f','f','f',1,'text','C�digo Sequencial');
insert into db_syscampo values(21577,'rh169_rhferiasperiodo','int4','Periodo de Gozo','0', 'Periodo de Gozo',10,'f','f','f',1,'text','Periodo de Gozo');
insert into db_syscampo values(21578,'rh169_assenta','int4','Assentamento','0', 'Assentamento',10,'f','f','f',1,'text','Assentamento');
delete from db_sysarqcamp where codarq = 3873;
insert into db_sysarqcamp values(3873,21576,1,0);
insert into db_sysarqcamp values(3873,21577,2,0);
insert into db_sysarqcamp values(3873,21578,3,0);
delete from db_sysprikey where codarq = 3873;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3873,21576,1,21576);
delete from db_sysforkey where codarq = 3873 and referen = 0;
insert into db_sysforkey values(3873,21577,1,3374,0);
delete from db_sysforkey where codarq = 3873 and referen = 0;
insert into db_sysforkey values(3873,21578,1,528,0);
insert into db_sysindices values(4289,'rhferiasperiodoassentamento_rhferiasperiodo_in',3873,'0');
insert into db_syscadind values(4289,21577,1);
insert into db_sysindices values(4290,'rhferiasperiodoassentamento_assenta_in',3873,'0');
insert into db_syscadind values(4290,21578,1);
insert into db_syssequencia values(1000521, 'rhferiasperiodoassentamento_rh169_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000521 where codarq = 3873 and codcam = 21576;

-- Menus
insert into db_menu ( id_item ,id_item_filho ,menusequencia, modulo) values (32   , 9788 ,461,2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia, modulo) VALUES (9790 , 9791 , 1 ,2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia, modulo) VALUES (9790 , 9792 , 1 ,2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia, modulo) VALUES (9788 , 9789 , 1 ,2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia, modulo) VALUES (9788 , 9790 , 2 ,2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo) values (9788 , 10156, 6 ,2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo) values (9788 , 10157, 7, 2323);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo) values (9788 , 10158, 8, 2323);

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10156 ,'Configura��o de Assentamentos' ,'Par�metros para F�rias' ,'rec4_parametrosassentamentoferias001.php' ,'1' ,'1' ,'Parametros para F�rias' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) 
values ( 
  10157 ,
  'Gera��o de Per�odos Aquisitivos' ,
  'Gera��o de Per�odos Aquisitivos' ,
  'rec4_gerarperiodoaquisitivo001.php' ,
  '1' ,
  '1' ,
  'Importa periodo aquisitivo para os servidores selecionados' ,
  false );

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) 
values ( 
  10158 ,
  'Autoriza��o de F�rias' ,
  'Autoriza��o de F�rias' ,
  'rec4_autorizarferias001.php' ,
  '1' ,
  '1' ,
  'Importa periodo aquisitivo para os servidores selecionados' ,
  false );

-- Cria��o dos menus para Processamento de F�rias e Rubricas para escala de f�rias
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10159 ,'Rubrica para Escala de F�rias' ,'Par�metros para Escala de F�rias' ,'pes4_rubricasescalaferias001.php' ,'1' ,'1' ,'Rotina para a manuten��o de par�metros para a escala de f�rias. Nesta rotina ser� poss�vel cadastrar a Rubrica e Base para ser utilizado no novo c�lculo de f�rias.' ,'false' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1818 ,10159 ,112 ,952 );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 3516 ,10159 ,11 ,952 );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10160 ,'Processar F�rias' ,'Realiza o Processamento de F�rias' ,'pes4_processarferias001.php' ,'1' ,'1' ,'Rotina criada para realizar o processamento de f�rias, ap�s as f�rias serem liberadas no RH, elas podem ser processadas no pessoal para ent�o serem lan�ados no ponto do servidor.' ,'false' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1818 ,10160 ,113 ,952 );

--Cria��o do campo para a rubrica de escala de ferias
insert into db_syscampo values(21582,'r11_rubricaescalaferias','varchar(4)','Campo para cadastro da rubrica para a escala de f�rias','', 'Rubrica para Escala de F�rias',4,'t','t','f',0,'text','Rubrica para Escala de F�rias');
insert into db_sysarqcamp values(536,21582,90,0);

update db_syscampo set descricao = 'Dias a abonar', rotulo = 'Dias a abonar' where codcam = 18975;

--Alterando o nome do menu de f�rias de ferias(novo) para ferias
update db_itensmenu set descricao = 'F�rias' where id_item = 9788;
