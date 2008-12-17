<?

/*
Plugin Name: Juick widget
Plugin URI: http://www.reactant.ru/
Description: Вывод записей из микроблога на Juick.com. Шаблон вывода можно настроить в файле juick.xsl
Version: 0.1
Author: ATimofeev [Re.Актив]
Author URI: http://www.reactant.ru/
*/

function widget_juick_register() 
{	
	if (function_exists('register_sidebar_widget'))
	{			
		/* - Описываем виджет - */  
			function widget_juick() 
			{
				$options = get_option('widget_juick');
				$name = $options['name'] ? $options['name'] : 'sidebar';
				$count = $options['count'] ? $options['count'] : 'sidebar';
				$target = $options['target'] ? $options['target'] : 'sidebar';
				
				//$count = "3";
				//$target = "self";

				$xslDoc = new DOMDocument();
				$xslDoc->load($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/juick/juick.xsl");

				$xmlDoc = new DOMDocument();
				$xmlDoc->load("http://rss.juick.com/".$name."/blog");

				$proc = new XSLTProcessor();
				$proc->setParameter( '', 'count', $count);
				$proc->setParameter( '', 'target', $target);
				$proc->importStylesheet($xslDoc);
				echo $proc->transformToXML($xmlDoc);

			}
		/* - Описываем опции виджета - */
			function widget_juick_options() 
			{
			    $options = $newoptions = get_option('widget_juick');

			    if ( $_POST['widget_juick_submit'] )
			    {
        			$newoptions['name'] = stripslashes($_POST['widget_juick_name']);
					$newoptions['count'] = stripslashes($_POST['widget_juick_count']);
					$newoptions['target'] = stripslashes($_POST['widget_juick_target']);
        		}	
    			if ( $options != $newoptions ) 
    			{
        			$options = $newoptions;
        			update_option('widget_juick', $options);
    			}

    			$name = attribute_escape($options['name']);
				$count = attribute_escape($options['count']);
				$target = attribute_escape($options['target']);
				
				if (empty($name)) {$name = "4Eki";}
				if (empty($count)) {$count = "5";}
				if (empty($target)) {$target = "blank";}

    			echo <<<EOF
    				Имя пользователя Juick:
    				<input id="widget_juick_name"
						name="widget_juick_name"
						type="text"
						value="{$name}" /> 
						<br />
    				Количество записей:
    				<input id="widget_juick_count"
						name="widget_juick_count"
						type="text"
						value="{$count}" />
						<br />
    				Значение target:
    				<input id="widget_juick_target"
						name="widget_juick_target"
						type="text"
						value="{$target}" />

					<input type="hidden"
						id="widget_juick_submit"
						name="widget_juick_submit"
						value="1" />
EOF;
			}
	}
	
	/* - Регистрируем виджет и опции - */
		register_sidebar_widget('Juick widget', 'widget_juick');
		register_widget_control('Juick widget', 'widget_juick_options');
	
}

add_action('init', 'widget_juick_register');

?>