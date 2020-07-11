-- fc_executa_ddl

select fc_executa_ddl('

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 21801 ,''h82_formulafim'' ,''int4'' ,''F�rmula que informa a data de fim do assentamento que ser� lan�ado.'' ,''0'' ,''F�rmula de Fim'' ,19 ,''false'' ,''false'' ,''false'' ,1 ,''text'' ,''F�rmula de Fim'' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3835 ,21801 ,7 ,0 );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 21802 ,''h82_formulafaltasperiodo'' ,''int4'' ,''F�rmula que informa a as faltas por per�odo do assentamento que ser� lan�ado.'' ,''0'' ,''F�rmula de Faltas por Per�odo'' ,19 ,''false'' ,''false'' ,''false'' ,1 ,''text'' ,''F�rmula de Faltas por Per�odo'' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3835 ,21802 ,8 ,0 );

delete from db_syscadind where codind = 4229;
insert into db_syscadind values(4229,21280,1);
insert into db_syscadind values(4229,21283,4);
insert into db_syscadind values(4229,21284,5);


alter table agendaassentamento add column h82_formulafim integer;
alter table agendaassentamento add column h82_formulafaltasperiodo integer;

update agendaassentamento set h82_formulafim = (select db148_sequencial from db_formulas where db148_nome = ''FINAL_GTS''), h82_formulafaltasperiodo = (select db148_sequencial from db_formulas where db148_nome = ''FALTAS_PERIODO'');

alter table agendaassentamento alter column h82_formulafim set not null;
alter table agendaassentamento alter column h82_formulafaltasperiodo set not null;



ALTER TABLE agendaassentamento
ADD CONSTRAINT agendaassentamento_formulafim_fk FOREIGN KEY (h82_formulafim)
REFERENCES db_formulas;

ALTER TABLE agendaassentamento
ADD CONSTRAINT agendaassentamento_formulafaltasperiodo_fk FOREIGN KEY (h82_formulafaltasperiodo)
REFERENCES db_formulas;

DROP INDEX agendaassentamento_un_in;
CREATE UNIQUE INDEX agendaassentamento_un_in ON agendaassentamento(h82_tipoassentamento, h82_selecao, h82_instit);

');