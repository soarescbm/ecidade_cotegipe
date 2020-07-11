<?php

require_once ("libs/db_stdlib.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/JSON.php");  

$oJson                  = new services_json();
$oParam                 = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno               = new stdClass();
$oRetorno->iStatus      = 1;
$oRetorno->erro = false;
$oRetorno->sMessage     = '';

try {

  switch ($oParam->exec) {

    case "getTarefas":

      $aTarefas = array();

      $oAgenda = new Agenda();
      $aJobs = $oAgenda->importarTarefas();

      foreach($aJobs as $oJob) {

        $sCaminhoArquivoLock = TaskManager::PATH_LOCKS . $oJob->getNome() . ".lock";
        $iTempoExecucao = file_exists($sCaminhoArquivoLock) ? time() - filemtime($sCaminhoArquivoLock) : 0;
        $sStatus = $iTempoExecucao > 0 ? 'Executando há ' . round($iTempoExecucao/60, 2) . ' minuto(s)' : 'Fila';
 
        $sTextoErro = '';

        if ( file_exists($sCaminhoArquivoLock) ) {
          $lock = file($sCaminhoArquivoLock);
          $sTextoErro = !empty($lock[2]) ? str_replace('UltimoErro=', '', $lock[2]) : '';
        }

        $aTarefas[] = array(
          'sNome' => $oJob->getNome(),
          'sDescricao' => $oJob->getDescricao(),
          'sDataCriacao' =>  date('d/m/Y H:i', $oJob->getMomentoCricao()),
          'sTipoPeriodicidade' => urlencode($oAgenda->getDescricaoPeriodicidade($oJob->getTipoPeriodicidade())),
          'aPeriodicidades' => $oJob->getPeriodicidades(),
          'sStatus' => urlencode($sStatus),
          'sTextoErro' => $sTextoErro,
          'lLock' => file_exists($sCaminhoArquivoLock)
        );
      }

      $oRetorno->aTarefas = $aTarefas;

    break;

    case "apagarLock":

      $sCaminhoArquivoLock = TaskManager::PATH_LOCKS . $oParam->sNome . ".lock";

      if (!file_exists($sCaminhoArquivoLock)) {
        throw new Exception("Arquivo de lock não existe mais.");
      }

      if (!unlink($sCaminhoArquivoLock) ) {
        throw new Exception('Erro ao apagar o arquivo de lock, tente novamente.');
      }

      $oRetorno->sMessage = 'Arquivo de lock apagado com sucesso.';

    break;
  }
    
  
} catch (Exception $eErro){
  
  db_fim_transacao(true);
  $oRetorno->iStatus  = 2;
  $oRetorno->sMessage = urlencode($eErro->getMessage());
  $oRetorno->erro = true;
}

echo $oJson->encode($oRetorno);