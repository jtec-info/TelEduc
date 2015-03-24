<?php
$ferramenta_geral = 'geral';
$ferramenta_administracao = 'administracao';

$model_geral = '../../'.$ferramenta_geral.'/models/';
$model_administracao = '../../'.$ferramenta_administracao.'/models/';
$view_administracao = '../../'.$ferramenta_administracao.'/views/';
$ctrl_administracao = '../../'.$ferramenta_administracao.'/controllers/';
$diretorio_imgs = '../../../web-content/imgs/';

require_once $model_geral.'geral.inc';
require_once $model_administracao.'administracao.inc';

$cod_ferramenta = 0;
$cod_ferramenta_ajuda = $cod_ferramenta;
$cod_pagina_ajuda = 2;

require_once $view_administracao.'topo_tela.php';

DataJavaScript::GeraJSComparacaoDatas();
DataJavaScript::GeraJSVerificacaoData();

/* Fun�es javascrip */

if ($ecoordenador = Usuarios::ECoordenador($sock,$cod_curso,$cod_usuario))
{
	echo("    <script type=\"text/javascript\" language=\"javascript\">\n");

	echo("      var isNav = (navigator.appName.indexOf(\"Netscape\") !=-1);\n");
	echo("      var versao = (navigator.appVersion.substring(0,3));\n");
	echo("      var isIE = (navigator.appName.indexOf(\"Microsoft\") !=-1);\n");

	echo("      if (isNav)\n");
	echo("      {\n");
	echo("        document.captureEvents(Event.MOUSEMOVE);\n");
	echo("      }\n");
	echo("      document.onmousemove = TrataMouse;\n\n");

	echo("      function TrataMouse(e)\n");
	echo("      {\n");
	echo("        Ypos = (isMinNS4) ? e.pageY : event.clientY;\n");
	echo("        Xpos = (isMinNS4) ? e.pageX : event.clientX;\n");
	echo("      }\n\n");

	echo("      function getPageScrollY()\n");
	echo("      {\n");
	echo("        if (isNav)\n");
	echo("          return(window.pageYOffset);\n");
	echo("        if (isIE)\n");
	echo("          return(document.body.scrollTop);\n");
	echo("      }\n\n");
	echo("      function AjustePosMenuIE()\n");
	echo("      {\n");
	echo("        if (isIE)\n");
	echo("          return(getPageScrollY());\n");
	echo("        else\n");
	echo("          return(0);\n");
	echo("      }\n\n");

	/* Iniciliza os layers. */
	echo("      function iniciar()\n");
	echo("      {\n");
	echo("        lay_calendario = getLayer('layer_calendario');\n");
	echo("      }\n\n");

	// Esconde o layer especificado por cod_layer.
	echo("      function EscondeLayer(cod_layer)\n");
	echo("      {\n");
	echo("        hideLayer(cod_layer);\n");
	echo("      }\n\n");

	/* Esconde todos os layers. Se o usuario for o propriet�rio do di�rio   */
	/* visualizado ent�o esconde o layer para renomear o item.              */
	echo("      function EscondeLayers()\n");
	echo("      {\n");
	echo("        hideLayer(lay_calendario);\n");
	echo("      }\n\n");

	/* Exibe o layer especificado por cod_layer.                            */
	echo("      function MostraLayer(cod_layer)\n");
	echo("      {\n");
	echo("        EscondeLayers();\n");
	echo("        moveLayerTo(cod_layer, Xpos, Ypos + AjustePosMenuIE());\n");
	echo("        showLayer(cod_layer);\n");
	echo("      }\n\n");

	echo("      function verifica_intervalos()\n");
	echo("      {\n");
	echo("        var i_ini = document.altera_dados.inscricao_inicio;\n");
	echo("        var i_fim = document.altera_dados.inscricao_fim;\n");
	echo("        var c_ini = document.altera_dados.curso_inicio;\n");
	echo("        var c_fim = document.altera_dados.curso_fim;\n");
	echo("\n");
	echo("        if (ComparaData(i_ini, i_fim) > 0) \n");
	echo("        {\n");
	echo("           /* 8 - A data inicial do per�odo de inscri��o deve ser anterior � data final desse per�odo. */\n");
	echo("           alert('"._("ENR_DATE_BEFORE_FINAL_0")."');\n");
	echo("           return(false);\n");
	echo("        }\n");
	echo("        if (ComparaData(c_ini, c_fim) > 0) \n");
	echo("        {\n");
	echo("           /* 9 - A data inicial do curso deve ser anterior � sua data final. */\n");
	echo("           alert('"._("COURSE_DATE_BEFORE_FINAL_0")."');\n");
	echo("           return(false);\n");
	echo("        }\n");
	echo("        if (ComparaData(i_ini, c_fim) > 0) \n");
	echo("        {\n");
	echo("        /* 10 - A data inicial do per�odo de inscri��o deve ser anterior � data final do curso. */\n");
	echo("          alert('"._("ENR_DATE_BEFORE_COURSE_FINAL_0")."');\n");
	echo("          return(false);\n");
	echo("        }\n");
	echo("        if (ComparaData(i_fim, c_fim) > 0) \n");
	echo("        {\n");
	echo("          /* 11 - A data final do per�odo de inscri��o deve ser anterior � data final do curso. */\n");
	echo("          alert('"._("ENR_FINAL_DATE_BEFORE_COURSE_FINAL_0")."');\n");
	echo("          return(false);\n");
	echo("        }\n");
	echo("        if (ComparaData(i_ini, c_ini) > 0) \n");
	echo("        {\n");
	echo("          /* 12 - A data inicial do per�odo de inscri��o deve ser anterior � data inicial do curso. */\n");
	echo("          alert('"._("ENR_DATE_BEFORE_COURSE_0")."');\n");
	echo("          return(false);\n");
	echo("        }\n");
	echo("        return(true);\n");
	echo("      }\n");

	echo("      function confirma() \n");
	echo("      {\n");
	echo("        var c1=document.altera_dados.nome_curso.value;\n");
	echo("        var c2=document.altera_dados.informacoes.value;\n");
	echo("        var c4=document.altera_dados.publico_alvo.value;\n");
	echo("        var c5=document.altera_dados.tipo_inscricao.value;\n");
	echo("        var c6=document.altera_dados.curso_inicio.value;\n");
	echo("        var c7=document.altera_dados.curso_fim.value;\n");
	echo("        var c8=document.altera_dados.inscricao_inicio.value;\n");
	echo("        var c9=document.altera_dados.inscricao_fim.value;\n");
	echo("\n");
	echo("        if (c1=='' || c2=='' || c4=='' || c5=='' || c6=='' || c7=='' || c8=='' || c9=='') \n");
	echo("        {\n");
	/* 13 - Por favor preencha todos os campos antes de pressionar Alterar. */
	echo("          alert('"._("FILL_ALL_FIELDS_0")."');\n");
	echo("          return(false);\n");
	echo("        } \n");
	echo("        else\n");
	echo("        {\n");
	echo("          return (verifica_intervalos());\n");
	echo("        }\n");
	echo("      }\n");
	echo("    </script>\n");
}

