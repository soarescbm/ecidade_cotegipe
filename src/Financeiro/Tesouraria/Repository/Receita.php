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

namespace ECidade\Financeiro\Tesouraria\Repository;

use ECidade\Financeiro\Tesouraria\Receita as ReceitaModel;

class Receita {

  protected static $itens = array();

  /**
   * @param $codigo
   * @return \ECidade\Financeiro\Tesouraria\Receita
   * @throws \BusinessException
   */
  public function getById($codigo) {

    if (empty($this->itens[$codigo])) {

      $oDaoTabRec = new \cl_tabrec();
      $oDados = \db_utils::getRowFromDao($oDaoTabRec, array($codigo));
      if (empty($oDados)) {
        throw new \BusinessException('N�o existe receita cadastrada com o c�digo '.$codigo);
      }

      $this->itens[$codigo] = $this->make($oDados);
    }

    return $this->itens[$codigo];
  }

  /**
   * Constroi a instancia da classe
   *
   * @param $oDados
   * @return \ECidade\Financeiro\Tesouraria\Receita
   */
  private function make($oDados) {

    $oReceita = new ReceitaModel();
    $oReceita->setCodigo($oDados->k02_codigo);
    $oReceita->setNome($oDados->k02_descr);
    $oReceita->setDescricao($oDados->k02_drecei);
    $oReceita->setDadosReceita($oDados);

    return $oReceita;
  }
}
