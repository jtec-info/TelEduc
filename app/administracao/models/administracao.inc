<?php
$ferramenta_geral = 'geral';

$model_geral = '../../'.$ferramenta_geral.'/models/';

require_once $model_geral.'data.inc';

/**
 * Classe Model do modulo Administra��o
 * @author     TelEduc
 * @copyright  2014 TelEduc
 * @license    http://teleduc.org.br/
 */

class Administracao{
	/**
     * Este m�todo est�tico faz uma consulta ao banco a tabela Cursos e retorna um array 
     * indexado pelos nomes das colunas.
     *
     * @param mysqli_connect $sock	Inst�ncia de conex�o do mysql 
     * @param int $cod_curso Id com o c�digo do curso a ser consultado 
     * @return array Retorna um array indexado pelos nomes das colunas da tabela Cursos
     * @access public
     */
	static function RetornaDadosCursoAdm($sock,$cod_curso)
	{
		$query ="select * from Cursos where cod_curso=".$cod_curso;
		$res=AcessoSQL::Enviar($sock,$query);
		return (AcessoSQL::RetornaLinha($res));
	}
	
	/**
     * Este m�todo est�tico atualiza a tabela Cursos e 
     * retorna true se a operacao for bem sucedida 
     *
     * @param mysqli_connect sock Inst�ncia de conex�o do mysql
     * @param int $cod_curso Id com o c�digo do curso a ser consultado
     * @param string $nome_curso Nome do curso 
     * @param string $inscricao_inicio Data de in�cio da inscri��o no formato dd/mm/yyyy ou mm/dd/yyyy
     * @param string $curso_inicio Data do in�cio do curso no formato dd/mm/yyyy ou mm/dd/yyyy 
     * @param string $curso_fim Data do fim do curso no formato dd/mm/yyyy ou mm/dd/yyyy 
     * @param string $informacoes Texto sobre informa��es adicionais
     * @param string $publico_alvo Texto sobre publico alvo
     * @param string $tipo_inscricao  Texto
     * @param string $acesso_visitante Texto 
     * @param int $cod_lingua Id relacionou da tabela de linguas
     * @param string $horario Timestamp, funcao time() do php 
     * @return boolean Se true operacao foi bem sucessidida
     * @access public
     */
	static function CadastraDadosCurso($sock,$cod_curso,$nome_curso,$inscricao_inicio,$inscricao_fim,$curso_inicio,$curso_fim,$informacoes,$publico_alvo,$tipo_inscricao,$acesso_visitante,$cod_lingua,$horario)
	{
		if ($acesso_visitante!='A')
			$acesso_visitante='N';
	
		$nome_curso = ConversorTexto::EliminaScript($nome_curso);
		$informacoes=ConversorTexto::EliminaScript($informacoes);
		$publico_alvo=ConversorTexto::EliminaScript($publico_alvo);
		$tipo_inscricao=ConversorTexto::EliminaScript($tipo_inscricao);
	
		$query ="update Cursos set nome_curso='".$nome_curso."',";
		$query.=" inscricao_inicio=".Data::Data2Unixtime($inscricao_inicio).",";
		$query.=" inscricao_fim=".Data::Data2Unixtime($inscricao_fim).",";
		$query.=" curso_inicio=".Data::Data2Unixtime($curso_inicio).",";
		$query.=" curso_fim=".Data::Data2Unixtime($curso_fim).",";
		$query.=" informacoes='".$informacoes."',";
		$query.=" publico_alvo='".$publico_alvo."',";
		$query.=" tipo_inscricao='".$tipo_inscricao."',";
		$query.=" cod_lingua=".$cod_lingua.",";
		$query.=" acesso_visitante='".$acesso_visitante."',";
		$query.=" _timestamp=".$horario;
		$query.=" where cod_curso=".$cod_curso;
		
		$res=AcessoSQL::Enviar($sock,$query);
		return $res;
	}
}
?>