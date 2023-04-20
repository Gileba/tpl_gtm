<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined("_JEXEC") or die();

JHtml::addIncludePath(JPATH_COMPONENT . "/helpers");

// Create shortcuts to some parameters.
$params = $this->item->params;
$urls = json_decode($this->item->urls);
$canEdit = $params->get("access-edit");
$user = JFactory::getUser();
$info = $params->get("info_block_position", 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = JLanguageAssociations::isEnabled() && $params->get("show_associations");

$currentDate = JFactory::getDate()->format("Y-m-d H:i:s");
$isNotPublishedYet = $this->item->publish_up > $currentDate;
$isExpired =
	$this->item->publish_down < $currentDate && $this->item->publish_down !== JFactory::getDbo()->getNullDate();
?>
<div class="item-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
	<meta itemprop="inLanguage" content="<?php echo $this->item->language === "*"
 	? JFactory::getConfig()->get("language")
 	: $this->item->language; ?>" />
	<?php
 if ($this->params->get("show_page_heading")): ?>
	<div class="page-header" >
		<h3> <?php echo $this->escape($this->params->get("page_heading")); ?> </h3>
	</div>
	<?php endif;
 if (
 	!empty($this->item->pagination) &&
 	$this->item->pagination &&
 	!$this->item->paginationposition &&
 	$this->item->paginationrelative
 ) {
 	echo $this->item->pagination;
 }
 ?>

	<?php
// Todo Not that elegant would be nice to group the params
?>
	<?php $useDefList =
 	$params->get("show_modify_date") ||
 	$params->get("show_publish_date") ||
 	$params->get("show_create_date") ||
 	$params->get("show_hits") ||
 	$params->get("show_category") ||
 	$params->get("show_parent_category") ||
 	$params->get("show_author") ||
 	$assocParam; ?>

	<?php if (!$useDefList && $this->print): ?>
		<div id="pop-print" class="btn hidden-print">
			<?php echo JHtml::_("icon.print_screen", $this->item, $params); ?>
		</div>
		<div class="clearfix"> </div>
	<?php endif; ?>
	<?php if ($params->get("show_title")): ?>
	<?php $images = json_decode($this->item->images); ?>
	<div class="page-header" <?php if (
 	!empty($images->image_fulltext)
 ): ?>style="background-image: url('<?php echo htmlspecialchars($images->image_fulltext); ?>')"<?php endif; ?>>
		<h1 itemprop="headline">
			<?php echo $this->escape($this->item->title); ?>
		</h1>
	</div>
	<?php endif; ?>
	<?php if (!$this->print): ?>
		<?php if ($canEdit || $params->get("show_print_icon") || $params->get("show_email_icon")): ?>
			<?php echo JLayoutHelper::render("joomla.content.icons", [
   	"params" => $params,
   	"item" => $this->item,
   	"print" => false,
   ]); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php if ($useDefList): ?>
			<div id="pop-print" class="btn hidden-print">
				<?php echo JHtml::_("icon.print_screen", $this->item, $params); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php
// Content is generated by content plugin event "onContentAfterTitle"
?>
	<?php echo $this->item->event->afterDisplayTitle; ?>

	<?php if ($useDefList && ($info == 0 || $info == 2)): ?>
		<?php
 	// Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block
 	?>
		<?php echo JLayoutHelper::render("joomla.content.info_block.block", [
  	"item" => $this->item,
  	"params" => $params,
  	"position" => "above",
  ]); ?>
	<?php endif; ?>

	<?php if ($info == 0 && $params->get("show_tags", 1) && !empty($this->item->tags->itemTags)): ?>
		<?php $this->item->tagLayout = new JLayoutFile("joomla.content.tags"); ?>

		<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
	<?php endif; ?>

	<?php
// Content is generated by content plugin event "onContentBeforeDisplay"
?>
	<?php echo $this->item->event->beforeDisplayContent; ?>

	<?php if (
 	(isset($urls) &&
 		((!empty($urls->urls_position) && $urls->urls_position == "0") ||
 			($params->get("urls_position") == "0" && empty($urls->urls_position)))) ||
 	(empty($urls->urls_position) && !$params->get("urls_position"))
 ): ?>
	<?php echo $this->loadTemplate("links"); ?>
	<?php endif; ?>
	<?php if ($params->get("access-view")): ?>
	<?php if (
 	!empty($this->item->pagination) &&
 	$this->item->pagination &&
 	!$this->item->paginationposition &&
 	!$this->item->paginationrelative
 ):
 	echo $this->item->pagination;
 endif; ?>
<div class="pos-breadcrumb">
	<?php echo JHtml::_('content.prepare', '{loadposition breadcrumb}'); ?>
</div>
		<?php if ($this->item->state == 0): ?>
			<span class="label label-warning"><?php echo JText::_("JUNPUBLISHED"); ?></span>
		<?php endif; ?>
		<?php if ($isNotPublishedYet): ?>
			<span class="label label-warning"><?php echo JText::_("JNOTPUBLISHEDYET"); ?></span>
		<?php endif; ?>
		<?php if ($isExpired): ?>
			<span class="label label-warning"><?php echo JText::_("JEXPIRED"); ?></span>
		<?php endif; ?>
	<?php if (isset($this->item->toc)):
 	echo $this->item->toc;
 endif; ?>
	<div itemprop="articleBody">
		<?php echo $this->item->text; ?>
	</div>

	<?php if ($info == 1 || $info == 2): ?>
		<?php if ($useDefList): ?>
				<?php
  	// Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block
  	?>
			<?php echo JLayoutHelper::render("joomla.content.info_block.block", [
   	"item" => $this->item,
   	"params" => $params,
   	"position" => "below",
   ]); ?>
		<?php endif; ?>
		<?php if ($params->get("show_tags", 1) && !empty($this->item->tags->itemTags)): ?>
			<?php $this->item->tagLayout = new JLayoutFile("joomla.content.tags"); ?>
			<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (
 	!empty($this->item->pagination) &&
 	$this->item->pagination &&
 	$this->item->paginationposition &&
 	!$this->item->paginationrelative
 ):
 	echo $this->item->pagination; ?>
	<?php
 endif; ?>
	<?php if (
 	isset($urls) &&
 	((!empty($urls->urls_position) && $urls->urls_position == "1") || $params->get("urls_position") == "1")
 ): ?>
	<?php echo $this->loadTemplate("links"); ?>
<?php endif; ?>
	<?php endif; ?>
	<?php if (
 	!empty($this->item->pagination) &&
 	$this->item->pagination &&
 	$this->item->paginationposition &&
 	$this->item->paginationrelative
 ):
 	echo $this->item->pagination; ?>
	<?php
 endif; ?>
	<?php
// Content is generated by content plugin event "onContentAfterDisplay"
?>
	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
