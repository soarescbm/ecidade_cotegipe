<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBselller Servicos de Informatica
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
namespace Ecidade\RecursosHumanos\RH\PontoEletronico\Manutencao;

use ECidade\RecursosHumanos\RH\Efetividade\Model\Periodo as Periodo;
use ECidade\RecursosHumanos\RH\PontoEletronico\Manutencao\EspelhoPonto;
use ECidade\RecursosHumanos\RH\PontoEletronico\Calculo\Model\ProcessamentoPontoEletronico;

class ProcessamentoAssentamentoRepository {

  public static function processarAssentamentosNoPeriodo(Periodo $oPeriodo, array $aServidores, array $aTiposAssentamentos, \Instituicao $oInstituicao) {

    foreach ($aServidores as $oServidor) {

      $oEspelhoPonto = new EspelhoPonto($oServidor, array($oPeriodo), $oInstituicao);
      $oEspelhoPonto->calcularTotalizadores();

      $dadosPonto = $oEspelhoPonto->retornaDados();

      $sHoras = null;
      foreach ($aTiposAssentamentos as $sTipoHora => $oTipoAssentamento) {

        $sHoras = null;

        switch ($sTipoHora) {
          case 'extra50diurna':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasExt50diurnas']);
            break;

          case 'extra75diurna':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasExt75diurnas']);
            break;

          case 'extra100diurna':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasExt100diurnas']);
            break;

          case 'extra50noturna':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasExt50noturnas']);
            break;

          case 'extra75noturna':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasExt75noturnas']);
            break;

          case 'extra100noturna':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasExt100noturnas']);
            break;

          case 'adicionalnoturno':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasAdicional']);
            break;

          case 'falta':
            $sHoras = EspelhoPonto::somarTotalizador($dadosPonto['nTotalHorasFaltas']);
            break;
          
          case 'faltas_dsr':

            $datasFaltas = ProcessamentoPontoEletronico::getDatasFaltas($oServidor, $oPeriodo);

            foreach ($datasFaltas as $dataFaltasDSR) {

              $dataConcessaoFaltasDSR = new \DBDate($dataFaltasDSR);
              $dataTerminoFaltasDSR   = clone $dataConcessaoFaltasDSR;

              $oAssentamento = new \Assentamento;
              $oAssentamento->setMatricula($oServidor->getMatricula());
              $oAssentamento->setServidor($oServidor);
              $oAssentamento->setTipoAssentamento($oTipoAssentamento->getSequencial());
              $oAssentamento->setDataConcessao($dataConcessaoFaltasDSR);
              $oAssentamento->setDataTermino($dataTerminoFaltasDSR);
              $oAssentamento->setDias(1);
              $oAssentamento->setDataLancamento(new \DBDate(date('Y-m-d')));
              
              \AssentamentoRepository::persist($oAssentamento);
            }
            break;
        }

        if($sTipoHora != 'faltas_dsr') {

          if (empty($sHoras) || $sHoras == '00:00') {
            continue;
          }

          $oAssentamento = new \Assentamento;
          $oAssentamento->setMatricula($oServidor->getMatricula());
          $oAssentamento->setServidor($oServidor);
          $oAssentamento->setTipoAssentamento($oTipoAssentamento->getSequencial());
          $oAssentamento->setDataConcessao(new \DBDate(date('Y-m-d')));
          $oAssentamento->setDataLancamento(new \DBDate(date('Y-m-d')));
          $oAssentamento->setHora($sHoras);
          
          \AssentamentoRepository::persist($oAssentamento);
        }
      }
    }
  }
}
