var isNav = (navigator.appName.indexOf("Netscape") !=-1);
var isMinNS6 = ((navigator.userAgent.indexOf("Gecko") != -1) && (isNav));
var isIE = (navigator.appName.indexOf("Microsoft") !=-1);
var Xpos, Ypos;
var js_cod_item=cod_item;
var js_cod_topico;
var js_nome_topico;
var js_tipo_item;
var js_total_exc=0;
var js_conta_arq=0;
var mostrando=0;
var editando=0;
var js_comp = new Array();
var editaTitulo=0;
var editaTexto=0;
var conteudo="";
var input=0;
var cancelarElemento=null;
var cancelarTodos=0;
var lista_frases_geral;
var cod_avaliacao="";
var valor_radios = new Array();

var lista_frases = new Array();
	
	lista_frases = $.post('../../../app/agenda/models/retornaFraseDinamic.php',
		function(data){
			var retorno = $.parseJSON(data);
			alert(retorno);
			return retorno;
		});


if (isNav)
{
  document.captureEvents(Event.MOUSEMOVE);
}
document.onmousemove = TrataMouse;

function TrataMouse(e)
{
  Ypos = (isMinNS4) ? e.pageY : event.clientY;
  Xpos = (isMinNS4) ? e.pageX : event.clientX;
}

function getPageScrollY()
{
  if (isNav)
    return(window.pageYOffset);
  if (isIE)
    return(document.body.scrollTop);
}

function AjustePosMenuIE()
{
  if (isIE)
    return(getPageScrollY());
  else
    return(0);
}

function EscondeLayers()
{
  hideLayer(cod_comp);
  hideLayer(cod_mover);
  hideLayer(cod_novapasta);
  hideLayer(cod_mover_arquivo);
}

function MostraLayer(cod_layer, ajuste)
{
  CancelaTodos();
  EscondeLayers();
  moveLayerTo(cod_layer,Xpos-ajuste,Ypos+AjustePosMenuIE());
  mostrando=1;
  showLayer(cod_layer);
}

function EscondeLayer(cod_layer)
{
  hideLayer(cod_layer);
  mostrando=0;
}

function AtualizaComp(js_tipo_comp)
{
  if ((isNav) && (!isMinNS6)) {
    document.comp.document.form_comp.tipo_comp.value=js_tipo_comp;
    document.comp.document.form_comp.cod_item.value=js_cod_item;
    var tipo_comp = new Array(document.comp.document.getElementById('tipo_comp_T'), document.comp.document.getElementById('tipo_comp_F'), document.comp.document.getElementById('tipo_comp_P'));
  } else {
  if (isIE || ((isNav)&&(isMinNS6)) ){
      document.form_comp.tipo_comp.value=js_tipo_comp;
      document.form_comp.cod_item.value=js_cod_item;
      var tipo_comp = new Array(document.getElementById('tipo_comp_T'), document.getElementById('tipo_comp_F'), document.getElementById('tipo_comp_P'));
      }
  }
  var imagem="<img src='../imgs/portfolio/checkmark_blue.gif'>"
  if (js_tipo_comp=='T') {
    tipo_comp[0].innerHTML=imagem;
    tipo_comp[1].innerHTML="&nbsp;";
    tipo_comp[2].innerHTML="&nbsp;";
  } else if (js_tipo_comp=='F') {
    tipo_comp[0].innerHTML="&nbsp;";
    tipo_comp[1].innerHTML=imagem;
    tipo_comp[2].innerHTML="&nbsp;";
  } else{
    tipo_comp[0].innerHTML="&nbsp;";
    tipo_comp[1].innerHTML="&nbsp;";
    tipo_comp[2].innerHTML=imagem;
  }

  xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, cod_usuario_portfolio, cod_grupo_portfolio, cod_topico_ant);
}

