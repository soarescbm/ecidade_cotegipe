---------------------------------------------------------------------------------------------------------------
--------------------------------------- INICIO TRIBUTARIO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

alter table abatimentoutilizacaodestino add column k170_valor numeric(15,2) default 0;

---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL TRIBUTARIO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
--------------------------------------- INICIO FINANCEIRO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

create table if not exists empenho.empnotasuspensao(
	cc36_sequencial             serial,
	cc36_empnota                int4 not null,
	cc36_justificativasuspensao text not null,
	cc36_datasuspensao          date not null,
	cc36_justificativaretorno   text not null,
	cc36_dataretorno            date,
	constraint empnotasuspensao_sequ_pk primary key (cc36_sequencial),
	constraint empnotasuspensao_empnota_fk foreign key (cc36_empnota) references empenho.empnota(e69_codnota)
);

update conhistdoc set c53_descr = 'CONCESS�O DE TRANSFER�NCIA FINANCEIRA'                 where c53_coddoc = 120;
update conhistdoc set c53_descr = 'ESTORNO DE CONCESS�O DE TRANSFER�NCIA FINANCEIRA'      where c53_coddoc = 121;
update conhistdoc set c53_descr = 'RECEBIMENTOS DE OUTRAS MOVIMENTA��ES EXTRAS'           where c53_coddoc = 150;
update conhistdoc set c53_descr = 'RECEBIMENTOS DE OUTRAS MOVIMENTA��ES EXTRAS - ESTORNO' where c53_coddoc = 152;
update conhistdoc set c53_descr = 'PAGAMENTOS DE OUTRAS MOVIMENTA��ES EXTRAS'             where c53_coddoc = 151;
update conhistdoc set c53_descr = 'PAGAMENTOS DE OUTRAS MOVIMENTA��ES EXTRAS - ESTORNO'   where c53_coddoc = 153;
update db_itensmenu set descricao = 'Outras Movimenta��es Extras' where id_item = 9385;
update db_itensmenu set descricao = 'Pagamento' where id_item = 9389;
---------------------------------------------------------------------------------------------------------------
--------------------------------------- FIM FINANCEIRO -----------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
--------------------------------------- INICIO FOLHA ----------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

--Estrutura da tarefa de concessão de direitos
select fc_executa_ddl('alter table agendaassentamento alter h82_formulafim drop not null;');
select fc_executa_ddl('alter table agendaassentamento alter h82_formulafaltasperiodo drop not null;');
select fc_executa_ddl('alter table agendaassentamento add h82_formulaprorrogafim integer;');
select fc_executa_ddl('alter table agendaassentamento add constraint agendaassentamento_h82_formulaprorrogafim_fk foreign key (h82_formulaprorrogafim) references db_formulas(db148_sequencial);');
select fc_executa_ddl('alter table rhpreponto alter rh149_quantidade type numeric;');
alter table db_formulas alter db148_nome type varchar(100);


-- Criando  sequences
select fc_executa_ddl('CREATE SEQUENCE pessoal.eventofinanceiroautomatico_rh181_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1');


-- Módulo: pessoal
CREATE TABLE IF NOT EXISTS eventofinanceiroautomatico(
rh181_sequencial    int4 NOT NULL default 0,
rh181_descricao   varchar(56) NOT NULL ,
rh181_rubrica   varchar(4) NOT NULL ,
rh181_mes   int4 NOT NULL default 0,
rh181_selecao   int4 NOT NULL default 0,
rh181_instituicao   int4 default 0,
CONSTRAINT eventofinanceiroautomatico_sequ_pk PRIMARY KEY (rh181_sequencial),
CONSTRAINT eventofinanceiroautomatico_instituicao_fk FOREIGN KEY (rh181_instituicao) REFERENCES db_config,
CONSTRAINT eventofinanceiroautomatico_selecao_instituicao_fk FOREIGN KEY (rh181_selecao,rh181_instituicao) REFERENCES selecao,
CONSTRAINT eventofinanceiroautomatico_rubrica_instituicao_fk FOREIGN KEY (rh181_rubrica,rh181_instituicao) REFERENCES rhrubricas
);

