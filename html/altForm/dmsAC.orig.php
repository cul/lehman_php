<?
/**
 * Arquivo de Exemplo da classe AJAX/PHP AutoComplete
 * Example file for AJAX Powered PHP auto-complete
 *
 * @author Rafael Dohms <rafael at rafaeldohms dot com dot br>
 * @package dmsAutoComplete
 * @version 1.0
 */

/**
* Função de auxilio para exemplo, ela filtra o array
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

	//Criar elementos Raíz do XML
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
	$ostring = "O cuidado em identificar pontos críticos na revolução dos costumes nos obriga à análise dos conhecimentos estratégicos para atingir a excelência. Acima de tudo, é fundamental ressaltar que o acompanhamento das preferências de consumo cumpre um papel essencial na formulação dos procedimentos normalmente adotados. Podemos já vislumbrar o modo pelo qual a estrutura atual da organização agrega valor ao estabelecimento dos métodos utilizados na avaliação de resultados.
			  No entanto, não podemos esquecer que a competitividade nas transações comerciais possibilita uma melhor visão global das diretrizes de desenvolvimento para o futuro. Por conseguinte, a adoção de políticas descentralizadoras maximiza as possibilidades por conta das direções preferenciais no sentido do progresso. Nunca é demais lembrar o peso e o significado destes problemas, uma vez que o entendimento das metas propostas causa impacto indireto na reavaliação do retorno esperado a longo prazo. A prática cotidiana prova que a percepção das dificuldades assume importantes posições no estabelecimento do fluxo de informações. É claro que a execução dos pontos do programa obstaculiza a apreciação da importância do investimento em reciclagem técnica. 
			  Não obstante, a consulta aos diversos militantes oferece uma interessante oportunidade para verificação do remanejamento dos quadros funcionais. Neste sentido, a determinação clara de objetivos acarreta um processo de reformulação e modernização das condições inegavelmente apropriadas. A certificação de metodologias que nos auxiliam a lidar com o desenvolvimento contínuo de distintas formas de atuação pode nos levar a considerar a reestruturação dos relacionamentos verticais entre as hierarquias. 
			  Gostaria de enfatizar que o consenso sobre a necessidade de qualificação representa uma abertura para a melhoria do orçamento setorial. Pensando mais a longo prazo, o fenômeno da Internet estimula a padronização dos paradigmas corporativos. O que temos que ter sempre em mente é que o desafiador cenário globalizado talvez venha a ressaltar a relatividade do impacto na agilidade decisória. 
			  Assim mesmo, a expansão dos mercados mundiais aponta para a melhoria de todos os recursos funcionais envolvidos. O incentivo ao avanço tecnológico, assim como o julgamento imparcial das eventualidades faz parte de um processo de gerenciamento dos níveis de motivação departamental. Todavia, o novo modelo estrutural aqui preconizado desafia a capacidade de equalização da gestão inovadora da qual fazemos parte. É importante questionar o quanto a valorização de fatores subjetivos garante a contribuição de um grupo importante na determinação dos índices pretendidos. O empenho em analisar a contínua expansão de nossa atividade auxilia a preparação e a composição das formas de ação. ";
              

	$available = array_unique(explode(" ",$ostring));

	$results = array_filter($available,'arrfilter');



	//Construir elementos ITEM
	//built ITEM elements
	foreach($results as $key=>$label){

		if (class_exists('DOMDocument')){
			//Cadastrar na lista
			//Add to list
			$item = $xmlDoc->createElement('item');
			$item = $root->appendChild($item);
			$item->setAttribute('id',$key);
			$item->setAttribute('label',rawurlencode($label));
			//rawurlencode evita problemas de charset
			//rawurlencode avoids charset problems
		}else{
			$xmlDoc .= '<item id="'.$key.'" label="'.rawurlencode($label).'"></item>';
		}
	}
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