function EdicaoTitulo(codigo, id, valor){
	//se o t�tulo n�o � vazio
  if ((valor=='ok')&&(document.getElementById(id+'_text').value != "")){
    novoconteudo = document.getElementById(id+'_text').value;
    //Edita o t�tulo do item dado, din�micamente
    xajax_EditarTitulo(cod_curso, codigo, novoconteudo, cod_usuario, lista_frases.msg103);
    
    //else - se o t�tulo for vazio.
  }else{
    /* 15 - O titulo nao pode ser vazio. */
    if ((valor=='ok')&&(document.getElementById(id+'_text').value == ""))	
      //alert(lista_frases.msg15);
    	alert('O titulo nao pode ser vazio'); //TODO: texto hardcoded
	
    document.getElementById(id).innerHTML=conteudo;
    
    if(navigator.appName.match("Opera")){
      document.getElementById('renomear_'+codigo).onclick = AlteraTitulo(codigo);
    }else{
      document.getElementById('renomear_'+codigo).onclick = function(){ AlteraTitulo(codigo); };
    }

    //Cancela Edi��o
    if (!cancelarTodos)
      xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 0);
  }
  editaTitulo=0;
  cancelarElemento=null;
}

function MoverItem(link,cod_destino)
{ 
  xajax_MoverItensDinamic(cod_curso, cod_usuario, cod_topico_ant, cod_destino, null, cod_item);
  xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 1);

  if (js_tipo_item=='item')
  {
    link.search='?+&cod_curso='+cod_curso+'&cod_item='+cod_item+'&cod_topico_raiz='+cod_destino+'&cod_topico_ant='+cod_topico_ant+'&acao=moveritem&cod_usuario_portfolio='+cod_usuario_portfolio+'&cod_grupo_portfolio='+cod_grupo_portfolio;
    return true;
  }
  else if (js_tipo_item=='topico')
  {
    link.search='?+&cod_curso='+cod_curso+'&cod_topico='+cod_topico+'&cod_topico_raiz='+cod_destino+'&cod_topico_ant='+cod_topico_ant+'&acao=movertopico&cod_usuario_portfolio='+cod_usuario_portfolio+'&cod_grupo_portfolio='+cod_grupo_portfolio;
    return true;
  }
  else
  {

    return false;

  }
}


function WindowOpenVerURL(end)
{
  window.open(end,'PortfolioURL','top=50,left=100,width=600,height=400,menubar=yes,status=yes,toolbar=yes,scrollbars=yes,resizable=yes');
}

//$(document).ready(function(){
	function EdicaoTexto(codigo, id, valor){
	
	  if (valor=='ok'){
	      eval('conteudo = CKEDITOR.instances.'+id+'_text'+'.getData();');
	      $.post('../../../app/agenda/models/editartexto.php',{cod_curso: cod_curso, cod_item: cod_item, cod_usuario:cod_usuario, novo_texto:conteudo}, 
	    		    function(data){
	    		    	var code = $.parseJSON(data);
	    		    	$('#tr_'+cod_item).toggleClass('novoitem');
	    		    	$('#text_'+cod_item).html(code);
	    		    	mostraFeedback('Texto alterado com sucesso', 'true'); //TODO: texto harcorded
	      });
	      //xajax_EditarTexto(cod_curso, codigo, conteudo, cod_usuario, lista_frases.msg22);
	    }
	  else{
	      //Cancela Edicao
	      if (!cancelarTodos)
	        xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 0);
	  }
	  document.getElementById(id).innerHTML=conteudo;
	  editaTexto=0;
	  cancelarElemento=null;
	}
	
	var controle=0;
	
	
	function AlteraTexto(id){
	  var iframe = document.getElementById('iframe_ArqEntrada');	
	  var span = document.getElementById('text_'+id);	
	
	  checks = document.getElementsByName('chkArq');
	
	  if ((editaTexto==0)&&(checks.length==0)){
	    CancelaTodos();
	
	    $.post('../../../app/agenda/models/abreedicao.php',{cod_curso: cod_curso, cod_item: cod_item, cod_usuario:cod_usuario, origem:origem}, 
	    function(data){
	    	var code = $.parseJSON(data);
	    //echo("					alert(code);\n");
	    });
	    //xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, origem);
	    if(iframe == null)	
	    	conteudo = span.innerHTML;
	    else
	    { 	
		span.removeChild(iframe);
		conteudo="";		
	    }				
	    writeRichTextOnJSButtons('text_'+id+'_text', conteudo, 520, 200, true, false, id);
	    startList();
	    //document.getElementById('text_'+id+'_text').focus();
	    CKEDITOR.on("instanceReady", function(event)
	    		{
	    			eval('CKEDITOR.instances.text_'+id+'_text'+'.focus();');
	    		});
	    cancelarElemento=document.getElementById('CancelaEdita');
	    editaTexto++;
	  }
	  else{
	    if(checks.length > 0)
	    {	
		// 53 - A agenda nao pode ter texto e arquivos simultaneamente! 	
	    	//alert(lista_frases.msg53);
	    	alert('A agenda nao pode ter texto e arquivos simultaneamente'); //TODO: texto hardcoded
	    }	
	  }
	}
	
	function LimpaTexto(id){
	
	  checks = document.getElementsByName('chkArq');
	
	  if ((editaTexto==0)&&(checks.length==0)){
	    // 95 - Voc� tem certeza que deseja apagar o texto desta agenda?
	    //if (confirm(lista_frases.msg95)){
		  if (confirm('Deseja realmente apagar o texto desta agenda?')){ //TODO: texto hardcoded
	      CancelaTodos();
	      document.getElementById('text_'+id).innerHTML='';
	
	      $.post('../../../app/agenda/models/editartexto.php',{cod_curso: cod_curso, cod_item: cod_item, cod_usuario:cod_usuario, novo_texto: ' '}, 
	    		    function(data){
	    		    	var code = $.parseJSON(data);
	    		    	$('#tr_'+cod_item).toggleClass('novoitem');
	    		    	$('#text_'+cod_item).html(code);
	    		    	mostraFeedback('Texto apagado com sucesso', 'true'); //TODO: texto harcorded
	      });
	    }
	  }
	  else{
	    if(checks.length > 0)
	    {	
		// 53 - A agenda nao pode ter texto e arquivos simultaneamente!
	    	//alert(lista_frases.msg53);
	    	alert('A agenda nao pode ter texto e arquivos simultaneamente'); //TODO: texto hardcoded
	    }	
	  }
	}
