<?php if($oxcmp_user->oxuser__oxpassword->value): ?>
  <dl class="box account">
    <dt id="tm.account.dt">
      <a id="test_TopAccMyAccount" rel="nofollow" href="<?= $_->_s($oViewConf->getSslSelfLink() . 'cl=account'); ?>"><?= $_->__('INC_HEADER_MYACCOUNT'); ?></a>
    </dt>
    <dd id="tm.account.dd" class="dropdown">
      <ul id="account_menu" class="menue vertical">
        <li><a href="<?= $_->_s($oViewConf->getSslSelfLink() . 'cl=account_password'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_PASSWORD'); ?></a></li>
        <li><a href="<?= $_->_s($oViewConf->getSslSelfLink() . 'cl=account_user'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_ADDRESS'); ?></a></li>
        <li><a href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=account_order'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_ORDERHISTORY'); ?></a></li>
        <li><a href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=account_noticelist'); ?>" rel="nofollow"><?= $_->__('INC_HEADER_NOTICELIST'); ?></a></li>
        <li><a href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=account_wishlist'); ?>" rel="nofollow"><?= $_->__('INC_HEADER_WISHLIST'); ?></a></li>
        <li><a href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=compare'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_MYPRODUCTCOMPARISON'); ?></a></li>
        <li><a href="<?= $_->_s($oViewConf->getSelfLink() . 'cl=account_recommlist'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_MYRECOMMLIST'); ?></a></li>

        <li><a href="<?= $oViewConf->getLogoutLink(); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_LOGOUT'); ?></a></li>
      </ul>
    </dd>
    <dd>
      <?= $_->__('INC_CMP_LOGIN_RIGHT_LOGGEDINAS'); ?><br>
      <b><?= "{$oxcmp_user->oxuser__oxfname->value} {$oxcmp_user->oxuser__oxlname->value}"; ?></b><br>
      <span class="btn"><a id="test_TopAccLogout" href="<?= $oViewConf->getLogoutLink(); ?>" rel="nofollow"><?= $_->__('INC_HEADER_LOGOUT'); ?></a></span>
    </dd>
  </dl>
  <?php $_->oxscript(array('add' => "oxid.topnav('tm.account.dt','tm.account.dd');")); ?>
<?php endif; ?>