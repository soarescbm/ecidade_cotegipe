---------------------------------------------------------------------------------------------------------------------------
----------------------------------------------- INICIO TRIBUTARIO ---------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------

insert into db_sysarquivo values (3921, 'itbiintermediador', 'Tabela de vinculo para gravar os intermediadores do ITBI.', 'it35', '2016-03-09', 'Tabela de intermediadores do ITBI', 0, 'f', 'f', 'f', 'f');

insert into db_sysarqmod values (36, 3921);

insert into db_syscampo values(21761, 'it35_sequencial', 'int4',         'Identificador do Registro.',                        '0', 'C�digo',      10,  'f', 'f', 'f', 1, 'text', 'C�digo');
insert into db_syscampo values(21762, 'it35_itbi',       'int4',         'Identificador de c�digo ITBI.',                     '0', 'C�digo ITBI', 10,  'f', 'f', 'f', 1, 'text', 'C�digo ITBI');
insert into db_syscampo values(21763, 'it35_cgm',        'varchar(20)',  'Identificador de c�digo CGM.',                      '',  'CGM',         20,  't', 'f', 'f', 0, 'text', 'CGM');
insert into db_syscampo values(21764, 'it35_nome',       'varchar(100)', 'Nodo do intermediador.',                            '',  'Nome',        100, 't', 'f', 'f', 0, 'text', 'Nome');
insert into db_syscampo values(21765, 'it35_cnpj_cpf',   'varchar(14)',  'N�mero referente ao documento do intermediador.',   '',  'CPF/CNPJ',    14,  't', 'f', 'f', 0, 'text', 'CPF/CNPJ');
insert into db_syscampo values(21767, 'it35_creci',      'varchar(10)',  'C�digo CRECI do intermediador.',                    '',  'CRECI',       20,  't', 'f', 'f', 0, 'text', 'CRECI');
insert into db_syscampo values(21768, 'it35_principal',  'bool',         'Identificador de intermediador principal do ITBI.', 'f', 'Principal',   1,   'f', 'f', 'f', 5, 'text', 'Principal');

delete from db_sysarqcamp where codarq = 3921;
insert into db_sysarqcamp values(3921, 21761, 1, 0);
insert into db_sysarqcamp values(3921, 21762, 2, 0);
insert into db_sysarqcamp values(3921, 21763, 3, 0);
insert into db_sysarqcamp values(3921, 21764, 4, 0);
insert into db_sysarqcamp values(3921, 21765, 5, 0);
insert into db_sysarqcamp values(3921, 21767, 6, 0);
insert into db_sysarqcamp values(3921, 21768, 7, 0);

insert into db_syssequencia values(1000556, 'itbiintermediador_it35_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000556 where codarq = 3921 and codcam = 21761;

delete from db_sysprikey where codarq = 3921;
insert into db_sysprikey (codarq, codcam, sequen, camiden) values(3921, 21761, 1, 21761);

delete from db_sysforkey where codarq = 3921 and referen = 0;
insert into db_sysforkey values(3921, 21762, 1, 792, 0);

delete from db_sysforkey where codarq = 3921 and referen = 0;
insert into db_sysforkey values(3921, 21763, 1, 42, 0);

---------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------- INICIO FOLHA ----------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------
insert into db_syscampo values(21780,'rh27_valorlimite','float8','Valor limite para lan�amento manual no ponto.','0', 'Valor limite',10,'f','f','f',4,'text','Valor limite');
insert into db_syscampo values(21781,'rh27_quantidadelimite','float8','Quantidade limite para lan�amento manual no ponto.','0', 'Quantidade limite',10,'f','f','f',4,'text','Quantidade limite');
insert into db_syscampo values(21783,'rh27_tipobloqueio','char(1)','Tipo de Bloqueio','','Tipo de Bloqueio',1,false,true,false,'0','text','Tipo de Bloqueio');
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values (1177, 21780, 27, 0);
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values (1177, 21781, 28, 0);
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values (1177, 21783, 29, 0);
insert into db_syscampodef values(21783,'N','Nenhum');
insert into db_syscampodef values(21783,'A','Aviso');
insert into db_syscampodef values(21783,'B','Bloqueio');

-- Altera nome dos menus de manuten��o do ponto
update db_itensmenu set descricao = 'Por Matr�cula', help = 'Por Matr�cula', desctec = 'Por Matr�cula' where id_item = 4505;
update db_itensmenu set descricao = 'Por Rubrica', help = 'Por Rubrica', desctec = 'Por Rubrica' where id_item = 4513;

-- e-Social - Menus
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10216 ,'e-Social' ,'e-Social' ,'' ,'2' ,'1' ,'M�dulo de integra��o com o e-social.' ,true);
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10218 ,'Cadastro de formul�rios' ,'Cadastro de formul�rios' ,'' ,'1' ,'1' ,'Cadastra formul�rio de resposta.' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10219 ,'Preenchimento do Formul�rio' ,'Preenchimento do Formul�rio' ,'eso4_preenchimento001.php' ,'1' ,'1' ,'Preenche o formul�rio do e-social.' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10220 ,'Confer�ncia de Dados' ,'Confer�ncia de Dados' ,'eso4_conferenciadados001.php' ,'1' ,'1' ,'Confer�ncia dos dados do e-social preenchidos pelos usu�rios.' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10222 ,'Inclus�o' ,'Inclui um formul�rio do e-Social' ,'eso1_cadastroavaliacoes001.php' ,'1' ,'1' ,'Menu para manuten��o dos formul�rios do e-Social.' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10223 ,'Altera��o' ,'Altera um formul�rio do e-Social' ,'eso1_cadastroavaliacoes002.php' ,'1' ,'1' ,'Menu para manuten��o dos formul�rios do e-Social.' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10224 ,'Exclus�o' ,'Exclui um formul�rio do e-Social' ,'eso1_cadastroavaliacoes003.php' ,'1' ,'1' ,'Menu para manuten��o dos formul�rios do e-Social.' ,'true' );

