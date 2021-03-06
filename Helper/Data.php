<?php 
class Cammino_Googlemerchant_Helper_Data extends Mage_Core_Helper_Abstract{
  
  public function hasCoupon($product){
    $coupon = $product->getGooglemerchantCoupon();
    
    if($coupon != false && $coupon != ""){
      return true;
    }else{
      return false;
    }
  }

  public function getCouponCode($product){
    return $product->getGooglemerchantCoupon();
  }

  public function getDiscount($product){
    $quote = Mage::getModel('sales/quote')->setStoreId(1);

    $stockItem = Mage::getModel('cataloginventory/stock_item');
    $stockItem->assignProduct($product)
      ->setData('stock_id', 1)
      ->setData('store_id', 1);

    $stockItem->setUseConfigManageStock(false);
    $stockItem->setManageStock(false);

    $quote->addProduct($product,1);
    $quote->getShippingAddress()->setCountryId('BR'); 
    $quote->setCouponCode($this->getCouponCode($product));
    $quote->collectTotals();

    $product->setFinalPrice($quote->getGrandTotal());

    return $product;
  }
}