//});

function ArquivoValido(path)
{
	var file = getfilename(path);
	var vet  = file.match(/^[A-Za-z0-9-\.\_\ ]+/);

	// Usando express�o regular para identificar caracteres inv�lidos
	if ((file.length == 0) || (vet == null) || (file.length != vet[0].length))
		return false;
	return true;
}

function getfilename(path)
{
  pieces=path.split('\\');
  n=pieces.length;
  file=pieces[n-1];
  pieces=file.split('/');
  n=pieces.length;
  file=pieces[n-1];
  return(file);
}

function EdicaoArq(i){
  if ((i==1)&&(ArquivoValido(document.getElementById('input_files').value))){ //OK
    document.formFiles.submit();
  }
  else {
	//alert(lista_frases.msg109);
	alert('Nome do anexo com acentos ou caracteres inv�lidos! Renomeie o arquivo e tente novamente.') //TODO: texto hardcoded
    document.getElementById('input_files').style.visibility='hidden';
    document.getElementById('input_files').value='';
    document.getElementById('divArquivo').className='';
    document.getElementById('divArquivoEdit').className='divHidden';
    //Cancela Edi��o
    if (!cancelarTodos)
      xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 0);
    input=0;
    cancelarElemento=null;
  }
}

function AcrescentarBarraFile(apaga){
    
    if (input==1) return;
    CancelaTodos();
    	
    conteudo = document.getElementById('text_'+cod_item).innerHTML;
    if((conteudo != '')&&(document.getElementById('iframe_ArqEntrada') == null)) {
	// 53 - A agenda nao pode ter texto e arquivos simultaneamente! 	
	//alert(lista_frases.msg53);
	alert('A agenda nao pode ter texto e arquivos simultaneamente'); //TODO: texto hardcoded
	return false;
    }
						
    document.getElementById('input_files').style.visibility='visible';
    document.getElementById('divArquivoEdit').className='';
    document.getElementById('divArquivo').className='divHidden';
    
    $.post('../../../app/agenda/models/abreedicao.php',{cod_curso: cod_curso, cod_item: cod_item, cod_usuario:cod_usuario, origem:origem}, 
    	    function(data){
    	    	var code = $.parseJSON(data);
    	    //echo("					alert(code);\n");
    	    });
    //xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, origem);

    cancelarElemento=document.getElementById('cancFile');
}

  function AdicionaInputEndereco(){
    CancelaTodos();
    document.getElementById('novoEnd').style.visibility='visible';
    document.getElementById('novoNomeEnd').style.visibility='visible';
    document.getElementById('divEndereco').className='divHidden';
    document.getElementById('divEnderecoEdit').className='';
    xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, cod_usuario_portfolio, cod_grupo_portfolio, cod_topico_ant);
    cancelarElemento=document.getElementById('cancelaEnd');
  }

