<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html<?php if($oView->getActiveLangAbbr()): ?> lang="<?= $oView->getActiveLangAbbr(); ?>"<?php endif; ?>>
<head>
  <?php $_titlesuffix = isset($_titlesuffix) ? $_titlesuffix : $oView->getTitleSuffix(); ?>
  <?php $title = isset($title) ? $title : $oView->getTitle(); ?>
  <title><?= $oxcmp_shop->oxshops__oxtitleprefix->value; echo $title ? " | $title" : ''; echo $_titlesuffix ? " | $_titlesuffix" : ''; echo $titlepagesuffix ? " | $titlepagesuffix" : ''; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=<?= $charset; ?>">
  <?php if($oView->noIndex() == 1): ?>
  <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
  <?php elseif($oView->noIndex() == 2): ?>
  <meta name="ROBOTS" content="NOINDEX, FOLLOW">
  <?php endif; ?>
  <?php if($oView->getMetaDescription()): ?>
    <meta name="description" content="<?= $oView->getMetaDescription(); ?>">
  <?php endif; ?>
  <?php if($oView->getMetaKeywords()): ?>
    <meta name="keywords" content="<?= $oView->getMetaKeywords(); ?>">
  <?php endif; ?>
  <?php if($oView->getCanonicalUrl()): ?>
    <link rel="canonical" href="<?= $oView->getCanonicalUrl(); ?>">
  <?php endif; ?>
  <link rel="shortcut icon" href="<?= $oViewConf->getBaseDir(); ?>favicon.ico">
  <link rel="stylesheet" type="text/css" href="<?= $oViewConf->getResourceUrl(); ?>oxid.css">
  <!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?= $oViewConf->getResourceUrl(); ?>oxid_ie8.css"><![endif]-->
  <!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?= $oViewConf->getResourceUrl(); ?>oxid_ie7.css"><![endif]-->
  <!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?= $oViewConf->getResourceUrl(); ?>oxid_ie6.css"><![endif]-->

  <?php if($rsslinks): ?>
    <?php foreach($rsslinks as $rssentry): ?>
      <link rel="alternate" type="application/rss+xml" title="<?= strip_tags($rssentry->title); ?>" href="<?= $rssentry->link; ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body>

