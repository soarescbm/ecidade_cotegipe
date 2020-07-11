<?php
namespace ECidade\Package\Desktop\Library;

use \ECidade\V3\Extension\AbstractManager;
use \ECidade\V3\Modification\Manager as ModificationManager;
use \ECidade\V3\Modification\Data\Modification as ModificationDataModification;
use \ECidade\V3\Extension\Data as ExtensionData;

/**
 * @package desktop
 */
class Manager extends AbstractManager {

  /**
   * Arquivo com lista de usuarios para instalar extensao Desktop
   * @var string
   */
  private $pathFileUsersInstall;

  /**
   * Arquivo com lista de usuarios que remover extensao Desktop
   * @var string
   */
  private $pathFileUsersUninstall;

  public function __construct($container = null) {

    parent::__construct($container);
    $this->pathFileUsers = ECIDADE_EXTENSION_PACKAGE_PATH . 'Desktop/users-install.json';
  }

  /**
   * @param ExtensionData $extensionData
   * @return boolean
   */
  public function install($extensionData, $user = null) {

    $users = $this->getJsonFile($this->pathFileUsers);

    if (!empty($user)) {

      if (!in_array($user, $users)) {
        throw new \Exception('Usuário sem permissão para extensão Desktop: '. $user);
      }

      $users = array($user);
    }

    $modificationManager = new ModificationManager();
    $modificationManager->setLogger($this->getLogger());

    $modificationDesktopData = ModificationDataModification::restore('dbportal-v3-desktop');

    if (!$modificationDesktopData->exists()) {
      $this->unpackModifications($modificationManager, array('desktop.xml'));
      $modificationDesktopData = ModificationDataModification::restore('dbportal-v3-desktop');
    }

    // global install
    if (empty($users)) {

      // carrega e altera modification para GLOBAL type
      $modificationDesktopData->setType(ModificationDataModification::TYPE_GLOBAL);
      $modificationDesktopData->save();

      $extensionData->setType(ExtensionData::TYPE_GLOBAL);

      return $modificationManager->install('dbportal-v3-desktop');
    }

    // user install

    // extensao por usuario, desabilita global
    $extensionData->setStatus(ExtensionData::STATUS_DISABLED);
    $extensionData->setType(ExtensionData::TYPE_USER);

    // modificacao que habilita toogle na rotina de preferencias "acesso.php"
    $modificationToggleData = ModificationDataModification::restore('dbportal-v3-toggle');

    if (!$modificationToggleData->exists()) {
      $this->unpackModifications($modificationManager, array('toggle.xml'));
    }

    if (!$modificationToggleData->isEnabled()) {
      $modificationManager->install('dbportal-v3-toggle');
    }

    // altera modification para USER type
    $modificationDesktopData->setType(ModificationDataModification::TYPE_USER);
    $modificationDesktopData->save();

    $disableAll = false;
    // instala modificacao desktop e ativa extensao Desktop para cada usuario
    foreach ($users as $user) {
      $modificationManager->install('dbportal-v3-desktop', $user);
      $modificationDesktopData = ModificationDataModification::restore('dbportal-v3-desktop');
      $extensionData->setStatus(ExtensionData::STATUS_ENABLED, $user);

      if ($modificationDesktopData->getStatus($user) === ModificationDataModification::STATUS_DISABLED) {
        $disableAll = true;
      }

    }

    // caso tenha dado erro no desktop, desativamos o desktop para todos.
    if ($disableAll) {

      $this->container->get('logger')->error();

      foreach ($extensionData->getUsersStatus() as $user => $status) {
        $extensionData->setStatus(ExtensionData::STATUS_DISABLED, $user);
      }

    }

    return true;
  }

  /**
   * Método responsavel por rodar o unpack de todas os modification, somente para atualizar o cache.
   * @return void
   */
  public function unpack() {

    $modificationManager = new ModificationManager();
    $modificationManager->setLogger($this->container->get('logger'));
    $this->unpackModifications($modificationManager, array('toggle.xml', 'desktop.xml'));
  }

  /**
   * @param ExtensionData $extensionData
   * @return boolean
   */
  public function uninstall($extensionData, $user = null) {

    $modificationManager = new ModificationManager();
    $modificationManager->setLogger($this->getLogger());

    // global install
    if (false === $extensionData->isUserType()) {
      return $modificationManager->uninstall('dbportal-v3-desktop');
    }

    // user install

    $users = $this->getJsonFile($this->pathFileUsers);

    if (!empty($user)) {

      if (!in_array($user, $users)) {
        throw new \Exception('Usuário sem permissão para extensão Desktop: '. $user);
      }

      $users = array($user);
    }

    foreach ($users as $user) {
      $modificationManager->uninstall('dbportal-v3-desktop', $user);
      $extensionData->setStatus(ExtensionData::STATUS_DISABLED, $user);
    }

    return true;
  }

  /**
   * @param \ECidade\V3\Modification\Manager $modificationManager
   * @param array $files
   * @return array
   */
  private function unpackModifications($modificationManager, array $files) {

    $force = true;
    $modifications = array();
    $rootPath = ECIDADE_EXTENSION_PACKAGE_PATH . 'Desktop/modifications/';

    foreach ($files as $path) {

      try {

        $modifications[] = $modificationManager->unpack($rootPath . $path, $force)->getId();

      } catch (\Exception $error) {
        $this->container->get('logger')->error($error->getMessage());
      }
    }

    return $modifications;
  }

  /**
   * @param string $path
   * @return array
   */
  private function getJsonFile($path) {

    $data = null;

    if (file_exists($path) && !is_readable($path)) {
      $this->container->get('logger')->debug("arquivo sem permissão de leitura: $path");
    }

    if (!file_exists($path)) {
      $this->container->get('logger')->debug("arquivo não existe: $path");
    }

    if (is_readable($path)) {

      $data = json_decode(file_get_contents($path));

      if ($data === null) {
        $this->container->get('logger')->debug("json inválido: $path");
      }
    }

    return $data;
  }

}
