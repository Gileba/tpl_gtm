<?php
	defined('_JEXEC') or die('Restricted access');

	/** @var JDocumentHtml $this */
	$app      	= JFactory::getApplication();
	$doc      	= JFactory::getDocument();

	/** Output as HTML5 */
	$this->setHtml5(true);

	$menu 		= $app->getMenu();
	$params		= $app->getTemplate(true)->params;
	$config 	= JFactory::getConfig();
	$pageclass 	= $menu->getActive()->getParams(true)->get('pageclass_sfx');

	// Logo file or site title param
	$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

/*
*	Mobile device detection
*/
if(!function_exists('mobile_user_agent_switch')){
	function mobile_user_agent_switch()
	{
		$device = '';

		if(stristr($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
			$device = "ipad";
		} elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'iphone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iphone')) {
			$device = "iphone";
		} elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'blackberry')) {
			$device = "blackberry";
		} elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'android')) {
			$device = "android";
		}

		if($device) {
			return "mobile";
		} return false; {
			return false;
		}
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
   <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<jdoc:include type="head" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
	</head>
	<body class="<?php echo $pageclass ? htmlspecialchars($pageclass) : 'default'; ?> <?php echo mobile_user_agent_switch(); ?>">
		<div class="container">
			<div class="top">
				<jdoc:include type="modules" name="top" />
			</div>
			<div class="navigation">
				<jdoc:include type="modules" name="navigation" />
			</div>
			<div class="contact">
				<jdoc:include type="modules" name="contact" />
			</div>
			<div class="footer">
				<jdoc:include type="modules" name="footer" />
			</div>
		</div>
	</body>
</html>