echo("    <script type=\"text/javascript\">\n");
echo("      function Iniciar()\n");
echo("      {\n");
echo("        startList();\n");
echo("      }\n\n");
echo("    </script>\n");

require_once $view_administracao.'menu_principal.php';

/* Fun��es javascript */

echo("        <td width=\"100%\" valign=\"top\" id=\"conteudo\">\n");

if(!Usuarios::EFormador($sock,$cod_curso,$cod_usuario))
{
	/* 1 - Administracao  28 - Area restrita ao formador. */
	echo("          <h4>"._("ADMINISTRATION_-5")." - "._("RESTRICTED_AREA_INSTRUCTOR_0")."</h4>\n");

	/*Voltar*/
	/* 509 - Voltar */
	echo("          <ul class=\"btsNav\"><li><span onclick=\"javascript:history.back(-1);\">&nbsp;&lt;&nbsp;"._("BACK_-1")."&nbsp;</span></li></ul>\n");

	echo("          <div id=\"mudarFonte\">\n");
	echo("            <a onclick=\"mudafonte(2)\" href=\"#\"><img width=\"17\" height=\"15\" border=\"0\" align=\"right\" alt=\"Letra tamanho 3\" src=\"".$diretorio_imgs."btFont1.gif\"/></a>\n");
	echo("            <a onclick=\"mudafonte(1)\" href=\"#\"><img width=\"15\" height=\"15\" border=\"0\" align=\"right\" alt=\"Letra tamanho 2\" src=\"".$diretorio_imgs."btFont2.gif\"/></a>\n");
	echo("            <a onclick=\"mudafonte(0)\" href=\"#\"><img width=\"14\" height=\"15\" border=\"0\" align=\"right\" alt=\"Letra tamanho 1\" src=\"".$diretorio_imgs."btFont3.gif\"/></a>\n");
	echo("          </div>\n");

	/* 23 - Voltar (gen) */
	echo("          <form><input class=\"input\" type=\"button\" value=\""._("BACK_-1")."\" onclick=\"history.go(-1);\" /></form>\n");

	echo("        </td>\n");
	echo("      </tr>\n");

	include $diretorio_views.'tela2.php';

	echo("  </body>\n");
	echo("</html>\n");
	AcessoSQL::Desconectar($sock);
	exit();
}

