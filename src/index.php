<?php
defined("_JEXEC") or die("Restricted access");

/** @var JDocumentHtml $this */
$app = JFactory::getApplication();
$doc = JFactory::getDocument();

/** Output as HTML5 */
$this->setHtml5(true);

$menu = $app->getMenu();
$params = $app->getTemplate(true)->params;
$config = JFactory::getConfig();
$pageclass = "";
if ($menu->getActive() != null) {
	$pageclass = $menu
		->getActive()
		->getParams(true)
		->get("pageclass_sfx");
}

// Logo file or site title param
$sitename = htmlspecialchars($app->get("sitename"), ENT_QUOTES, "UTF-8");

// Module counters
$countContactModules = $this->countModules("contact");

/*
 *	Mobile device detection
 */
if (!function_exists("mobile_user_agent_switch")) {
	function mobile_user_agent_switch()
	{
		$device = "";

		if (stristr($_SERVER["HTTP_USER_AGENT"], "ipad")) {
			$device = "ipad";
		} elseif (stristr($_SERVER["HTTP_USER_AGENT"], "iphone") || strstr($_SERVER["HTTP_USER_AGENT"], "iphone")) {
			$device = "iphone";
		} elseif (stristr($_SERVER["HTTP_USER_AGENT"], "blackberry")) {
			$device = "blackberry";
		} elseif (stristr($_SERVER["HTTP_USER_AGENT"], "android")) {
			$device = "android";
		}

		if ($device) {
			return "mobile";
		}
		return false;
		return false;
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
   <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<jdoc:include type="head" />
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/gtm-webfonts.css" type="text/css" />
		<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/menu.js"></script>
		<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/article-images.js"></script>
		<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/model-images.js"></script>

		<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/vendor/swiped/swiped.css" type="text/css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-BPPHVQ2LP7"></script>
		<script>
	    	window.dataLayer = window.dataLayer || [];
	  	  	function gtag(){dataLayer.push(arguments);}
	  		gtag('js', new Date());
			gtag('config', 'G-BPPHVQ2LP7');
		</script>
		<!-- END Global site tag -->
	</head>
	<body class="<?php echo $pageclass
 	? htmlspecialchars($pageclass)
 	: "default"; ?> <?php echo mobile_user_agent_switch(); ?>">
	 	<div class="offcanvas">
			 <div class="menu-container">
			 	<jdoc:include type="modules" name="offcanvas" style="html5" />
			 </div>
		</div>
		<div class="container">
			<div class="top">
				<jdoc:include type="modules" name="top" style="html5" />
			</div>
			<div class="navigation">
				<div class="logo">
					<a href="/"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/logo.png" /></a>
				</div>
				<jdoc:include type="modules" name="navigation" style="html5" />
			</div>
			<div class="messages">
				<jdoc:include type="message" />
			</div>
			<div class="component">
				<div class="content-top"><jdoc:include type="modules" name="content-top" style="html5" /></div>
				<jdoc:include type="component" />
				<div class="related"><jdoc:include type="modules" name="related" style="html5" /></div>
			</div>
<?php if ($countContactModules): ?>
			<div class="contact">
				<jdoc:include type="modules" name="contact" style="html5" />
			</div>
			<?php endif; ?>
			<div class="footer">
				<jdoc:include type="modules" name="footer" style="html5" />
			</div>
		</div>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/hamburger.js"></script>
	</body>
</html>