function EditaEndereco(opt){
    if (opt){
      if (document.getElementById('novoEnd').value==''){
        xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 0);
        alert(lista_frases.msg64);
        return false;
      }
      xajax_InsereEnderecoDinamic(document.getElementById('novoNomeEnd').value, document.getElementById('novoEnd').value, cod_item, cod_curso, cod_usuario);
    }else{
      if (!cancelarTodos)
        xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 0);
    }

    document.getElementById('novoEnd').style.visibility='hidden';
    document.getElementById('novoNomeEnd').style.visibility='hidden';
    document.getElementById('novoEnd').value='';
    document.getElementById('novoNomeEnd').value='';
    document.getElementById('divEnderecoEdit').className='divHidden';
    document.getElementById('divEndereco').className='';

    cancelarElemento=null;
  }

function CancelaTodos(){
    //EscondeLayers();
    cancelarTodos=1;
     if(cancelarElemento) { cancelarElemento.onclick(); }
    cancelarTodos=0;
  }

function ApagarEndereco(cod_curso, cod_endereco){
  CancelaTodos();
  if (confirm(lista_frases.msg32)){
    xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, cod_usuario_portfolio, cod_grupo_portfolio, cod_topico_ant);
    xajax_ExcluirEndereco(cod_curso, cod_endereco, cod_item, cod_usuario);
  }
}

function Descompactar(){
  checks = document.getElementsByName('chkArq');
  for (i=0; i<checks.length; i++){
    if(checks[i].checked){
      getNumber=checks[i].id.split("_");
      arqZip=document.getElementById('nomeArq_'+getNumber[1]).getAttribute('arqZip');
      //if (confirm(lista_frases.msg12+'\n'+lista_frases.msg13+'\n'+lista_frases.msg14)){
      if (confirm('Voc� tem certeza de que deseja descompactar este arquivo? \n (o arquivo ZIP ser� apagado). \n importante: n�o � poss�vel a descompacta��o de arquivos contendo pastas com espa�os no nome. ')){ //TODO: texto hardcoded
    	  $.post('../../../app/agenda/models/abreedicao.php',{cod_curso: cod_curso, cod_item: cod_item, cod_usuario:cod_usuario, origem:origem}, 
    	    	    function(data){
    	  });
        //xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, origem);
        window.location='../../../app/agenda/controllers/acoes_linha.php?cod_curso='+cod_curso+'&cod_item='+cod_item+'&acao=descompactar&origem='+origem+'&arq='+arqZip;
      }
    } 
  }

}