/*Forms*/

echo("    <form action =\"".$ctrl_administracao."acoes_administracao.php\" method=\"post\" name=\"altera_dados\" onSubmit='return(confirma());'>\n");
echo("      <input type=\"hidden\" name=\"cod_curso\" value=".$cod_curso.">\n");
echo("      <input type=\"hidden\" name=\"cod_ferramenta\" value=".$cod_ferramenta.">\n");
echo("      <input type=\"hidden\" name=\"action\" value='alterarDadosCurso'>\n");

// P�gina Principal
/* 1 - Administra��o */
$cabecalho = "          <h4>"._("ADMINISTRATION_-5")."\n";
if ($ecoordenador)
{
	/* 2 - Visualizar / Alterar Dados do Curso */
	$cabecalho .= " - "._("VIEW_CHANGE_COURSE_DATA_0")."</h4>";
	echo($cabecalho);
}
else
{
	/* 49 - Visualizar dados do curso */
	$cabecalho .= " - "._("VIEW_COURSE_DATA_0")."</h4>";
	echo($cabecalho);
}

// 3 A's - Muda o Tamanho da fonte
echo("      <div id=\"mudarFonte\">\n");
echo("      <a onclick=\"mudafonte(2)\" href=\"#\"><img width=\"17\" height=\"15\" border=\"0\" align=\"right\" alt=\"Letra tamanho 3\" src=\"".$diretorio_imgs."btFont1.gif\"/></a>\n");
echo("      <a onclick=\"mudafonte(1)\" href=\"#\"><img width=\"15\" height=\"15\" border=\"0\" align=\"right\" alt=\"Letra tamanho 2\" src=\"".$diretorio_imgs."btFont2.gif\"/></a>\n");
echo("      <a onclick=\"mudafonte(0)\" href=\"#\"><img width=\"14\" height=\"15\" border=\"0\" align=\"right\" alt=\"Letra tamanho 1\" src=\"".$diretorio_imgs."btFont3.gif\"/></a>\n");
echo("      </div>\n");

/*Voltar*/
/* 509 - Voltar */
echo("                  <ul class=\"btsNav\"><li><span onclick=\"javascript:history.back(-1);\">&nbsp;&lt;&nbsp;"._("BACK_-1")."&nbsp;</span></li></ul>\n");

$linha = Administracao::RetornaDadosCursoAdm($sock,$cod_curso);

$dia = date(d);
$mes = date(m);
$ano = date(Y);
if ($linha['curso_inicio']== NULL)
	$linha['curso_inicio']= Data::Data2Unixtime($dia."/".$mes."/".$ano);
if ($linha['curso_fim']== NULL)
	$linha['curso_fim']= Data::Data2Unixtime($dia."/".$mes."/".$ano);
if ($linha['inscricao_inicio']== NULL)
	$linha['inscricao_inicio']= Data::Data2Unixtime($dia."/".$mes."/".$ano);
if ($linha['inscricao_fim']== NULL)
	$linha['inscricao_fim']= Data::Data2Unixtime($dia."/".$mes."/".$ano);
 
 
 
