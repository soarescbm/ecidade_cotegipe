update db_sysarquivo set nomearq = 'rhferiasconfiguracao', descricao = 'Tabela com as configura��es de assentamentos e per�odo aquisitivo para as f�rias do RH', sigla = 'rh168', dataincl = '2016-11-24', rotulo = 'Tabela de configura��o para F�rias', tipotabela = 0, naolibclass = 'f', naolibfunc = 'f', naolibprog = 'f', naolibform = 'f' where codarq = 3872;
insert into db_syscampo select 22179,'rh168_ultimoperiodoaquisitivo','bool','Informa se no cadastro de f�rias ser� exibido apenas o �ltimo per�odo aquisitivo ou os per�odos ainda com algum saldo a ser pago.','f', 'M�ltiplos per�odos aquisitivos',1,'f','f','f',5,'text','M�ltiplos per�odos aquisitivos' where not exists (select 1 from db_syscampo where codcam = 22179);
insert into db_sysarqcamp select 3872,22179,4,0 where not exists (select 1 from db_sysarqcamp where codcam = 22179);

select fc_executa_ddl('alter table recursoshumanos.tipoassentamentoferias rename to rhferiasconfiguracao');
select fc_executa_ddl('alter table recursoshumanos.rhferiasconfiguracao add column rh168_ultimoperiodoaquisitivo boolean default \'f\'');

-- Atualiza��o do nome do menu.
update db_itensmenu set descricao = 'Configura��es de F�rias' where id_item = '10156';
