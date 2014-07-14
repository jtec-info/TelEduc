 <?php 
 $sock=AcessoSQL::Conectar($cod_curso);
 

  // Tempo para um usuario ser considerado offline em segundos
  $time_out=30*60;

  /* Fun��es javascript */
  echo("    <script language=\"javascript\" type=\"text/javascript\">\n");
  /* *********************************************************
  Funcao MostraPerfil
    Abre nova janela com o perfil
  */

  echo("      function MostrarPerfil() \n");
  echo("      {\n");
  echo("          window.open(\"../perfil/exibir_perfis.php?cod_curso=".$cod_curso."&cod_aluno[]=".$cod_usuario."\",'NOME','width=600,height=400,scrollbars=yes,status=yes,toolbar=no,menubar=no,resizable=yes');\n");
  echo("      }\n\n");

  echo("      function FechandoNavegador() {\n");
  echo("          xajax_DeslogaUsuarioCursoDinamic('".$cod_curso."', '".$cod_usuario."');\n");
  echo("      }\n\n");

  echo("    </script>\n");

  echo("  </head>\n");

  /* Quando estamos salvando em arquivo, o logo, menu, js e links do topo serao ocultados */
  if($SalvarEmArquivo){

    echo("  <body>\n");
    echo("    <table cellpadding=\"0\" cellspacing=\"0\" id=\"container\">\n");
    echo("      <tr><td>\n");
    echo("          <h3>".Cursos::NomeCurso($sock,$cod_curso)."</h3>\n");
    echo("      </td></tr>\n");
  } else {


    echo("  <body onload=\"Iniciar();\" onbeforeunload=\"FechandoNavegador();\">\n");

    echo("    <a name=\"topo\"></a>\n");
    echo("    <h1><a href=\"http://".$tela_host.$tela_raiz_www."\"><img src=\"".$diretorio_imgs."logo.gif\" border=\"0\" alt=\"TelEduc . Educa&ccedil;&atilde;o &agrave; Dist&acirc;ncia\" /></a></h1>\n");

    echo("    <table cellpadding=\"0\" cellspacing=\"0\" id=\"container\">\n");
    echo("      <tr>\n");
    echo("        <td></td>\n");
    echo("        <td valign=\"top\">\n");
    
    $tela_curso_ferramentas    = Menu::RetornaFerramentasCurso($sock);
    $tela_novidade_ferramentas = Menu::RetornaNovidadeFerramentas($sock,$cod_curso,$cod_usuario);
    $tela_marcar_ferramenta    = Menu::RetornaFerramentasMarcadas($sock);
    $tela_ultimo_acesso = Usuarios::PenultimoAcesso($sock,$cod_usuario,"");
    
    Usuarios::AtualizaVisita($sock, $cod_usuario);
    
    if (!empty ($_SESSION['cod_usuario_global_s'])) {
    	$email_usuario = Usuarios::RetornaEmailUsuario1($_SESSION['cod_usuario_global_s']);
    }
    $tela_email = "<li><a href=\"#\" onclick=\"javascript:MostrarPerfil();\" style=\"text-decoration:none;\" class=\"email\">".$email_usuario."</a></li>\n";
    
    if ($tela_formadormesmo)
    {
    	echo("          <!-- Navegacao Nvel 3 -->\n");
    	echo("          <ul id=\"nav3nivel\">\n");
    	if ($tela_formador)
    	{
    
    		$tela_hrefAluno="<li class=\"visoes\"><a href=\"../controllers/index_curso2.php?cod_curso=".$cod_curso."&amp;ativar_visao_aluno=sim\" >";
    
    		$tela_hrefFormador="<li class=\"visoes2\">";
    
    		$tela_fechaHrefAluno = "</a>";
    
    		$tela_fechaHrefFormador = "";
    	}
    	else
    	{
    
    		$tela_hrefAluno="<li class=\"visoes2\">";
    
    		$tela_hrefFormador="<li class=\"visoes\"><a href=\"../controllers/index_curso2.php?cod_curso=".$cod_curso."&amp;desativar_visao_aluno=sim\" >";
    
    		$tela_fechaHrefAluno = "";
    
    		$tela_fechaHrefFormador = "</a>";
    
    	}
    
    	// 46 - Vis�o de Formador
    	$tela_nome_ferramenta=Linguas::RetornaFraseDaLista($lista_frases_menu,46);
    	echo("            ".$tela_hrefFormador.$tela_nome_ferramenta.$tela_fechaHrefFormador."</li>\n");
    	// 45 - Vis�o de Aluno
    
    	$tela_nome_ferramenta=Linguas::RetornaFraseDaLista($lista_frases_menu,45);
    	echo("            ".$tela_hrefAluno.$tela_nome_ferramenta.$tela_fechaHrefAluno."</li>\n");
    	echo("          </ul>\n");
    
    }

    echo("          <div id=\"btsNivel3\" class=\"menu_dd\">\n");
    
    echo("            <ul>\n");
    echo("              ".$tela_email."\n");
    echo("              <li>&nbsp;&nbsp;|&nbsp;&nbsp</li>");
    
    Inicial::RetornaListaDeCursosUsuario($sock);
    
    /* 47 - Configurar */
    $tela_nome_ferramenta=Linguas::RetornaFraseDaLista($lista_frases_menu,47);
    
    $tela_cod_ferr=-7;
    $tela_diretorio="configurar";
    echo("              <li>&nbsp;&nbsp;|&nbsp;&nbsp;</li>\n");
    echo("              <li><a href=\"../".$tela_diretorio."/".$tela_diretorio.".php?cod_curso=".$cod_curso."&amp;cod_usuario=".$cod_usuario."&amp;cod_ferramenta=".$tela_cod_ferr."\">$tela_nome_ferramenta</a></li>\n");
    echo("              <li>&nbsp;&nbsp;|&nbsp;&nbsp;</li>\n");
    if ($tela_formador)
    {
    	/* Suporte */
    	$tela_nome_ferramenta=Linguas::RetornaFraseDaLista($lista_frases_menu,39);
    	echo("              <li><a href=\"mailto:".$tela_email_suporte."\">$tela_nome_ferramenta</a></li>\n");
    	echo("              <li>&nbsp;&nbsp;|&nbsp;&nbsp;</li>\n");
    
    	/* Administracao */
    	$tela_cod_ferr=0;
    	$tela_nome_ferramenta=Linguas::RetornaFraseDaLista($lista_frases_menu,37);
    	$tela_diretorio="administracao";
    
    
    	echo("              <li><a href=\"../".$tela_diretorio."/".$tela_diretorio.".php?cod_curso=".$cod_curso."&amp;cod_usuario=".$cod_usuario."&amp;cod_ferramenta=".$tela_cod_ferr."\">$tela_nome_ferramenta</a></li>\n");
    	echo("              <li>&nbsp;&nbsp;|&nbsp;&nbsp;</li>\n");
    
    }
    /*Ajuda */
    // 43 - Voltar ao in�cio
    $tela_nome_ferramenta=Linguas::RetornaFraseDaLista($lista_frases_menu,43);
    echo("            ".Cursos::PreparaAjuda($sock, $cod_curso,$cod_ferramenta_ajuda,$cod_pagina_ajuda, $cod_usuario)."\n");
    echo("            <li><img src=\"".$diretorio_imgs."icSair.gif\" border=\"0\" alt=\"Sair\" />&nbsp;</li>\n");
    //echo("            <li><a href=\"../../../pagina_inicial/exibe_cursos.php\">".$tela_nome_ferramenta."</a></li>\n");
    echo("            <li><a href=\"../../../pagina_inicial/exibe_cursos.php\" onclick=javascript:FechandoNavegador();>".$tela_nome_ferramenta."</a></li>\n");
    
    echo("            </ul>\n");
    echo("          </div>\n");
    
    echo("          <h3>".Cursos::NomeCurso($sock,$cod_curso)."</h3>\n");
    echo("          <div id=\"feedback\" class=\"feedback_hidden\"><span id=\"span_feedback\">ocorreu um erro na sua solicita&ccedil&atilde;o</span></div>\n");
    echo("        </td>\n");
    echo("      </tr>\n");
    echo("      <tr>\n");
    
    echo("        <td style=\"width:200px\" valign=\"top\">\n");
    echo("          <!-- Navegacao Principal -->\n");
    echo("          <ul id=\"nav\">\n");
    
    // Ferramenta 11 - Correio
    // Ferramenta 12 - Grupos
    // Ferramenta 14 - Di�rio de bordo
    // Ferramenta 15 - Portfolio
    // Ferramenta 18 - Acessos
    // Ferramenta 19 - Intermap
    // Ferramenta 22 - Avaliacoes
    // Ferramenta 23 - Execicios
    
    // Lista das ferramentas a esconder de visitantes
    $tela_array_visitante   = array (11, 12, 14, 15, 18, 19, 22, 23);
    // Lista das ferramentas a esconder de colaboradores
    $tela_array_colaborador = array ();
    
    foreach($tela_ordem_ferramentas as $cod => $linha)
    {
    	$tela_cod_ferr=$linha['cod_ferramenta'];
    
    	if($tela_cod_ferr != -1) {
    		$tela_nome_ferramenta = Linguas::RetornaFraseDaLista($lista_frases_menu,$tela_lista_ferramentas[$tela_cod_ferr]['cod_texto_nome']);
    		$tela_diretorio = $tela_lista_ferramentas[$tela_cod_ferr]['diretorio'];
    		if (isset($tela_curso_ferramentas[$tela_cod_ferr])) {
    			$tela_status = $tela_curso_ferramentas[$tela_cod_ferr]['status'];
    		}
    		else {
    			$tela_status = 'A';
    		}
    
    		$tela_exibir = true;
    		if ($tela_colaborador)
    		{
    			// verifica na lista se deve exibir a ferramenta para o colaborador
    			$tela_exibir = ! in_array ($tela_cod_ferr, $tela_array_colaborador);
    		}
    		else if ($tela_visitante)
    		{
    			$tela_exibir = ! in_array ($tela_cod_ferr, $tela_array_visitante);
    		}
    
    		if ($tela_exibir)
    		{
    			@$tela_data=$tela_novidade_ferramentas[$tela_cod_ferr];
    			$tela_style = "";
    			if ((count($tela_marcar_ferramenta) > 0) && (@$tela_marcar_ferramenta[$tela_cod_ferr])){
    				$tela_style = "Destacada ";
    			}
    
    			if ($tela_cod_ferr!= -1 and $tela_status!="D" and ($tela_status!="F" or $tela_formador))
    			{
    				Menu::ExibeLink($cod_curso,$tela_cod_ferr,$tela_nome_ferramenta,$tela_diretorio,$tela_data,$tela_ultimo_acesso,$tela_style,$cod_ferramenta,$cod_usuario);
    			}
    		}
    	}
    }
    
    echo("          </ul>\n");
    
    echo("          <br>");
    
    // Lista os usuarios online
    $lista_usuarios_online=Usuarios::RetornaUsuariosOnline($sock, $time_out);
    
    echo("          <ul class=\"usuarioOnlineExterno\">\n");
    echo("            <li class=\"usuarioOnlineHead\">\n");
    echo("               ".Linguas::RetornaFraseDaLista($lista_frases_menu,60)."\n");
    echo("            </li>\n");
    foreach($lista_usuarios_online as $cod => $linha) {
    	echo("            <li class=\"usuarioOnlineLista\">\n");
    	echo("               ".Usuarios::NomeUsuario($sock, $linha["cod_usuario"], $cod_curso)."\n");
    	echo("            </li>\n");
    }
    echo("            </ul>\n");
    echo("        </td>\n");
    
	
    }