echo("          <table cellpadding=\"0\" cellspacing=\"0\"  id=\"tabelaExterna\" class=\"tabExterna\">\n");
echo("            <tr>\n");
echo("              <td valign=\"top\">\n");
echo("                <ul class=\"btAuxTabs\">\n");
/* 23 - Voltar (geral)*/
echo("                  <li><a href=\"administracao.php?cod_curso=".$cod_curso."&amp;cod_ferramenta=".$cod_ferramenta."&amp;confirma=0\">"._("BACK_-1")."</a></li>\n");
echo("                </ul>\n");
echo("              </td>\n");
echo("            </tr>\n");
echo("            <tr>\n");
echo("              <td>\n");
echo("                <table cellpadding=\"0\" cellspacing=\"0\" class=\"tabInterna\">\n");
if ($ecoordenador)
{
	echo("                  <tr class=\"head alLeft\">\n");
	/* 14 - Abaixo seguem dados referentes ao curso. Para alter�-los, modifique os campos desejados e pressione o bot�o Alterar. */
	echo("                    <td colspan=4>"._("COURSE_DATA_FILL_CHANGE_0")."</td>\n");
	echo("                  </tr>\n");
}
echo("                  <tr>\n");
echo("                    <td align=\"left\" style=\"padding-left:200px;\" >\n");
echo("                      <table>\n");
echo("                        <tr>\n");

