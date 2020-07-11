---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO EDUCACAO ------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
insert into db_syscampo values(21910,'bi26_impressora','int4','Define qual o tamanho do papel deve ser impresso os comprovantes de empr�stimos e devolu��es.','1', 'Impress�o de Comprovantes',10,'t','f','f',1,'text','Impress�o de Comprovantes');
insert into db_sysarqcamp values(2138,21910,4,0);

update db_menu set menusequencia = 1 where id_item = 1100625 and modulo = 1100625 and id_item_filho = 3470;
update db_menu set menusequencia = 2 where id_item = 1100625 and modulo = 1100625 and id_item_filho = 1797;
update db_menu set menusequencia = 3 where id_item = 1100625 and modulo = 1100625 and id_item_filho = 31;
update db_menu set menusequencia = 4 where id_item = 1100625 and modulo = 1100625 and id_item_filho = 1818;

update db_layoutcampos set db52_layoutformat = 15
 where db52_codigo in (13333, 13260, 13504, 13503, 13502, 13501, 13625, 13623, 13621, 13620, 13355, 13354, 13351, 13348 );


insert into db_sysarquivo values (3948, 'idioma', 'lista de idiomas', 'bi22', '2016-07-04', 'Idioma', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (1008002,3948);
insert into db_syscampo values(21925,'bi22_sequencial','int4','C�digo sequencial','0', 'C�digo',10,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(21926,'bi22_idioma','varchar(50)','Idioma','', 'Idioma',50,'f','t','f',0,'text','Idioma');
insert into db_sysarqcamp values(3948, 21925, 1, 0);
insert into db_sysarqcamp values(3948, 21926, 2, 0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3948,21925,1,21925);
insert into db_syssequencia values(1000583, 'idioma_bi22_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000583 where codarq = 3948 and codcam = 21925;
insert into db_sysindices values(4362,'idioma_idioma_in',3948,'1');
insert into db_syscadind values(4362,21926,1);

insert into db_syscampo values(21927,'bi06_idioma','int4','Idioma do acervo','0', 'Idioma',10,'f','f','f',1,'text','Idioma');
insert into db_sysarqcamp values(1008014,21927,15,0);
insert into db_sysforkey values(1008014,21927,1,3948,0);

insert into db_syscampo values(21939,'ed73_valorreal','float8','Valor real da avalia��o do aluno sem que seja alterada pela proporcionalidade.','0', 'Valor Real',15,'t','f','f',4,'text','Valor Real');
insert into db_syscampo values(21940,'ed233_apresentarnotaproporcional','bool','Par�metro para verificar se deve mostrar a nota proporcional do aluno ou a nota real.','true', 'Apresentar Nota Proporcional',1,'f','f','f',5,'text','Apresentar Nota Proporcional');
insert into db_sysarqcamp values(1010120,21939,9,0);
insert into db_sysarqcamp values(2019,21940,16,0);


---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL EDUCACAO ------------------------------------------------------
---------------------------------------------------------------------------------------------------------------


---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO FINANCEIRO ----------------------------------------------------
---------------------------------------------------------------------------------------------------------------


insert into db_sysarquivo values (3945, 'pagfornumeracao', 'Controle da numera��o do PAGFOR (Bradesco)', 'o152', '2016-06-23', 'pagfornumeracao', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (5,3945);
insert into db_syscampo values(21911,'o152_sequencial','int4','C�digo Sequencial','0', 'C�digo',10,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(21912,'o152_instit','int4','C�digo sequencial da institui��o','0', 'C�digo da Institui��o',10,'f','f','f',1,'text','C�digo da Institui��o');
insert into db_syscampo values(21913,'o152_numero','int4','Numera��o Atual','0', 'Numera��o Atual',10,'f','f','f',1,'text','Numera��o Atual');
insert into db_syscampo values(21922,'o152_empagegera','int4','C�digo da Remessa','0', 'C�digo da Remessa',10,'f','f','f',1,'text','C�digo da Remessa');

delete from db_sysarqcamp where codarq = 3945;
insert into db_sysarqcamp values(3945,21911,1,0);
insert into db_sysarqcamp values(3945,21912,2,0);
insert into db_sysarqcamp values(3945,21913,3,0);
insert into db_sysarqcamp values(3945,21922,4,0);
insert into db_syssequencia values(1000580, 'pagfornumeracao_o152_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

update db_sysarqcamp set codsequencia = 1000580 where codarq = 3945 and codcam = 21911;
delete from db_sysforkey where codarq = 3945 and referen = 0;
insert into db_sysforkey values(3945,21912,1,83,0);
insert into db_sysforkey values(3945,21922,1,1002,0);
delete from db_sysprikey where codarq = 3945;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3945,21911,1,21913);
insert into db_sysindices values(4359,'pagfornumeracao_sequencial_in',3945,'0');
insert into db_syscadind values(4359,21911,1);

insert into db_itensmenu values( 10249, 'Regerar Arquivo - PagFor', 'Regerar Arquivo de Remessa - PagFor', 'cai4_reemissaoarquivoobn001.php?tipo_transmissao=3', '1', '1', 'Regera arquivo de transmiss�o do PAGFOR', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10249,1);
insert into db_menu values(4343,10249,17,39);

update db_itensmenu set descricao = 'Regerar Arquivo OBN', help = 'Regerar arquivo OBN', funcao = 'cai4_reemissaoarquivoobn001.php?tipo_transmissao=2', itemativo = '1', desctec = 'Rotina para reemiss�o de arquivo OBN' where id_item = 9786;

insert into empagetipotransmissao values (3, 'BRADESCO - PAGFOR');

insert into errobanco values (115, 'AA', 'Arquivo duplicado', false, 3);
insert into errobanco values (116, 'AB', 'Data limite para desconto, sem valor correspondente', false, 3);
insert into errobanco values (117, 'AC', 'Tipo de servi�o inv�lido', false, 3);
insert into errobanco values (118, 'AD', 'Modalidade de pagamento inv�lida', false, 3);
insert into errobanco values (119, 'AE', 'Tipo de inscri��o e identifica��o do cliente pagador incompat�veis', false, 3);
insert into errobanco values (120, 'AF', 'Valores n�o num�ricos ou zerados', false, 3);
insert into errobanco values (121, 'AG', 'Tipo de inscri��o e identifica��o do favorecido incompat�vel', false, 3);
insert into errobanco values (122, 'AJ', 'Tipo de movimento inv�lido', false, 3);
insert into errobanco values (123, 'AL', 'Banco, ag�ncia ou conta inv�lido', false, 3);
insert into errobanco values (124, 'AM', 'Ag�ncia do favorecido inv�lida', false, 3);
insert into errobanco values (125, 'AN', 'Conta corrente do favorecido inv�lida', false, 3);
insert into errobanco values (126, 'AO', 'Nome do favorecido n�o informado', false, 3);
insert into errobanco values (127, 'AQ', 'Tipo de moeda inv�lido', false, 3);
insert into errobanco values (128, 'AT', 'CGC/CPF do favorecido inv�lido', false, 3);
insert into errobanco values (129, 'AU', 'Endere�o do favorecido n�o informado', false, 3);
insert into errobanco values (130, 'AX', 'CEP do favorecido inv�lido', false, 3);
insert into errobanco values (131, 'AY', 'Altera��o inv�lida; Banco anterior Bradesco', false, 3);
insert into errobanco values (132, 'AZ', 'C�digo de Banco do favorecido inv�lido', false, 3);
insert into errobanco values (133, 'BD', 'Pagamento agendado', false, 3);
insert into errobanco values (134, 'BE', 'Hora de grava��o inv�lida', false, 3);
insert into errobanco values (135, 'BF', 'Identifica��o da empresa no Banco, inv�lida', false, 3);
insert into errobanco values (136, 'BG', 'CGC/CPF do pagador inv�lido', false, 3);
insert into errobanco values (137, 'BH', 'Tipo de inscri��o do cliente favorecido inv�lido', false, 3);
insert into errobanco values (138, 'BI', 'Data de vencimento inv�lida ou n�o preenchida', false, 3);
insert into errobanco values (139, 'BJ', 'Data de emiss�o do documento inv�lida', false, 3);
insert into errobanco values (140, 'BK', 'Tipo de inscri��o do cliente favorecido n�o permitido', false, 3);
insert into errobanco values (141, 'BL', 'Data limite para desconto inv�lida', false, 3);
insert into errobanco values (142, 'BM', 'Data para efetiva��o do pagamento inv�lida', false, 3);
insert into errobanco values (143, 'BN', 'Data para efetiva��o anterior a do processamento', false, 3);
insert into errobanco values (144, 'BO', 'Cliente n�o cadastrado', false, 3);
insert into errobanco values (145, 'BP', 'Identifica��o de T�tulo Bradesco divergente da original', false, 3);
insert into errobanco values (146, 'BQ', 'Data do documento posterior ao vencimento', false, 3);
insert into errobanco values (147, 'BT', 'Desautoriza��o efetuada', false, 3);
insert into errobanco values (148, 'BU', 'Altera��o efetuada', false, 3);
insert into errobanco values (149, 'BV', 'Exclus�o efetuada', false, 3);
insert into errobanco values (150, 'BW', 'Pagamento efetuado', true, 3);
insert into errobanco values (151, 'FA', 'C�digo de origem inv�lido', false, 3);
insert into errobanco values (152, 'FB', 'Data de grava��o do arquivo inv�lida', false, 3);
insert into errobanco values (153, 'FC', 'Tipo de documento inv�lido', false, 3);
insert into errobanco values (154, 'FE', 'N�mero de pagamento inv�lido', false, 3);
insert into errobanco values (155, 'FF', 'Valor do desconto sem data limite', false, 3);
insert into errobanco values (156, 'FG', 'Data limite para desconto posterior ao vencimento', false, 3);
insert into errobanco values (157, 'FH', 'Falta n�mero e/ou s�rie do documento', false, 3);
insert into errobanco values (158, 'FI', 'Exclus�o de agendamento n�o dispon�vel', false, 3);
insert into errobanco values (159, 'FJ', 'Soma dos valores n�o confere', false, 3);
insert into errobanco values (160, 'FK', 'Falta valor de pagamento', false, 3);
insert into errobanco values (161, 'FL', 'Modalidade de pagamento inv�lida para o contrato', false, 3);
insert into errobanco values (162, 'FM', 'C�digo de movimento inv�lido', false, 3);
insert into errobanco values (163, 'FN', 'Tentativa de inclus�o de registro existente', false, 3);
insert into errobanco values (164, 'FO', 'Tentativa de altera��o para registro inexistente', false, 3);
insert into errobanco values (165, 'FP', 'Tentativa de efetiva��o de agendamento n�o dispon�vel', false, 3);
insert into errobanco values (166, 'FQ', 'Tentativa de desautoriza��o de agendamento n�o dispon�vel', false, 3);
insert into errobanco values (167, 'FR', 'Autoriza��o de agendamento sem data de efetiva��o e sem data de vencimento', false, 3);
insert into errobanco values (168, 'FS', 'T�tulo em agendamento; Pedido de confirma��o', false, 3);
insert into errobanco values (169, 'FT', 'Tipo de inscri��o do cliente pagador inv�lido', false, 3);
insert into errobanco values (170, 'FU', 'Contrato inexistente ou inativo', false, 3);
insert into errobanco values (171, 'FV', 'Cliente com conv�nio cancelado', false, 3);
insert into errobanco values (172, 'FW', 'Valor autorizado inferior ao original', false, 3);
insert into errobanco values (173, 'FX', 'Est� faltando registro header', false, 3);
insert into errobanco values (174, 'FZ', 'Valor autorizado n�o confere para pagamento em atraso', false, 3);
insert into errobanco values (175, 'F0', 'Agendamento em atraso; n�o permitido pelo conv�nio', false, 3);
insert into errobanco values (176, 'F1', 'Tentativa de Agendamento com Desc. Fora do Prazo', false, 3);
insert into errobanco values (177, 'F3', 'Tentativa de altera��o inv�lida; confirma��o de d�bito j� efetuada', false, 3);
insert into errobanco values (178, 'F4', 'Falta registro trailler', false, 3);
insert into errobanco values (179, 'F5', 'Valor do trailler n�o confere', false, 3);
insert into errobanco values (180, 'F6', 'Quantidade de registros do trailler n�o confere', false, 3);
insert into errobanco values (181, 'F7', 'Tentativa de altera��o inv�lida; pagamento j� enviado ao Bradesco Instant�neo', false, 3);
insert into errobanco values (182, 'F8', 'Pagamento enviado ap�s o hor�rio estipulado', false, 3);
insert into errobanco values (183, 'F9', 'Tentativa de inclus�o de registro existente em hist�rico', false, 3);
insert into errobanco values (184, 'GA', 'Tipo de DOC/TED inv�lido', false, 3);
insert into errobanco values (185, 'GB', 'N�mero do DOC/TED inv�lido', false, 3);
insert into errobanco values (186, 'GC', 'Finalidade do DOC/TED inv�lida ou inexistente', false, 3);
insert into errobanco values (187, 'GD', 'Conta corrente do favorecido encerrada / bloqueada', false, 3);
insert into errobanco values (188, 'GE', 'Conta corrente do favorecido n�o recadastrada', false, 3);
insert into errobanco values (189, 'GF', 'Inclus�o de pagamento via modalidade 30 n�o permitida', false, 3);
insert into errobanco values (190, 'GG', 'Campo livre do c�digo de barras (linha digit�vel) inv�lido', false, 3);
insert into errobanco values (191, 'GH', 'D�gito verificador do c�digo de barras inv�lido', false, 3);
insert into errobanco values (192, 'GI', 'C�digo da moeda da linha digit�vel inv�lido', false, 3);
insert into errobanco values (193, 'GJ', 'Conta poupan�a do favorecido inv�lida', false, 3);
insert into errobanco values (194, 'GK', 'Conta poupan�a do favorecido n�o recadastrada', false, 3);
insert into errobanco values (195, 'GL', 'Conta poupan�a do favorecido n�o encontrada', false, 3);
insert into errobanco values (196, 'GM', 'Pagamento 3 (tr�s) dias ap�s o vencimento', false, 3);
insert into errobanco values (197, 'GN', 'Conta complementar inv�lida', false, 3);
insert into errobanco values (198, 'GO', 'Inclus�o de DOC/TED para Banco 237 n�o permitido', false, 3);
insert into errobanco values (199, 'GP', 'CGC/CPF do favorecido divergente do cadastro do Banco', false, 3);
insert into errobanco values (200, 'GQ', 'Tipo de DOC/TED n�o permitido via sistema eletr�nico', false, 3);
insert into errobanco values (201, 'GR', 'Altera��o inv�lida; pagamento j� enviado a ag�ncia pagadora', false, 3);
insert into errobanco values (202, 'GS', 'Limite de pagamento excedido. Fale com o Gerente da sua ag�ncia', false, 3);
insert into errobanco values (203, 'GT', 'Limite vencido/vencer em 30 dias', false, 3);
insert into errobanco values (204, 'GU', 'Pagamento agendado por aumento de limite ou redu��o no total autorizado', false, 3);
insert into errobanco values (205, 'GV', 'Cheque OP estornado conforme seu pedido', false, 3);
insert into errobanco values (206, 'GW', 'Conta corrente ou conta poupan�a com raz�o n�o permitido para efetiva��o de cr�dito', false, 3);
insert into errobanco values (207, 'GX', 'Cheque OP com data limite vencida', false, 3);
insert into errobanco values (208, 'GY', 'Conta poupan�a do favorecido encerrada / bloqueada', false, 3);
insert into errobanco values (209, 'GZ', 'Conta corrente do pagador encerrada / bloqueada', false, 3);
insert into errobanco values (210, 'HA', 'Agendado, d�bito sob consulta de saldo', false, 3);
insert into errobanco values (211, 'HB', 'Pagamento n�o efetuado, saldo insuficiente', false, 3);
insert into errobanco values (212, 'HC', 'Pagamento n�o efetuado, al�m de saldo insuficiente, conta com cadastro no DVL', false, 3);
insert into errobanco values (213, 'HD', 'Pagamento n�o efetuado, al�m de saldo insuficiente, conta bloqueada', false, 3);
insert into errobanco values (214, 'HE', 'Data de Vencto/Pagto fora do prazo de opera��o do banco', false, 3);
insert into errobanco values (215, 'HF', 'Processado e debitado', false, 3);
insert into errobanco values (216, 'HG', 'Processado e n�o debitado por saldo insuficiente', false, 3);
insert into errobanco values (217, 'HI', 'Cheque OP Emitido nesta data', false, 3);
insert into errobanco values (218, 'JA', 'C�digo de lan�amento inv�lido', false, 3);
insert into errobanco values (219, 'JB', 'DOC/TED/T�tulos devolvidos e estornados', false, 3);
insert into errobanco values (220, 'JC', 'Modalidade alterada de 07/CIP, para 08/STR', false, 3);
insert into errobanco values (221, 'JD', 'Modalidade alterada de 07/CIP, para 03/DOC COMPE', false, 3);
insert into errobanco values (222, 'JE', 'Modalidade alterada de 08/STR para 07/CIP', false, 3);
insert into errobanco values (223, 'JF', 'Modalidade alterada de 08/STR para 03/COMPE', false, 3);
insert into errobanco values (224, 'JG', 'Altera��o de Modalidade Via Arquivo n�o Permitido', false, 3);
insert into errobanco values (225, 'JH', 'Hor�rio de Consulta de Saldo ap�s Encerramento Rotina', false, 3);
insert into errobanco values (226, 'JI', 'Modalidade alterada de 01/Cr�dito em conta para 05/Cr�dito em conta real time', false, 3);
insert into errobanco values (227, 'JJ', 'Hor�rio de agendamento Inv�lido', false, 3);
insert into errobanco values (228, 'JK', 'Tipo de conta ? modalidade DOC/TED - inv�lido', false, 3);
insert into errobanco values (229, 'JL', 'Titulo Agendado/Descontado', false, 3);
insert into errobanco values (230, 'JM', 'Altera��o n�o Permitida, Titulo Antecipado/Descontado', false, 3);
insert into errobanco values (231, 'JN', 'Modalidade Alter. de 05/Cr�dito em Conta Real Time Para 01/Cr�dito em Conta', false, 3);
insert into errobanco values (232, 'JO', 'Exclus�o n�o Permitida Titulo Antecipado/Descontado', false, 3);
insert into errobanco values (233, 'JP', 'Pagamento com Limite TED Excedido. Fale com o Gerente da sua ag�ncia para Autoriza��o.', false, 3);
insert into errobanco values (234, 'KO', 'Autoriza��o para debito em conta', false, 3);
insert into errobanco values (235, 'KP', 'Cliente pagador n�o cadastrado do PAGFOR', false, 3);
insert into errobanco values (236, 'KQ', 'Modalidade inv�lida para pagador em teste', false, 3);
insert into errobanco values (237, 'KR', 'Banco destinat�rio n�o operante nesta data', false, 3);
insert into errobanco values (238, 'KS', 'Modalidade alterada de DOC. Para TED', false, 3);
insert into errobanco values (239, 'KT', 'Dt. Efetiva��o alterada p/ pr�ximo MOVTO. ** TRAG', false, 3);
insert into errobanco values (240, 'KV', 'CPF/CNPJ do investidor inv�lido ou inexistente', false, 3);
insert into errobanco values (241, 'KW', 'Tipo Inscri��o Investidor Inv�lido ou inexistente', false, 3);
insert into errobanco values (242, 'KX', 'Nome do Investidor Inexistente', false, 3);
insert into errobanco values (243, 'KZ', 'C�digo do Investidor Inexistente', false, 3);
insert into errobanco values (244, 'LA', 'Agendado. Sob Lista de D�bito', false, 3);
insert into errobanco values (245, 'LB', 'Pagamento n�o autorizado sob Lista de D�bito', false, 3);
insert into errobanco values (246, 'LC', 'Lista com mais de uma modalidade', false, 3);
insert into errobanco values (247, 'LD', 'Lista com mais de uma data de Pagamento', false, 3);
insert into errobanco values (248, 'LE', 'N�mero de Lista Duplicado', false, 3);
insert into errobanco values (249, 'LF', 'Lista de D�bito vencida e n�o autorizada', false, 3);
insert into errobanco values (250, 'LG', 'Conta Sal�rio n�o permitida para este conv�nio', false, 3);
insert into errobanco values (251, 'LH', 'C�digo de Lan�amento inv�lido para Conta Sal�rio', false, 3);
insert into errobanco values (252, 'LI', 'Finalidade de DOC / TED inv�lido para Sal�rio', false, 3);
insert into errobanco values (253, 'LJ', 'Conta Sal�rio obrigat�ria para este C�digo de Lan�amento', false, 3);
insert into errobanco values (254, 'LK', 'Tipo de Conta do Favorecido Inv�lida', false, 3);
insert into errobanco values (255, 'LL', 'Nome do Favorecido Inconsistente', false, 3);
insert into errobanco values (256, 'LM', 'N�mero de Lista de D�bito Inv�lido', false, 3);
insert into errobanco values (257, 'MA', 'Tipo conta Inv�lida para finalidade', false, 3);
insert into errobanco values (258, 'MB', 'Conta Cr�dito Investimento inv�lida/inexistente', false, 3);
insert into errobanco values (259, 'MC', 'Conta D�bito Investimento Inv�lida/inexistente', false, 3);
insert into errobanco values (260, 'MD', 'Titularidade diferente para tipo de conta', false, 3);
insert into errobanco values (261, 'ME', 'Data de Pagamento Alterada devido a Feriado Local', false, 3);
insert into errobanco values (262, 'MF', 'Alega��o Efetuada', false, 3);
insert into errobanco values (263, 'MG', 'Alega��o N�o Efetuada. Motivo da Alega��o/Reconhecimento da Divida Inconsistente.', false, 3);
insert into errobanco values (264, 'MH', 'Autoriza��o N�o Efetuada. C�digo de Reconhecimento da divida n�o permitido.', false, 3);
insert into errobanco values (265, 'NC', 'C�digo Identificador Inv�lido', false, 3);
insert into errobanco values (266, 'TR', 'Ag/ Conta do favorecido alterado por Transfer�ncia de agencia.', false, 3);

insert into db_errobanco select '237', e92_sequencia from errobanco where e92_sequencia between 115 and 266;



insert into db_sysarquivo values (3952, 'empagemovformapagamento', 'Forma de Pagamento', 'e07', '2016-07-13', 'empagemovformapagamento', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (38,3952);
insert into db_syscampo values(21951,'e07_sequencial','int4','C�digo sequencial','0', 'C�digo',10,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(21952,'e07_empagemov','int4','C�digo do movimento','0', 'C�digo do Movimento',10,'f','f','f',1,'text','C�digo do Movimento');
insert into db_syscampo values(21953,'e07_formatransmissao','int4','1 = DOC 2 = TED','0', 'Forma de Transmiss�o',10,'f','f','f',1,'text','Forma de Transmiss�o');
insert into db_syscampodef values(21953,'1','DOC');
insert into db_syscampodef values(21953,'2','TED');
delete from db_sysarqcamp where codarq = 3952;
insert into db_sysarqcamp values(3952,21951,1,0);
insert into db_sysarqcamp values(3952,21953,2,0);
insert into db_sysarqcamp values(3952,21952,3,0);
insert into db_sysindices values(4365,'empagemovformapagamento_empagemov_in',3952,'0');
insert into db_syscadind values(4365,21952,1);
delete from db_sysforkey where codarq = 3952 and referen = 0;
insert into db_sysforkey values(3952,21952,1,995,0);
delete from db_sysprikey where codarq = 3952;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3952,21951,1,21952);
insert into db_syssequencia values(1000587, 'empagemovformapagamento_e07_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000587 where codarq = 3952 and codcam = 21951;

---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL FINANCEIRO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
--------------------------------------------- INICIO SA�DE ----------------------------------------------------
---------------------------------------------------------------------------------------------------------------
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10247 ,'H�rus' ,'H�rus' ,'' ,'1' ,'1' ,'Menu principal do H�rus.' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 3444 ,10247 ,25 ,6877 );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10248 ,'Configura��o de Usu�rio' ,'Configura��o de Usu�rio' ,'far4_configuracaousuariohorus001.php' ,'1' ,'1' ,'Formul�rio para configura��o do usu�rio de acesso ao H�rus.' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10247 ,10248 ,1 ,6877 );
update db_itensmenu set id_item = 10115 , descricao = 'Exporta��o' , help = 'Exporta��o' , funcao = 'far4_exportacaohorus001.php' , itemativo = '1' , manutencao = '1' , desctec = 'Menu para exporta��o dos dados da farm�cia( Entrada, Sa�da e Dispensa��o ) para o H�rus.' , libcliente = 'true' where id_item = 10115;
delete from db_menu where id_item_filho = 10115 AND modulo = 6877;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10247 ,10115 ,2 ,6877 );
insert into db_sysarquivo values (3946, 'horususuario', 'Guarda os usu�rios de acesso ao h�rus por departamento.', 'fa66', '2016-06-28', 'Usu�rios de acesso ao h�rus', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (52,3946);
insert into db_syscampo values(21914,'fa66_sequencial','int4','Sequencial de horususuario','0', 'C�digo',10,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(21915,'fa66_unidade','int4','Unidade configurada com os dados do usu�rio.','0', 'Unidade',10,'f','f','f',1,'text','Unidade');
insert into db_syscampo values(21916,'fa66_usuario','varchar(100)','Usu�rio de acesso ao h�rus.','', 'Usu�rio',100,'f','t','f',0,'text','Usu�rio');
insert into db_syscampo values(21917,'fa66_senha','varchar(40)','Senha de acesso ao h�rus.','', 'Senha',40,'f','t','f',0,'text','Senha');
insert into db_sysarqcamp values(3946,21914,1,0);
insert into db_sysarqcamp values(3946,21915,2,0);
insert into db_sysarqcamp values(3946,21916,3,0);
insert into db_sysarqcamp values(3946,21917,4,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3946,21914,1,21915);
insert into db_syssequencia values(1000581, 'horususuario_fa66_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000581 where codarq = 3946 and codcam = 21914;
delete from db_sysforkey where codarq = 3946 and referen = 0;
insert into db_sysforkey values(3946,21915,1,100011,0);
insert into db_sysindices values(4360,'horususuario_unidade_in',3946,'1');
insert into db_syscadind values(4360,21915,1);
---------------------------------------------------------------------------------------------------------------
--------------------------------------------- FINAL SA�DE -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------


---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO TRIBUTARIO ----------------------------------------------------
---------------------------------------------------------------------------------------------------------------
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
     values ( 21918 ,'j18_receitacreditorecalculo' ,'int4' ,'Receita de Cr�dito utilizada no rec�lculo' ,'' ,'Receita de Cr�dito' ,10 ,'true' ,'false' ,'false' ,1 ,'text' ,'Receita de Cr�dito' );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
     values ( 21919 ,'j18_tipodebitorecalculo' ,'int4' ,'Tipo de D�bito utilizado no Recálculo' ,'' ,'Tipo de D�bito' ,10 ,'true' ,'false' ,'false' ,1 ,'text' ,'Tipo de D�bito' );

insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 153 ,21918 ,30 ,0 );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 153 ,21919 ,31 ,0 );

insert into db_sysforkey values(153,21919,1,82,0);
insert into db_sysforkey values(153,21918,1,75,0);

update iptucadlogcalc set j62_erro = false where j62_codigo = 27;

-- Compensacao
insert into db_sysarquivo values (3949, 'abatimentocorrecao', 'Hist�rico de Corre��o de Cr�ditos', 'k167', '2016-07-05', 'Abatimento Corre��o', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (54,3949);

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
    values ( 21928 ,'k167_sequencial' ,'int4' ,'Sequencial' ,'0' ,'Sequencial' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Sequencial' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3949 ,21928 ,1 ,0 );

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
    values ( 21929 ,'k167_valorantigo' ,'float8' ,'Valor Antigo' ,'' ,'Valor Antigo' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor Antigo' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3949 ,21929 ,2 ,0 );

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
    values ( 21930 ,'k167_valorcorrigido' ,'float8' ,'Valor Corrigido' ,'' ,'Valor Corrigido' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor Corrigido' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3949 ,21930 ,3 ,0 );

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
    values ( 21931 ,'k167_data' ,'date' ,'Data da Corre��o' ,'' ,'Data da Corre��o' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Data da Corre��o' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3949 ,21931 ,4 ,0 );

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
    values ( 21932 ,'k167_abatimento' ,'int4' ,'C�digo do Abatimento' ,'' ,'C�digo do Abatimento' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'C�digo do Abatimento' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3949 ,21932 ,5 ,0 );

insert into db_syssequencia values(1000584, 'abatimentocorrecao_k167_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000584 where codarq = 3949 and codcam = 21928;
insert into db_sysforkey values(3949,21932,1,3191,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3949,21928,1,21928);
---------------------------------------------------------------------------------------------------------------
---------------------------------------- FIM TRIBUTARIO -------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO FOLHA ---------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
insert into db_layoutcampos SELECT 13751 ,138 ,'carga_horaria' ,'CARGA HORARIA' ,2 ,348 ,'' ,3 ,'f' ,'t' ,'e' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13751) limit 1;
insert into db_layoutcampos select 13752 ,138 ,'tipo_carga_horaria' ,'TIPO DA CARGA HORARIA' ,1 ,351 ,'' ,1 ,'f' ,'t' ,'d' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13752) limit 1;
insert into db_layoutcampos select 13753 ,138 ,'tipo_cedencia' ,'TIPO DA CEDENCIA' ,1 ,352 ,'' ,1 ,'f' ,'t' ,'d' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13753) limit 1;
insert into db_layoutcampos select 13754 ,138 ,'onus_origem' ,'ONUS PARA A ORIGEM' ,1 ,353 ,'' ,1 ,'f' ,'t' ,'d' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13754) limit 1;
insert into db_layoutcampos select 13755 ,138 ,'ressarcimento' ,'RESSARCIMENTO' ,1 ,354 ,'' ,1 ,'f' ,'t' ,'d' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13755) limit 1;
insert into db_layoutcampos select 13756 ,138 ,'data_movimentacao_cedencia' ,'DATA DE MOVIMENTACAO' ,4 ,355 ,'00000000' ,8 ,'f' ,'t' ,'e' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13756) limit 1;
insert into db_layoutcampos select 13757 ,138 ,'cnpj_origem_destino' ,'CNPJ ORG�O ORIGEM/DESTINO' ,7 ,363 ,'' ,14 ,'f' ,'t' ,'e' ,'' ,0 FROM db_layoutcampos WHERE NOT EXISTS(SELECT 1 FROM db_layoutcampos WHERE db52_codigo = 13757) limit 1;

select fc_executa_ddl('insert into db_syscampo values(21933,\'rh02_horasdiarias\',\'int4\',\'N�mero de horas di�rias, caso o campo tipo de folha seja di�rio.\',\'0\', \'Horas Di�rias\',20,\'t\',\'f\',\'f\',1,\'text\',\'Horas Di�rias\');');
select fc_executa_ddl('insert into db_syscampo values(21934,\'rh02_cedencia\',\'char(1)\',\'Tipo da ced�ncia, pode ser Cedido, Adido ou N�o se Aplica, sendo n�o se aplica a op��o default.\',\'X\', \'Tipo\',1,\'f\',\'t\',\'f\',0,\'text\',\'Tipo Ced�ncia\');');
select fc_executa_ddl('insert into db_syscampodef values(21934,\'C\',\'Cedido\');');
select fc_executa_ddl('insert into db_syscampodef values(21934,\'A\',\'Adido\');');
select fc_executa_ddl('insert into db_syscampodef values(21934,\'X\',\'N�o se aplica\');');
select fc_executa_ddl('insert into db_syscampo values(21935,\'rh02_onus\',\'char(1)\',\'Informa se existe onus na ced�ncia de um servidor. Especifica se o Onus � da origem ou destino.\',\'X\', \'�nus\',1,\'f\',\'t\',\'f\',0,\'text\',\'Onus\');');
select fc_executa_ddl('insert into db_syscampodef values(21935,\'X\',\'N�o se Aplica\');');
select fc_executa_ddl('insert into db_syscampodef values(21935,\'S\',\'�nus para origem\');');
select fc_executa_ddl('insert into db_syscampodef values(21935,\'N\',\'�nus para destino\');');

select fc_executa_ddl('insert into db_syscampo values(21936,\'rh02_ressarcimento\',\'char(1)\',\'Campo que informa se a ced�ncia possui ressarcimento.\',\'X\', \'Ressarcimento\',1,\'f\',\'t\',\'f\',0,\'text\',\'Ressarcimento\');');
select fc_executa_ddl('insert into db_syscampodef values(21936,\'X\',\'N�o se aplica\');');
select fc_executa_ddl('insert into db_syscampodef values(21936,\'S\',\'Sim\');');
select fc_executa_ddl('insert into db_syscampodef values(21936,\'N\',\'N�o\');');
select fc_executa_ddl('insert into db_syscampo   values(21937,\'rh02_datacedencia\',\'date\',\'Data emq ue ocorreu o cadastro da ced�ncia\',\'null\', \'Data Movimenta��o\',10,\'t\',\'f\',\'f\',1,\'text\',\'Data Movimenta��o\');');
select fc_executa_ddl('insert into db_syscampo   values(21938,\'rh02_cnpjcedencia\',\'varchar(20)\',\'CNPJ da Origem/Destino da Ced�ncia. Armazena o CNPj para qual o servidor foi cedido, ou o cnpj do org�o que o Servidor foi Adido.\',\'0\', \'CNPJ Origem/Destino\',20,\'f\',\'f\',\'f\',1,\'text\',\'CNPJ Origem/Destino\');');
select fc_executa_ddl('insert into db_sysarqcamp values(1158,21933,28,0);');
select fc_executa_ddl('insert into db_sysarqcamp values(1158,21934,29,0);');
select fc_executa_ddl('insert into db_sysarqcamp values(1158,21935,30,0);');
select fc_executa_ddl('insert into db_sysarqcamp values(1158,21936,31,0);');
select fc_executa_ddl('insert into db_sysarqcamp values(1158,21937,32,0);');
select fc_executa_ddl('insert into db_sysarqcamp values(1158,21938,33,0);');



---------------------------------------------------------------------------------------------------------------
---------------------------------------- FIM FOLHA ------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