function VerificaChkBox(alpha){
  CancelaTodos();
  checks = document.getElementsByName('chkArq');
  var i, j=0;
  var arqComum=0;
  var arqZip=0;
  var arqEntradaCheck=0;
  var arqEntrada=0;
  var pasta=0;

  for (i=0; i<checks.length; i++){
    
    getNumber=checks[i].id.split("_");

    if (document.getElementById("nomeArq_"+getNumber[1]).getAttribute('arqEntrada')=='sim'){
         arqEntrada=1;
    }

    if(checks[i].checked){
      j++;
      tipo = document.getElementById("nomeArq_"+getNumber[1]).getAttribute('tipoArq');
      switch (tipo){
        case ('pasta'): pasta=1;break;
        case ('comum'): arqComum++;break;
        case ('zip'): arqZip++;break;
      }
      
      if (document.getElementById("nomeArq_"+getNumber[1]).getAttribute('arqEntrada')=='sim'){
         arqEntradaCheck=1;
      }
    }

  }

  if (pasta==1){
    document.getElementById('mArq_apagar').className="menuUp02";
    document.getElementById('mArq_descomp').className="menuUp";
    document.getElementById('mArq_entrada').className="menuUp";
    	
    document.getElementById('mArq_apagar').onclick= function(){ Apagar(); };
    document.getElementById('mArq_descomp').onclick= function(){  };
    document.getElementById('mArq_entrada').onclick= function(){  };

  }else if((arqComum==1)&&(arqZip==0)&&(arqEntradaCheck==0)){
    document.getElementById('mArq_apagar').className="menuUp02"
    document.getElementById('mArq_descomp').className="menuUp";
    document.getElementById('mArq_entrada').className="menuUp02";

    document.getElementById('sArq_apagar').onclick= function(){ Apagar(); };
    document.getElementById('sArq_descomp').onclick= function(){  };
    document.getElementById('sArq_entrada').onclick= function(){ SelecionarEntrada(); };
    
  }else if((arqComum==1)&&(arqZip==0)&&(arqEntradaCheck==1)){
    document.getElementById('mArq_apagar').className="menuUp02"
    document.getElementById('mArq_descomp').className="menuUp";
    document.getElementById('mArq_entrada').className="menuUp02";

    document.getElementById('sArq_apagar').onclick= function(){ Apagar(); };
    document.getElementById('sArq_descomp').onclick= function(){  };
    document.getElementById('sArq_entrada').onclick= function(){ RetirarEntrada(); };
    
  }else if((arqComum==1)||(arqZip>1)){
    document.getElementById('mArq_apagar').className="menuUp02"
    document.getElementById('mArq_descomp').className="menuUp";
    document.getElementById('mArq_entrada').className="menuUp";

    document.getElementById('sArq_apagar').onclick= function(){ Apagar(); };
    document.getElementById('sArq_descomp').onclick= function(){  };
    document.getElementById('sArq_entrada').onclick= function(){  };
    
  }else if(arqComum>1){
    document.getElementById('mArq_apagar').className="menuUp02"
    document.getElementById('mArq_descomp').className="menuUp";
    document.getElementById('mArq_entrada').className="menuUp";

    document.getElementById('sArq_apagar').onclick= function(){ Apagar(); };
    document.getElementById('sArq_descomp').onclick= function(){  };
    document.getElementById('sArq_entrada').onclick= function(){  };
    
  }else if(arqZip==1){
    document.getElementById('mArq_apagar').className="menuUp02"
    document.getElementById('mArq_descomp').className="menuUp02"
    document.getElementById('mArq_entrada').className="menuUp";

    document.getElementById('sArq_apagar').onclick= function(){ Apagar(); };
    document.getElementById('sArq_descomp').onclick= function(){ Descompactar() };
    document.getElementById('sArq_entrada').onclick= function(){  };
    
  }else{
    document.getElementById('mArq_apagar').className="menuUp";
    document.getElementById('mArq_descomp').className="menuUp";
    document.getElementById('mArq_entrada').className="menuUp";

    document.getElementById('sArq_apagar').onclick= function(){  };
    document.getElementById('sArq_descomp').onclick= function(){  };
    document.getElementById('sArq_entrada').onclick= function(){  };
  }

  //Nao foi chamado pela funcao CheckTodos
  if (alpha){
    if (j==checks.length){ document.getElementById('checkMenu').checked=true; }
    else document.getElementById('checkMenu').checked=false;
  }

}

function Apagar(){
  checks = document.getElementsByName('chkArq');
  if (confirm('Deseja realmente apagar o(s) arquivo(s) e/ou a(s) pasta(s) selecionado(s)?')){
    for (i=0; i<checks.length; i++){
      if(checks[i].checked){
        getNumber=checks[i].id.split("_");
        nomeArq = document.getElementById("nomeArq_"+getNumber[1]).getAttribute('nomeArq');
        
        $.post('../../../app/agenda/models/excluir_arquivo.php',{numero: getNumber[1], arq: nomeArq, cod_curso: cod_curso, cod_item: cod_item, cod_usuario:cod_usuario, origem: origem}, 
    		    function(data){
    		    	$('#arq_'+getNumber[1]).remove();
        });
      //xajax_ExcluirArquivo(getNumber[1], nomeArq, cod_curso, cod_item, cod_usuario, origem);
	js_conta_arq--;
      }
    }
    mostraFeedback('Arquivo apagado com sucesso', 'true'); //TODO: frase hardcoded
  }

  if(document.getElementById("nomeArq_"+getNumber[1]).getAttribute('arqEntrada') == 'sim')
  {
    document.getElementById('text_'+cod_item).innerHTML='';
  }

  LimpaBarraArq();
}

function SelecionarEntrada(){
  checks = document.getElementsByName('chkArq');
  var nomesArqs = new Array();

  for (i=0; i<checks.length; i++)
  {
    nomesArqs[i] = new Array();
	
    getNumber=checks[i].id.split("_");	
    nomeArq = document.getElementById("nomeArq_"+getNumber[1]).getAttribute('nomeArq');
    nomesArqs[i][0]=nomeArq;
    
    if(checks[i].checked)
      nomesArqs[i][1]=1; 
    else
      nomesArqs[i][1]=0;
  }

  CheckTodos();
  xajax_SelecionarEntradaDinamic(nomesArqs, cod_curso, cod_item, cod_usuario, origem);	
}