/* 15- Nome */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("NAME_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
	echo("                            <input class=\"input\" type=\"text\" name=\"nome_curso\" size=\"50\" style=\"width:416px;\" value='".ConversorTexto::ConverteAspas2Html($linha['nome_curso'])."'>");
else
	echo("                            ".$linha['nome_curso']);
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 16 - Informa��es */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("INFORMATIONS_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
	echo("                            <textarea class=\"input\" name=\"informacoes\" cols=\"50\" rows=\"6\">".ConversorTexto::ConverteAspas2Html($linha['informacoes'])."</textarea>\n");
else
	echo("                            ".ConversorTexto::LimpaTags($linha['informacoes']));
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 17 - In�cio do curso */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("COURSE_BEGIN_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
{
	echo("                            <ul>\n");
	echo("                              <li>\n");
	echo("                                <div>\n");
	echo("                                  <input class=\"input\" type=\"text\" size=\"10\" maxlength=\"10\" id=\"data_ini\" name=\"curso_inicio\" value=\"".Data::UnixTime2Data($linha['curso_inicio'])."\" />\n");
	echo("                                   <img src=\"".$diretorio_imgs."ico_calendario.gif\" alt=\"calendario\" onclick=\"displayCalendar(document.getElementById('data_ini'),'dd/mm/yyyy',this);\" />\n");
	echo("                                </div>\n");
	echo("                              </li>\n");
	echo("                            </ul>\n");
}
else
	echo("                            ".Data::UnixTime2Data($linha['curso_inicio']));
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 18 - Fim do curso */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("COURSE_END_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
{
	echo("                            <ul>\n");
	echo("                              <li>\n");
	echo("                                <div>\n");
	echo("                                  <input class=\"input\" type=\"text\" size=\"10\" maxlength=\"10\" id=\"data_fim\" name=\"curso_fim\" value=\"".Data::UnixTime2Data($linha['curso_fim'])."\" />\n");
	echo("                                   <img src=\"".$diretorio_imgs."ico_calendario.gif\" alt=\"calendario\" onclick=\"displayCalendar(document.getElementById('data_fim'),'dd/mm/yyyy',this);\" />\n");
	echo("                                </div>\n");
	echo("                              </li>\n");
	echo("                            </ul>\n");
}
else
	echo("                            ".Data::UnixTime2Data($linha['curso_fim']));
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 19 - In�cio das incri��es */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("ENROLLMENT_BEGIN_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
{
	echo("                            <ul>\n");
	echo("                              <li>\n");
	echo("                                <div>\n");
	echo("                                  <input class=\"input\" type=\"text\" size=\"10\" maxlength=\"10\" id=\"inscricao_inicio\" name=\"inscricao_inicio\" value=\"".Data::UnixTime2Data($linha['inscricao_inicio'])."\" />\n");
	echo("                                   <img src=\"".$diretorio_imgs."ico_calendario.gif\" alt=\"calendario\" onclick=\"displayCalendar(document.getElementById('inscricao_inicio'),'dd/mm/yyyy',this);\" />\n");
	echo("                                </div>\n");
	echo("                              </li>\n");
	echo("                            </ul>\n");
}
else
	echo("                            ".Data::UnixTime2Data($linha['inscricao_inicio']));
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 20 - Fim das inscri��es */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("ENROLLMENT_END_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
{
	echo("                            <ul>\n");
	echo("                              <li>\n");
	echo("                                <div>\n");
	echo("                                  <input class=\"input\" type=\"text\" size=\"10\" maxlength=\"10\" id=\"inscricao_fim\" name=\"inscricao_fim\" value=\"".Data::UnixTime2Data($linha['inscricao_fim'])."\" />\n");
	echo("                                   <img src=\"".$diretorio_imgs."ico_calendario.gif\" alt=\"calendario\" onclick=\"displayCalendar(document.getElementById('inscricao_fim'),'dd/mm/yyyy',this);\" />\n");
	echo("                                </div>\n");
	echo("                              </li>\n");
	echo("                            </ul>\n");
}
else
	echo("                            ".Data::UnixTime2Data($linha['inscricao_fim']));
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 21 - P�blico alvo */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("TARGET_AUDIENCE_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
	echo("                          <input class=\"input\" type=\"text\" name=\"publico_alvo\" size=\"50\" style=\"width:416px;\" value='".ConversorTexto::ConverteAspas2Html($linha['publico_alvo'])."'>\n");
else
	echo("                          ".$linha['publico_alvo']);
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

/* 22 - Tipo de inscri��o */
echo("                          <td style=\"border:none; text-align:right;\"><b>"._("ENROLLMENT_TYPE_0").":</b></td>\n");
echo("                          <td style=\"border:none\">\n");
if ($ecoordenador)
	echo("                            <input class=\"input\" type=\"text\" name=\"tipo_inscricao\" size=\"50\" style=\"width:416px;\" value='".ConversorTexto::ConverteAspas2Html($linha['tipo_inscricao'])."'>\n");
else
	echo("                            ".$linha['tipo_inscricao']);
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                        <tr>\n");

echo("                          <td style=\"border:none; text-align:right;\"><b>");
// 148 - L�ngua do curso:
echo("                      "._("COURSE_LANGUAGE_0")." \n");
echo("                            </b></td>\n");

echo("                          <td style=\"border:none\">\n");
echo("                            <select style=\"font-size:0.9em;\" class=\"input\" name=\"cod_lin\">\n");

$lista_linguas = Linguas::ListaLinguas($sock);

foreach ($lista_linguas as $cod_lin => $lingua)
{
	$sel="";
	if ($cod_lin == $linha['cod_lingua'])
		$sel="selected";
	echo("                              <option ".$sel."  value=".$cod_lin.">".$lingua."</option>\n");
}

echo("                            </select>\n");
echo("                          </td>\n");
echo("                        </tr>\n");
echo("                      </table>\n");
echo("                    </td>\n");
echo("                  </tr>\n");
echo("                </table>\n");


if ($ecoordenador)
{
	/* 23 - Obs: */
	/* 24 - As datas devem estar no formato DD/MM/AAAA. */
	echo("              <b>"._("NOTE_0")."</b> "._("DATE_FORMATE_0")."\n");
	echo("              <br><br>\n");
	/* 23 - Obs: */
	/* 229 - Caso a data de inicio do curso seja maior que a data de fim das inscri��es, o curso somente poder� ser acessado diretamente pelo link recebido no e-mail do coordenador. Ou seja, ele n�o ser� listado em nenhuma das se��es 'Cursos em andamento', 'Cursos com inscri��es abertas' ou 'Cursos j� oferecidos'. */
	echo("              <b>"._("NOTE_0")."</b> "._("BEGIN_DATE_GREATER_ENR_END_DATE_0")."\n");
	echo("              <br><br>\n");
	/* 24 - Alterar (geral) */
	echo("                <div align=\"right\"><input type=\"submit\" class=\"input\" value='"._("CHANGE_-1")."'></div>\n");
}

echo("              </td>\n");
echo("            </tr>\n");
echo("          </table>\n");
echo("        </form>\n");
echo("        </td>\n");
echo("      </tr>\n");
require_once $view_administracao.'tela2.php';
echo("  </body>\n");
echo("</html>\n");
AcessoSQL::Desconectar($sock);




?>