<div id="page">

  <div id="header">
    <div class="bar oxid">
      <a class="logo" href="<?= $_->_s($oViewConf->getHomeLink()); ?>">
        <img src="<?= $oViewConf->getImageUrl(); ?>logo.png" alt="<?= $oxcmp_shop->oxshops__oxtitleprefix->value; ?>">
      </a>

      <?php if($oView->showTopBasket()): ?>
        <?= $_->oxid_include_dynamic(array('file' => 'dyn/top_basket.php', 'type' => 'basket')); ?>
      <?php endif; ?>
      <?= $_->oxid_include_dynamic(array('file' => 'dyn/top_account.php', 'type' => 'account')); ?>
      <dl class="box service">
        <dt id="tm.service.dd"><?= $_->__('INC_HEADER_SERVICE'); ?></dt>
        <dd>
          <ul>
            <li><a id="test_link_service_contact" href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=contact'); ?>" rel="nofollow"><?= $_->__('INC_HEADER_CONTACT'); ?></a></li>
            <li><a id="test_link_service_help" href="<?= $_->_s($oViewConf->getHelpLink()); ?>" rel="nofollow"><?= $_->__('INC_HEADER_HELP'); ?></a></li>
            <li><a id="test_link_service_links" href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=links'); ?>"><?= $_->__('INC_HEADER_LINKS'); ?></a></li>
            <li><a id="test_link_service_guestbook" href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=guestbook'); ?>" rel="nofollow"><?= $_->__('INC_HEADER_GUESTBOOK'); ?></a></li>
          </ul>
        </dd>
      </dl>

      <div class="clear"></div>
    </div>

      <div class="bar links<?= !$oView->showTopCatNavigation() ? ' single' : ''; ?>">
        <div class="fixed">
          <?php if($oView->isLanguageLoaded()): ?>
            <?php foreach($oxcmp_lang as $_language): ?>
              <a id="test_Lang_<?= $_language->name; ?>" class="language<?php $_language->selected ? ' act' : ''; ?>" href="<?= $_->_s($_language->link, array('params' => $oView->getDynUrlParams())); ?>" hreflang="<?= $_language->abbr; ?>" title="<?= $_language->name; ?>"><img src="<?= $oViewConf->getImageUrl(); ?>lang/<?= $_language->abbr; ?>.gif" alt="<?= $_language->name; ?>"></a>
            <?php endforeach; ?>
          <?php endif; ?>
          <?php if($oView->loadCurrency()): ?>
            <?php foreach($oxcmp_cur as $k => $_currency): ?>
              <a id="test_Curr_<?= $_currency->name; ?>" class="currency<?= $k == 0 ? ' sep' : ''; echo $_currency->selected ? ' act' : ''; ?>" href="<?= $_->_s($_currency->link, array('params' => $oView->getDynUrlParams())); ?>" rel="nofollow"><?= $_currency->name; ?></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="left">
          <?php if(!$oView->showTopCatNavigation()): ?>
            <a id="test_HeaderHome" href="<?= $_->_s($oViewConf->getHomeLink()); ?>"><?= $_->__('INC_HEADER_HOME'); ?></a>
          <?php endif; ?>

          <?php if($oView->getWishlistName()): ?>
            <a href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=wishlist'); ?>" class=""><?= $oView->getWishlistName(); echo $_->__('INC_HEADER_PRIVATWISHLIST'); ?></a>
          <?php endif; ?>
        </div>

        <div class="right">
          <?php $oCont = $oView->getContentByIdent("oxagb"); ?>
          <a id="test_HeaderTerms" href="<?= $oCont->getLink(); ?>" rel="nofollow"><?= $oCont->oxcontents__oxtitle->value; ?></a>
          <?php $oCont = $oView->getContentByIdent("oximpressum"); ?>
          <a id="test_HeaderImpressum" href="<?= $oCont->getLink(); ?>"><?= $oCont->oxcontents__oxtitle->value; ?></a>
          <?php if($oView->getMenueList()): ?>
            <?php foreach($oView->getMenueList() as $oMenueContent): ?>
              <a href="<?= $oMenueContent->getLink(); ?>"><?= $oMenueContent->oxcontents__oxtitle->value; ?></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="clear"></div>
      </div>

      <?php if($oView->showTopCatNavigation()): ?>
      <div class="bar categories">
        <a id="test_HeaderHome" href="<?= $_->_s($oViewConf->getHomeLink()); ?>" class="fixed"><?= $_->__('INC_HEADER_HOME'); ?></a>
        <ul class="menue horizontal" id="mn.categories">

        <?php $iCatCnt = 1; ?>
        <?php foreach($oxcmp_categories as $catkey => $ocat): // root ?>
          <?php if($ocat->getIsVisible()): ?>

            <?php if($ocat->getContentCats()): ?>
              <?php foreach($ocat->getContentCats() as $contkey => $ocont): //cont ?>
                <?php if($iCatCnt <= $oView->getTopNavigationCatCnt()): ?>
                  <li><a id="root<?= $iCatCnt; ?>" href="<?= $ocont->getLink(); ?>"<?php $ocont->expanded ? ' class="exp"' : ''; ?>><?= $ocont->oxcontents__oxtitle->value; ?> </a></li>
                <?php endif; ?>
                <?php $iCatCnt++; ?>
              <?php endforeach; ?>
            <?php endif; ?>

            <?php if($iCatCnt <= $oView->getTopNavigationCatCnt()): ?>
              <li>
                <a id="root<?= $iCatCnt; ?>" href="<?= $ocat->getLink(); ?>"<?php $ocat->expanded ? ' class="exp"':''; ?>><?= $ocat->oxcategories__oxtitle->value; echo $ocat->getNrOfArticles() > 0 ? ' (' . $ocat->getNrOfArticles() . ')' : ''; ?> </a>
                <?php if($ocat->getSubCats()): ?>
                  <ul class="menue vertical dropdown">
                  <?php $i = 1; foreach($ocat->getSubCats() as $subcatkey => $osubcat): //SubCat ?>
                    <?php if($osubcat->getContentCats()): ?>
                      <?php $j = 1; foreach($osubcat->getContentCats() as $subcontkey => $osubcont): //subcont ?>
                        <li><a id="test_Top_root<?= $iCatCnt; ?>_Cms_<?= $i; ?>_<?= $j; ?>" href="<?= $osubcont->getLink(); ?>"><?= $osubcont->oxcontents__oxtitle->value; ?> </a></li>
                      <?php $j++; endforeach; ?>
                    <?php endif; ?>
                    <?php if($osubcat->getIsVisible()): ?>
                      <li><a id="test_Top_root<?= $iCatCnt; ?>_SubCat_<?= $i; ?>" href="<?= $osubcat->getLink(); ?>"><?= $osubcat->oxcategories__oxtitle->value; echo $osubcat->getNrOfArticles() > 0 ? ' (' . $osubcat->getNrOfArticles() . ')' : ''; ?> </a></li>
                    <?php endif; ?>
                  <?php $i++; endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endif; ?>
            <?php $iCatCnt++; ?>

          <?php endif; ?>
        <?php endforeach; ?>

        <?php if($iCatCnt > $oView->getTopNavigationCatCnt()): ?>
          <li>
            <?php $_navcatmore = $oView->getCatMore(); ?>
            <a id="root<?= $oView->getTopNavigationCatCnt() + 1; ?>" href="<?= $_->_s($_navcatmore->closelink . '&amp;cl=alist'); ?>" class="more<?php $_navcatmore->expanded ? ' exp' : ''; ?>"><?= $_->__('INC_HEADER_URLMORE'); ?> </a>
            <ul class="menue vertical dropdown">
              <?php $k = 1; foreach($oxcmp_categories as $morecatkey => $omorecat): //more ?>
                <?php if($omorecat->getIsVisible()): ?>
                  <?php if($omorecat->getContentCats()): ?>
                    <?php foreach($omorecat->getContentCats() as $morecontkey => $omorecont): //morecont ?>
                      <li><a href="<?= $omorecont->getLink(); ?>"><?= $omorecont->oxcontents__oxtitle->value; ?> </a></li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  <li><a id="test_Top_RootMore_MoreCat_<?= $k; ?>" href="<?= $omorecat->getLink(); ?>"><?= $omorecat->oxcategories__oxtitle->value; echo $omorecat->getNrOfArticles() > 0 ? ' (' . $omorecat->getNrOfArticles() . ')' : ''; ?> </a></li>
                <?php endif; ?>
              <?php $k++; endforeach; ?>
            </ul>
          </li>
        <?php endif; ?>

        </ul>
        <div class="clear"></div>
      </div>
      <?php $_->oxscript(array('add' => "oxid.catnav('mn.categories');")); ?>
      <?php endif; ?>

      <div class="clear"></div>
  </div>

    <div id="content">
        <div id="left"><?php include('_left.tpl'); ?></div>
        <div id="path"><?php include('_path.tpl'); ?></div>
        <div id="right"><?php include('_right.tpl'); ?></div>
        <div id="body">
        <?= $_->oxid_include_dynamic(array('file' => 'dyn/newbasketitem_message.tpl')); ?>
        <?php $Errorlist = $Errors->default; include('inc/error.tpl'); ?>