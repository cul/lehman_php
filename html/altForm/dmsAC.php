<?

// This file builds the XML results that are used on the fly by the Ajax functions in js

/**
 * Arquivo de Exemplo da classe AJAX/PHP AutoComplete
 * Example file for AJAX Powered PHP auto-complete
 *
 * @author Rafael Dohms <rafael at rafaeldohms dot com dot br>
 * @package dmsAutoComplete
 * @version 1.0
 */

/**
* Fun??o de auxilio para exemplo, ela filtra o array
* retornando apenas as entradas que se iniciam com
* a string recebida
* 
* Filter function used in example, it filters an array
* returning only entries starting with the given string
*
* @param item
*/

function arrfilter(&$item){
	return preg_match('/^'.utf8_decode($_POST['string']).'/',$item);
}

if (class_exists('DOMDocument')){ //Adapta o script para PHP4

	//Criar documento XML atraves de DOM
	//Create XML Doc through DOM
	$xmlDoc = new DOMDocument('1.0', 'utf-8');
	$xmlDoc->formatOutput = true;

	//Criar elementos Ra?z do XML
	//Create root XML element
	$root = $xmlDoc->createElement('root');
	$root = $xmlDoc->appendChild($root);

}else{
	$xmlDoc  = '<?xml version="1.0" encoding="utf-8"?>';
	$xmlDoc .= '<root>';
}

/**
 * :pt-br:
 * Definir Lista (itens) a ser mostrada.
 * 
 * Neste passo podemos realizar buscas em banco de dados, filtrar arrays
 * Ou qualquer outra tarefa que retorne um resultado baseado no string
 * recebido
 * 
 * :en:
 * Define list to be returned
 * 
 * In this step we could do a database search, filter arryas or perform
 * other actions which would return a resultig list based on an input
 * string
 */
if ($_POST['string'] != ''){
	//Fazer filtro ou busca
	//Filter ou search
	//SQL, Array, etc...
	/*$ostring = "O cuidado em identificar pontos cr?ticos na revolu??o dos costumes nos obriga ? an?lise dos conhecimentos estrat?gicos para atingir a excel?ncia. Acima de tudo, ? fundamental ressaltar que o acompanhamento das prefer?ncias de consumo cumpre um papel essencial na formula??o dos procedimentos normalmente adotados. Podemos j? vislumbrar o modo pelo qual a estrutura atual da organiza??o agrega valor ao estabelecimento dos m?todos utilizados na avalia??o de resultados.
			  No entanto, n?o podemos esquecer que a competitividade nas transa??es comerciais possibilita uma melhor vis?o global das diretrizes de desenvolvimento para o futuro. Por conseguinte, a ado??o de pol?ticas descentralizadoras maximiza as possibilidades por conta das dire??es preferenciais no sentido do progresso. Nunca ? demais lembrar o peso e o significado destes problemas, uma vez que o entendimento das metas propostas causa impacto indireto na reavalia??o do retorno esperado a longo prazo. A pr?tica cotidiana prova que a percep??o das dificuldades assume importantes posi??es no estabelecimento do fluxo de informa??es. ? claro que a execu??o dos pontos do programa obstaculiza a aprecia??o da import?ncia do investimento em reciclagem t?cnica. 
			  N?o obstante, a consulta aos diversos militantes oferece uma interessante oportunidade para verifica??o do remanejamento dos quadros funcionais. Neste sentido, a determina??o clara de objetivos acarreta um processo de reformula??o e moderniza??o das condi??es inegavelmente apropriadas. A certifica??o de metodologias que nos auxiliam a lidar com o desenvolvimento cont?nuo de distintas formas de atua??o pode nos levar a considerar a reestrutura??o dos relacionamentos verticais entre as hierarquias. 
			  Gostaria de enfatizar que o consenso sobre a necessidade de qualifica??o representa uma abertura para a melhoria do or?amento setorial. Pensando mais a longo prazo, o fen?meno da Internet estimula a padroniza??o dos paradigmas corporativos. O que temos que ter sempre em mente ? que o desafiador cen?rio globalizado talvez venha a ressaltar a relatividade do impacto na agilidade decis?ria. 
			  Assim mesmo, a expans?o dos mercados mundiais aponta para a melhoria de todos os recursos funcionais envolvidos. O incentivo ao avan?o tecnol?gico, assim como o julgamento imparcial das eventualidades faz parte de um processo de gerenciamento dos n?veis de motiva??o departamental. Todavia, o novo modelo estrutural aqui preconizado desafia a capacidade de equaliza??o da gest?o inovadora da qual fazemos parte. ? importante questionar o quanto a valoriza??o de fatores subjetivos garante a contribui??o de um grupo importante na determina??o dos ?ndices pretendidos. O empenho em analisar a cont?nua expans?o de nossa atividade auxilia a prepara??o e a composi??o das formas de a??o. ";
      */        

    // added by jd 2008-03-04
	$searchUrl = "http://appdev.cul.columbia.edu:8080/lehman/select?wt=phps&q=file_unittitle_t:" . $_POST['string'] . "*;file_unittitle_t asc";
	$serializedResult = file_get_contents($searchUrl);
	$result = unserialize($serializedResult);
        extract($result);
        extract($responseHeader);
        extract($response);

	if ($result)
		print "<script>alert($response)</script>";

	//Construir elementos ITEM
	//built ITEM elements
	foreach($docs as $res) {
     //foreach($results as $key=>$label) {
       //foreach ($res as $key=>$label){
         extract($res);
         $key = "$file_unittitle";
         $label = "$file_unittitle";

		if (class_exists('DOMDocument')) {
			//Cadastrar na lista
			//Add to list
			$item = $xmlDoc->createElement('item');
			$item = $root->appendChild($item);
			//$item->setAttribute('id',$key);
            		$item->setAttribute('id',$file_unittitle_t);
			$item->setAttribute('label',rawurlencode($label));
			//rawurlencode evita problemas de charset
			//rawurlencode avoids charset problems
		} else{
			//$xmlDoc .= '<item id="'.$key.'" label="'.rawurlencode($label).'"></item>';
            		$xmlDoc .= '<item id="'.$key.'" label="'.rawurlencode($label).'"></item>';
		}
	  //} // end FOREACH res
    } // end FOREACH results
}

//Retornar XML de resultado para AJAX
//Return XML code for AJAX Request
header("Content-type:application/xml; charset=utf-8");
if (class_exists('DOMDocument')){
	echo $xmlDoc->saveXML();
}else{
	$xmlDoc .= '</root>';
	echo $xmlDoc;
}

?>
