<?php $title = $template_title; $location = $_->oxmultilangassign('START_TITLE'); $isStart = true; include('_header.php'); ?>

<?php if($oView->isDemoShop()): ?>
    <?php include('inc/admin_banner.tpl'); ?>
<?php endif; ?>

<div class="welcome">
    <?php $_->oxcontent(array('ident' => 'oxstartwelcome')); ?>
</div>

<?php if($oView->getTopArticleList()): ?>
  <?php $i = 1; foreach($oView->getTopArticleList() as $actionproduct): //WeekArt ?>
    <?php $product = $actionproduct; $showMainLink = true; $head = $_->oxmultilangassign('START_WEEKSPECIAL'); $testid = "WeekSpecial_{$actionproduct->oxarticles__oxid->value}"; $testHeader = "WeekSpecial_{$i}"; include('inc/product.tpl'); ?>
  <?php $i++; endforeach; ?>
<?php endif; ?>

<?php if($oView->getFirstArticle()): ?>
  <?php $_->oxcontent(array('ident' => 'oxfirststart', 'field' => 'oxtitle', 'assign' => 'oxfirststart_title')); ?>
  <?php $_->oxcontent(array('ident' => 'oxfirststart', 'assign' => 'oxfirststart_text')); ?>
  <?php $firstarticle = $oView->getFirstArticle(); ?>
  <?php $size = 'big'; $showMainLink = true; $class = 'topshop'; $head = $oxfirststart_title; $head_desc = $oxfirststart_text; $product = $firstarticle; $testid = "FirstArticle_{$firstarticle->oxarticles__oxid->value}"; $testHeader = $FirstArticle; include('inc/product.tpl'); ?>
<?php endif; ?>

<?php if(count($oView->getArticleList()) > 0): ?>
  <strong id="test_LongRunHeader" class="head2"><?= $_->__('START_LONGRUNNINGHITS'); ?></strong>
  <?php $actionproduct_size = count($oView->getArticleList())%2 != 0 ? 'big' : ''; ?>
  <?php foreach($oView->getArticleList() as $actionproduct): ?>
      <?php $showMainLink = true; $product = $actionproduct; $size = $actionproduct_size; $testid = "LongRun_{$actionproduct->oxarticles__oxid->value}"; include('inc/product.tpl'); ?>
      <?php $actionproduct_size = ''; ?>
  <?php endforeach; ?>
<?php endif; ?>

<?php if(count($oView->getNewestArticles()) > 0): ?>
  <strong id="test_FreshInHeader" class="head2">
    <?= $_->__('START_JUSTARRIVED'); ?>

    <?php if($rsslinks->newestArticles): ?>
        <a class="rss" id="rss.newestArticles" href="<?= $rsslinks->newestArticles->link; ?>" title="<?= $rsslinks->newestArticles->title; ?>"></a>
        <?php $_->oxscript(array('add' => "oxid.blank('rss.newestArticles');")); ?>
    <?php endif; ?>
  </strong>
  <?php foreach($oView->getNewestArticles() as $actionproduct): ?>
      <?php $showMainLink = true; $product = $actionproduct; $size = 'small'; $testid = "FreshIn_{$actionproduct->oxarticles__oxid->value}"; include('inc/product.tpl'); ?>
  <?php endforeach; ?>
<?php endif; ?>

<?php if(count($oView->getCatOfferArticleList()) > 0): ?>
  <strong id="test_CategoriesHeader" class="head2"><?= $_->__('START_CATEGORIES'); ?></strong>
  <?php $actionproduct_size = count($oView->getCatOfferArticleList())%2 != 0 ? 'big' : ''; ?>
  <?php $i = 0; foreach($oView->getCatOfferArticleList() as $actionproduct): //CatArt ?>
      <?php if($actionproduct->getCategory()): ?>
          <?php $oCategory = $actionproduct->getCategory(); ?>
          <?php $actionproduct_title = $oCategory->getNrOfArticles() > 0 ? "{$oCategory->oxcategories__oxtitle->value} (" . $oCategory->getNrOfArticles() . ')' : $oCategory->oxcategories__oxtitle->value; ?>
          <?php $showMainLink = true; $product = $actionproduct; $size = $actionproduct_size; $head = $actionproduct_title; $head_link = $oCategory->getLink(); $testid = "CatArticle_{$actionproduct->oxarticles__oxid->value}"; $testHeader = "Category_{$i}"; include('inc/product.tpl');  ?>
          <?php $actionproduct_size = ''; ?>
      <?php endif; ?>
  <?php $i++; endforeach; ?>
<?php endif; ?>

<?php include('inc/tags.tpl'); ?>

<?php $_->oxid_tracker(array('title' => $template_title)); ?>
<?php include('_footer.tpl'); ?>