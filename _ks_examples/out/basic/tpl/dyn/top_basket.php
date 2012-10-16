<?php if($oxcmp_basket->getContents()): ?>
  <?php $currency = $oView->getActCurrency(); ?>
  <dl class="box basket">
    <dt id="tm.basket.dt">
      <a id="test_TopBasketHeader" rel="nofollow" href="<?= $_->_s($oViewConf->getBasketLink()); ?>"><?= $_->__('INC_HEADER_CART'); ?></a>
    </dt>
    <dd id="tm.basket.dd" class="dropdown">
      <ul id="basket_menu" class="menue vertical">
        <li><a href="<?= $_->_s($oViewConf->getSslSelfLink() . 'cl=basket'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_TOBASKET'); ?></a></li>
        <?php if($oxcmp_user->oxuser__oxpassword->value && $oView->isLowOrderPrice()): ?>
          <li><a href="<?= $_->_s($oViewConf->getSslSelfLink() . 'cl=payment'); ?>" rel="nofollow"><?= $_->__('INC_ACCOUNT_HEADER_TOPAYMENT'); ?></a></li>
        <?php endif; ?>
      </ul>
    </dd>
    <dd>
      <table summary="<?= $_->__('INC_HEADER_CART'); ?>">
        <tr>
          <th><?= $_->__('INC_CMP_BASKET_PRODUCT'); ?></th>
          <td id="test_TopBasketProducts"><?= $oxcmp_basket->getProductsCount(); ?></td>
        </tr>
        <tr>
          <th><?= $_->__('INC_CMP_BASKET_QUANTITY'); ?></th>
          <td id="test_TopBasketItems"><?= $oxcmp_basket->getItemsCount(); ?></td>
        </tr>
        <?php if($oxcmp_basket->getFDeliveryCosts()): ?>
          <tr>
            <th><?= $_->__('INC_CMP_BASKET_SHIPPING'); ?></th>
            <td id="test_TopBasketShipping"><?= $oxcmp_basket->getFDeliveryCosts() . " {$currency->sign}"; ?></td>
          </tr>
        <?php endif; ?>
        <tr>
          <th><?= $_->__('INC_CMP_BASKET_TOTALPRODUCTS'); ?></th>
          <td id="test_TopBasketTotal"><?= $oxcmp_basket->getFProductsPrice() . " {$currency->sign}"; ?></td>
        </tr>
      </table>
    </dd>
  </dl>
  <?php $_->oxscript(array('add' => "oxid.topnav('tm.basket.dt','tm.basket.dd');")); ?>
<?php endif; ?>