insert into db_modulos( id_item ,nome_modulo ,descr_modulo ,imagem ,temexerc ) values ( 10216 ,'e-Social' ,'e-Social' ,'' ,'true' );

insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (10216,    29,   1, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (10216,    31,   2, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (10216,    30,   3, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (10216,    32,   4, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (   29, 10218, 268, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (   32, 10219, 468, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values (   32, 10220, 469, 10216);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10218 ,10222 ,1 ,10216 );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10218 ,10223 ,2 ,10216 );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10218 ,10224 ,3 ,10216 );

insert into atendcadareamod ( at26_sequencia ,at26_codarea ,at26_id_item ) values ( 76 ,3 ,10216 );

-- e-Social - Tabelas
---------------------- Vinculo entre Pergunta e sugest�o de resposta
insert into db_sysmodulo values (81,'esocial','M�dulo para o e-Social','2016-03-24','t');
insert into db_sysarquivo values (3923, 'avaliacaoperguntadb_formulas', 'Tabela que vincula uma f�rmula para sugerir uma resposta para cada pergunta inserida.', 'eso01', '2016-03-24', 'Tabela de Sugest�o de Respostas', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (81,3923);
insert into db_syscampo values(21789,'eso01_sequencial','int4','C�digo sequencial do v�nculo entre perguntas e f�rmulas','0', 'C�digo',19,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(21790,'eso01_db_formulas','int4','C�digo da f�rmula vinculada.','0', 'F�rmula',19,'f','f','f',1,'text','F�rmula');
insert into db_syscampo values(21791,'eso01_avaliacaopergunta','int4','C�digo da pergunta vinculada.','0', 'Pergunta',19,'f','f','f',1,'text','Pergunta');
insert into db_sysarqcamp values(3923,21789,1,0);
insert into db_sysarqcamp values(3923,21790,2,0);
insert into db_sysarqcamp values(3923,21791,3,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3923,21789,1,21789);
insert into db_sysindices values(4334,'avaliacaoperguntadb_formulas_un_in',3923,'1');
insert into db_syscadind values(4334,21790,1);
insert into db_syscadind values(4334,21791,2);
insert into db_syssequencia values(1000558, 'avaliacaoperguntadb_formulas_eso01_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000558 where codarq = 3923 and codcam = 21789;

-- e-Social - Tabelas
---------------------- Vinculo entre CGM e resposta de uma avalia��o (question�rio e-Social)
insert into db_sysarquivo values (3924, 'avaliacaorespostacgm', 'Tabela que vincula uma resposta de uma pergunta do e-Social para o servidor.', 'eso02', '2016-03-28', 'Vincula uma resposta de avalia��o a um servidor', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (81,3924);
insert into db_syscampo values(21792,'eso02_sequencial','int4','C�digo sequencial �nico para a a tabela de v�nculo entre respostas e cgm.','0', 'C�digo',19,'f','f','f',1,'text','Sequencial');
insert into db_syscampo values(21793,'eso02_avaliacaoresposta','int4','V�nculo com a resposta','0', 'Resposta',19,'f','f','f',1,'text','Resposta');
insert into db_syscampo values(21794,'eso02_cgm','int4','V�nculo com o CGM','0', 'CGM',19,'f','f','f',1,'text','CGM');
insert into db_sysarqcamp values(3924,21792,1,0);
insert into db_sysarqcamp values(3924,21793,2,0);
insert into db_sysarqcamp values(3924,21794,3,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3924,21792,1,21792);
insert into db_sysforkey values(3924,21793,1,2986,0);
insert into db_sysforkey values(3924,21794,1,42,0);
insert into db_sysindices values(4335,'avaliacaorespostacgm_un_in',3924,'1');
insert into db_syscadind values(4335,21793,1);
insert into db_syscadind values(4335,21794,2);
insert into db_syssequencia values(1000559, 'avaliacaorespostacgm_eso02_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000559 where codarq = 3924 and codcam = 21792;

---------------------------------------------------------------------------------------------------------------------------
----------------------------------------------- INICIO EDUCACAO/SAUDE  ----------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------
delete from db_syscampodef where codcam = 20825;
delete from db_syscampodep where codcam = 20825;
delete from db_sysarqcamp where codcam = 20825;
delete from db_syscampo where codcam = 20825;

insert into db_syscampo values(21782,'ed290_diasmanutencaohistorico','int4','Quantidade de dias que a escola anterior � transfer�ncia do aluno possuir� permiss�o de realizar a manuten��o do hist�rico.','0', 'Prazo(dias) para Manuten��o do Hist�rico',10,'f','f','f',1,'text','Prazo(dias) para Manuten��o do Hist�rico');
insert into db_sysarqcamp values(3180,21782,4,0);

update db_syscampo set nomecam = 'ed290_controleprogressaoparcial', conteudo = 'int4', descricao = 'Par�metro que vai controlar qual m�dulo que controlar� as progress�es e depend�ncias. Se for 1 ser� geral para todas as escolas, caso 2 ser� individual para cada departamento. 1 - Secretaria 2 - Escola', valorinicial = '0', rotulo = 'Controle da Progress�o Parcial', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Controle da Progress�o Parcial' where codcam = 19536;
update db_itensmenu set descricao = 'BPA Magn�tico', help = 'BPA Magn�tico'  where id_item in (8752, 6975);