<?php

$ferramenta_login = 'login';

$view_login = "../../".$ferramenta_login.'/views/';

session_start();

//$_SESSION['logout_flag_s'] = 1;

//unset($_SESSION['cod_lingua_s']);
//unset($_SESSION['visitantes_s']);
//unset($_SESSION['visao_aluno_s']);
//unset($_SESSION['lista_frases_s']);
//unset($_SESSION['login_usuario_s']);
//unset($_SESSION['cod_usuario_global_s']);

session_destroy();


//$_SESSION['logout_flag_s']=0;


header("Location: ".$view_login."autenticacao_cadastro.php?logout=1");

exit;