-- INDICES
select fc_executa_ddl('CREATE UNIQUE INDEX pessoal.eventofinanceiroautomatico_rubrica_mes_selecao_instituicao_un ON eventofinanceiroautomatico(rh181_rubrica,rh181_mes,rh181_selecao,rh181_instituicao);');

select fc_executa_ddl('
	CREATE SEQUENCE pessoal.rhconsignadomovimentomanual_rh182_sequencial_seq
		INCREMENT 1
		MINVALUE 1
		MAXVALUE 9223372036854775807
		START 1
		CACHE 1;
');

CREATE TABLE IF NOT EXISTS pessoal.rhconsignadomovimentomanual(
	rh182_sequencial                    int4    NOT NULL,
	rh182_rhconsignadomovimento         int4    NOT NULL,
	rh182_rhconsignadomovimentoservidor int4    NOT NULL,
	rh182_processado                    boolean NOT NULL default false,
	rh182_ano                           int4    NOT NULL,
	rh182_mes                           int4    NOT NULL,
	CONSTRAINT rhconsignadomovimentomanual_seq_pk PRIMARY KEY (rh182_sequencial),
	CONSTRAINT rhconsignadomovimento_fk FOREIGN KEY (rh182_rhconsignadomovimento) REFERENCES rhconsignadomovimento,
	CONSTRAINT rhconsignadomovimentoservidor_fk FOREIGN KEY (rh182_rhconsignadomovimentoservidor) REFERENCES rhconsignadomovimentoservidor
);
select fc_executa_ddl('
	CREATE UNIQUE INDEX rhconsignadomovimentomanual_un_in ON pessoal.rhconsignadomovimentomanual(rh182_rhconsignadomovimento, rh182_rhconsignadomovimentoservidor, rh182_ano, rh182_mes);
');

select fc_executa_ddl('ALTER TABLE pessoal.rhconsignadomovimento ADD COLUMN rh151_tipoconsignado char(1) NULL;');
select fc_executa_ddl('ALTER TABLE pessoal.rhconsignadomovimento ADD COLUMN rh151_consignadoorigem int4 NULL;');
select fc_executa_ddl('ALTER TABLE pessoal.rhconsignadomovimento ADD COLUMN rh151_situacao char(1) NULL;');

CREATE SEQUENCE atolegalprevidencia_rh179_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE atolegalprevidencia(
rh179_sequencial  int4 NOT NULL default 0,
rh179_descricao   varchar(60) ,
CONSTRAINT atolegalprevidencia_sequ_pk PRIMARY KEY (rh179_sequencial));

CREATE SEQUENCE atolegalprevidenciainssirf_rh180_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE atolegalprevidenciainssirf(
rh180_sequencial          int4 NOT NULL default 0,
rh180_instituicao         int4 NOT NULL default 0,
rh180_inssirf             int4 NOT NULL default 0,
rh180_atolegal            int4 NOT NULL default 0,
rh180_numero              int8 NOT NULL default 0,
rh180_ano                 int4 NOT NULL default 0,
rh180_datapublicacao      date NOT NULL default null,
rh180_datainiciovigencia  date default null,
CONSTRAINT atolegalprevidenciainssirf_sequ_pk PRIMARY KEY (rh180_sequencial));

ALTER TABLE atolegalprevidenciainssirf
ADD CONSTRAINT atolegalprevidenciainssirf_inssirf_instituicao_fk FOREIGN KEY (rh180_inssirf,rh180_instituicao)
REFERENCES inssirf;

ALTER TABLE atolegalprevidenciainssirf
ADD CONSTRAINT atolegalprevidenciainssirf_atolegal_fk FOREIGN KEY (rh180_atolegal)
REFERENCES atolegalprevidencia;

CREATE  INDEX atolegalprevidenciainssirf_atolegal_in ON atolegalprevidenciainssirf(rh180_atolegal);
CREATE UNIQUE INDEX atolegalprevidenciainssirf_inssirf_instituicao_in ON atolegalprevidenciainssirf(rh180_inssirf,rh180_instituicao);

insert into atolegalprevidencia
     values (1, 'CONSTITUI��O FEDERAL'),
            (2, 'DECRETO'),
            (3, 'DECRETO LEGISLATIVO'),
            (4, 'EMENDA'),
            (5, 'LEI COMPLEMENTAR'),
            (6, 'LEI ORDIN�RIA'),
            (7, 'LEI DELEGADA'),
            (8, 'LEI ORG�NICA'),
            (9, 'MEDIDA PROVIS�RIA'),
            (10, 'PORTARIA'),
            (11, 'RESOLU��O'),
            (12, 'PARECER'),
            (13, 'ORIENTA��O NORMATIVA'),
            (99, 'OUTROS');


insert into rharquivossiprev
     values (6, 'Al�quotas', 'ArquivoSiprevAliquotas'),
            (7, 'Pensionistas', 'ArquivoSiprevPensionistas'),
            (8,  'Hist�ricos Funcionais - RGPS', 'ArquivoSiprevVinculosFuncionaisRGPS'),
            (9,  'Hist�ricos Funcionais - RPPS', 'ArquivoSiprevVinculosFuncionaisRPPS'),
            (10, 'Hist�ricos Financeiros', 'ArquivoSiprevHistoricosFinanceiros'),
            (11, 'Benef�cios dos Servidores', 'ArquivoSiprevBeneficiosServidores'),
            (12, 'Benef�cios dos Pensionistas', 'ArquivoSiprevBeneficiosPensionistas'),
            (13, 'Tempo de Contribui��o - RGPS', 'ArquivoSiprevTempoContribuicaoRGPS'),
            (14, 'Tempo de Contribui��o - RPPS', 'ArquivoSiprevTempoContribuicaoRPPS'),
            (15, 'Tempos Fict�cios', 'ArquivoSiprevTemposFicticios'),
            (16, 'Tempo sem Contribui��o', 'ArquivoSiprevTempoSemContribuicao'),
            (17, 'Fun��es Gratificadas', 'ArquivoSiprevFuncoesGratificadas');


alter table rhparam add column h36_tempocontribuicaorgps int4;
alter table rhparam add column h36_tempocontribuicaorpps int4;
alter table rhparam add column h36_temposficticios int4;
alter table rhparam add column h36_temposemcontribuicao int4;

ALTER TABLE rhparam
ADD CONSTRAINT rhparam_tempocontribuicaorgps_fk FOREIGN KEY (h36_tempocontribuicaorgps)
REFERENCES tipoasse;

ALTER TABLE rhparam
ADD CONSTRAINT rhparam_tempocontribuicaorpps_fk FOREIGN KEY (h36_tempocontribuicaorpps)
REFERENCES tipoasse;

ALTER TABLE rhparam
ADD CONSTRAINT rhparam_temposficticios_fk FOREIGN KEY (h36_temposficticios)
REFERENCES tipoasse;

ALTER TABLE rhparam
ADD CONSTRAINT rhparam_temposemcontribuicao_fk FOREIGN KEY (h36_temposemcontribuicao)
REFERENCES tipoasse;

CREATE  INDEX rhparam_temposemcontribuicao_in ON rhparam(h36_temposemcontribuicao);
CREATE  INDEX rhparam_temposficticios_in ON rhparam(h36_temposficticios);
CREATE  INDEX rhparam_tempocontribuicaorpps_in ON rhparam(h36_tempocontribuicaorpps);
CREATE  INDEX rhparam_tempocontribuicaorgps_in ON rhparam(h36_tempocontribuicaorgps);

ALTER TABLE cfpess ADD COLUMN r11_basefgintegral character varying;
ALTER TABLE cfpess ADD COLUMN r11_basefgparcial character varying;
---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL FOLHA ----------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
--------------------------------------- INICIO CONFIGURACAO ---------------------------------------------------
---------------------------------------------------------------------------------------------------------------

create table configuracoes.db_tutorial (
  id int4 not null default 0,
  descricao varchar,
  constraint db_tutorial_id_pk primary key (id)
);
create sequence configuracoes.db_tutorial_id_seq increment 1 minvalue 1 maxvalue 9223372036854775807 start 1 cache 1;

--

create table configuracoes.db_tutorialetapas (
  id int4 not null default 0,
  db_tutorial_id int4,
  descricao varchar,
  menu_id int4,
  modulo_id int4,
  ordem int4,
  constraint db_tutorialetapas_id_pk primary key (id)
);
create sequence configuracoes.db_tutorialetapas_id_seq increment 1 minvalue 1 maxvalue 9223372036854775807 start 1 cache 1;

alter table configuracoes.db_tutorialetapas
add constraint db_tutorialetapas_db_tutorial_id_fk foreign key (db_tutorial_id)
references configuracoes.db_tutorial ;

--

create table configuracoes.db_tutorialetapapassos (
  id int4 not null default 0,
  db_tutorialetapa_id int4,
  xpath varchar,
  conteudo text,
  ordem int4,
  constraint db_tutorialetapapassos_id_pk primary key (id)
);
create sequence configuracoes.db_tutorialetapapassos_id_seq increment 1 minvalue 1 maxvalue 9223372036854775807 start 1 cache 1;

alter table configuracoes.db_tutorialetapapassos
add constraint db_tutorialetapapassos_db_tutorialetapa_id_fk foreign key (db_tutorialetapa_id)
references configuracoes.db_tutorialetapas ;

  -- Organograma --
ALTER TABLE
  db_depart ADD id_usuarioresp int4 null;

CREATE SEQUENCE db_organograma_db122_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE db_organograma(
  db122_sequencial  int4 NOT NULL default 0,
  db122_depart int4 NOT NULL default 0,
  db122_estruturavalor int4 NOT NULL default 0,
  db122_descricao varchar(100) NOT NULL ,
  db122_associado char(1) ,
  CONSTRAINT db_organograma_sequ_pk PRIMARY KEY (db122_sequencial)
);

ALTER TABLE db_depart ADD CONSTRAINT db_depart_usuarioresp_fk FOREIGN KEY (id_usuarioresp) REFERENCES db_usuarios;
ALTER TABLE db_organograma ADD CONSTRAINT db_organograma_depart_fk FOREIGN KEY (db122_depart) REFERENCES db_depart;
ALTER TABLE db_organograma ADD CONSTRAINT db_organograma_estruturavalor_fk FOREIGN KEY (db122_estruturavalor) REFERENCES db_estruturavalor;

CREATE INDEX db_depart_loginresp_in ON db_depart(id_usuarioresp);
CREATE INDEX db_organograma_estruturavalor_in ON db_organograma(db122_estruturavalor);
CREATE INDEX db_organograma_descricao_in ON db_organograma(db122_descricao);

update db_itensmenu set id_item = 8848 , descricao = 'Altera��o' , help = 'Altera��o do Organograma' , funcao = 'con1_organograma002.php' , itemativo = '1' , manutencao = '1' , desctec = 'Tela de altera��o do organograma' , libcliente = 'true' where id_item = 8848;
update db_itensmenu set id_item = 8849 , descricao = 'Relat�rio de Organograma' , help = 'Relat�rio de Organograma' , funcao = 'con2_organograma.php' , itemativo = '1' , manutencao = '1' , desctec = 'Tela com a imagem do organograma' , libcliente = 'true' where id_item = 8849;
update db_itensmenu set id_item = 8847 , descricao = 'Inclus�o' , help = 'Inclus�o do Organograma' , funcao = 'con1_organograma001.php' , itemativo = '1' , manutencao = '1' , desctec = 'Tela de Inclus�o do primeiro elemento do organograma.' , libcliente = 'true' where id_item = 8847;
update db_itensmenu set id_item = 8871 , descricao = 'Configura��es Gerais' , help = 'Configura��es Gerais' , funcao = 'con4_configuracoesgerais.php' , itemativo = '1' , manutencao = '1' , desctec = 'Configura��es Gerais' , libcliente = 'true' where id_item = 8871;
update db_itensmenu set id_item = 8843 , descricao = 'Cadastro de Organograma' , help = 'Cadastro de Organograma' , itemativo = '1' , manutencao = '1' , desctec = 'Cadastro de Organograma' , libcliente = 'true' where id_item = 8843;

---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL CONFIGURACAO ---------------------------------------------------
---------------------------------------------------------------------------------------------------------------

---------------------------------------------------------------------------------------------------------------
---------------------------------------- INICIO SAUDE ---------------------------------------------------------
---------------------------------------------------------------------------------------------------------------
select fc_executa_ddl('alter table cgs_und add column z01_registromunicipio boolean default true not null;');
---------------------------------------------------------------------------------------------------------------
---------------------------------------- FINAL SAUDE ----------------------------------------------------------
---------------------------------------------------------------------------------------------------------------