function RetirarEntrada(){
  checks = document.getElementsByName('chkArq');
  j=0;
  var nomeArq;

  for (i=0; i<checks.length; i++){
    if(checks[i].checked){
      getNumber=checks[i].id.split("_");
      if ((document.getElementById("nomeArq_"+getNumber[1]).getAttribute('arqEntrada'))=='sim'){
        nomeArq = document.getElementById("nomeArq_"+getNumber[1]).getAttribute('nomeArq');
      }
// 
      break;
    }
  }

  CheckTodos();
  xajax_RetirarEntradaDinamic(nomeArq, cod_curso, cod_item, cod_usuario, origem);
}

function CheckTodos(){
  var e;
  var i;
  var CabMarcado = document.getElementById('checkMenu').checked;
  var checks=document.getElementsByName('chkArq');
  for(i = 0; i < checks.length; i++)
  {
    e = checks[i];
    e.checked = CabMarcado;
  }

  VerificaChkBox(0);
}

function Mover(caminhoDestino){

  checks = document.getElementsByName('chkArq');
  for (i=0; i<checks.length; i++){
    if(checks[i].checked){
      numeroArq= checks[i].getAttribute('id');
      numeroArq = numeroArq.split('_');
      IdArquivo = 'nomeArq_'+numeroArq[1];
      caminhoOrigem = document.getElementById(IdArquivo).getAttribute('nomeArq');
      xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, cod_usuario_portfolio, cod_grupo_portfolio, cod_topico_ant);
      xajax_MoverArquivosDinamic(caminhoOrigem, caminhoDestino, cod_curso, cod_item, cod_usuario, lista_frases_geral.msg_ger63);
    }
  }

}

function ApagarItem(){
  CancelaTodos();

  //if (confirm(lista_frases.msg29+'\n'+lista_frases.msg30)){
  if (confirm('Voc� tem certeza de que deseja apagar esta agenda? \n (n�o haver� como recuper�-la!)')){ //TODO: texto hardcoded
        window.location='../../../app/agenda/controllers/acoes_linha.php?cod_curso='+cod_curso+'&cod_item='+cod_item+'&acao=apagarItem&origem='+origem;
  }
}

function LimpaBarraArq(){

  lista = document.getElementById('listFiles');
  if (!js_conta_arq){
    pai_lista=lista.parentNode;
    pai_lista2=pai_lista.parentNode;
    i=3;
    do{
      pai_lista.removeChild(pai_lista.firstChild);
      i--;
    }while(i>0);

  }

  document.getElementById('checkMenu').checked=false;
  CheckTodos();
}

function AssociarAvaliacao(){
  CancelaTodos();
  radios=document.getElementsByName('cod_avaliacao');
  for (i=0; i<radios.length; i++){
    valor_radios[i]=radios[i].checked;
  }
  document.getElementById('tableAvaliacao').style.visibility='visible';
  document.getElementById('divAvaliacao').className='divHidden';
  document.getElementById('divAvaliacaoEdit').className='';

  xajax_AbreEdicao(cod_curso, cod_item, cod_usuario, cod_usuario_portfolio, cod_grupo_portfolio, cod_topico_ant);

  cancelarElemento=document.getElementById('cancAval');

}

function EditaAval(opt){
  document.getElementById('tableAvaliacao').style.visibility='hidden';
  document.getElementById('divAvaliacao').className='';
  document.getElementById('divAvaliacaoEdit').className='divHidden';
  if (opt){
    xajax_AssociaAvaliacaoDinamic(cod_curso, cod_usuario, cod_item, cod_avaliacao, lista_frases_geral.msg_ger35, lista_frases.msg149);
  }else{
    radios = document.getElementsByName('cod_avaliacao');
    for (i=0; i<radios.length; i++){
      radios[i].checked=valor_radios[i].checked;
    }
    if(!cancelarTodos)
      xajax_AcabaEdicaoDinamic(cod_curso, cod_item, cod_usuario, 0);
  }

  cancelarElemento=null;
}

function DesmarcaRadios(){
  radios = document.getElementsByName('cod_avaliacao');
  for (i=0; i<radios.length; i++){
    radios[i].checked=false;
  }
  cod_avaliacao='';
}