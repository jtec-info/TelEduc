<?php

/**
 * Classe FeedbackObject
 * 
 * Auxiliar ao Ajax, javascript.
 * 
 * @author     TelEduc
 * @copyright  2014 TelEduc
 * @license    http://teleduc.org.br/
 */
class FeedbackObject {

    /**
     * A��es poss�veis
     * 
     * @var array 
     */
    var $actions; 
    
    /**
     *
     * @var array 
     */
    var $listOfSentences;
    
    /**
     * Construtor da Classe 
     * 
     * @param array $theListOfSentences 
     */
    function FeedbackObject($theListOfSentences) {
        $this->actions = array();
        $this->listOfSentences = $theListOfSentences;
    }
    
   /**
    * Cria a��o dos objetos
    * 
    * @param string $newAction A��o a ser feita
    * @param string $caseTrue Texto para caso a a��o seja verdade
    * @param type $caseFalse  Texto para caso a a��o seja falso
    * @return boolean Retorna True caso seja adicionada a a��o, e false caso n�o seja possivel.
    */
    function addAction($newAction, $caseTrue, $caseFalse) {
        if ((!isset($newAction)) || (!strcmp($newAction, '')))
            return false;
        $this->action[$newAction] = array(0 => $caseFalse, 1 => $caseTrue);
        return true;
    }
    
    /**
     * Retorna fun��o de Javascript para o Ajax.
     * 
     * @param string $theAction A��o escolhida 
     * @param string $theCase Nesta string ter� o valor true ou false, relacionada a a��o
     * @return boolean Caso seja possivel exibir o conte�do da a��o  retorna true, caso contr�rio false. 
     */
    function returnFeedback($theAction, $theCase) {
        if (!isset($this->action[$theAction]) || !$this->action[$theAction])
            return false;

        if (!strcmp($theCase, 'true')) {
            if (is_integer($this->action[$theAction][1])) {
                echo("        mostraFeedback('" . htmlentities(Linguas::RetornaFraseDaLista($this->listOfSentences, $this->action[$theAction][1])) . "', 'true');\n");
            } else {
                echo("        mostraFeedback('" . htmlentities($this->action[$theAction][1]) . "', 'true');\n");
            }
        } else if (!strcmp($theCase, 'false')) {
            if (is_integer($this->action[$theAction][0])) {
                echo("        mostraFeedback('" . htmlentities(RetornaFraseDaLista($this->listOfSentences, $this->action[$theAction][0])) . "', 'false');\n");
            } else {
                echo("        mostraFeedback('" . htmlentities($this->action[$theAction][0]) . "', 'false');\n");
            }
        }
        return true;
    }

}

?>