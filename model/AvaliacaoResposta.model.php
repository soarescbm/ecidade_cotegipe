<?php

/**
* Classe responsável pelas respostas das avaliação
*/
class AvaliacaoResposta {
  
  private $iPerguntaOpcao;

  private $sResposta;

  private $oPergunta;

  public function __construct() { }

  public function setPerguntaOpcao($iPerguntaOpcao) {
    $this->iPerguntaOpcao = $iPerguntaOpcao;
  }

  public function setResposta($sResposta) {
    $this->sResposta = $sResposta;
  }

  public function setPergunta(AvaliacaoPergunta $oPergunta) {
    $this->oPergunta = $oPergunta;
  }

  public function getPerguntaOpcao() {
    return $this->iPerguntaOpcao;
  }

  public function getResposta() {
    return $this->sResposta;
  }

  public function getPergunta() {
    return $this->oPergunta;
  }
}