<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 11:35
 */

namespace common\helpers;


use common\models\c2\entity\CommissionRecord;
use common\models\c2\entity\ConsumptionRecord;
use common\models\c2\entity\DistributorCustomerRs;
use common\models\c2\entity\DistributorSalesmanRs;
use common\models\c2\entity\Shop;
use common\models\c2\search\DistributorFranchiseeRs;
use common\models\c2\search\FranchiseeCustomerRs;
use common\models\c2\search\FranchiseeSalesmanRs;
use common\models\c2\search\ShopCustomerRs;
use common\models\c2\search\ShopSalesmanRs;
use common\models\c2\statics\TransferType;
use Yii;
class FeUserTransferHelper
{
  public $Original_id;
  public $Target_id;

  public static function RelationshipTransfer($param,$type){
      if($type===TransferType::DISTRIBUTOR_TRANSFER){
        return static::getDistributorTransfer($param);
      }elseif ($type===TransferType::FRANCHISEE_TRANSFER){
        return static::getFranchiseeTransfer($param);
      }elseif ($type===TransferType::SHOP_TRANSFER){
        return static::getShopTransfer($param);
      }elseif ($type===TransferType::SALESMAN_TRANSFER){
          return static::gerSalesmanTransfer($param);
      }
  }

    protected static function getDistributorTransfer($param){
      if($param->validate()){
        $originalFranchiseeIds = DistributorFranchiseeRs::findAll(['distributor_id'=>$param->originalDistributorId]);
        $transaction = \Yii::$app->db->beginTransaction();
        if(empty($originalFranchiseeIds)){
            return false;
        }
        foreach ($originalFranchiseeIds as $originalFranchiseeId){
            $originalFranchiseeId->distributor_id = $param->targetDistributorId;
            if(!$originalFranchiseeId->save(false)){
                $transaction->rollBack();
                return false;
            }
        }

        $originalCustomerIds = DistributorCustomerRs::find()->select('customer_id')->where(['distributor_id'=>$param->originalDistributorId])->asArray()->all();
        $targetCustomersIds = DistributorCustomerRs::find()->select('customer_id')->where(['distributor_id'=>$param->targetDistributorId])->asArray()->all();
        if(empty($targetCustomersIds)){
            $DistributorCustomerRS = DistributorCustomerRs::findAll(['distributor_id'=>$param->originalDistributorId]);
                foreach ($DistributorCustomerRS as $DistributorCustomer){
                    $DistributorCustomer->distributor_id = $param->targetDistributorId;
                        if(!$DistributorCustomer->save(false)){
                            $transaction->rollBack();
                            return false;
                        }
                    }
         }else{
            if(!empty($originalCustomerIds)){
                foreach ($originalCustomerIds as $originalCustomerId) {
                    foreach ($targetCustomersIds as $targetCustomerId) {
                        if ($originalCustomerId == $targetCustomerId) {
                            $DistributorCustomerRS = DistributorCustomerRs::findOne(['distributor_id' => $param->originalDistributorId, 'customer_id' => $originalCustomerId]);
                            if(!empty($DistributorCustomerRS)){
                                if (!$DistributorCustomerRS->delete()) {
                                    $transaction->rollBack();
                                    return false;
                                }
                            }
                        } else if ($originalCustomerId != $targetCustomerId && !in_array($targetCustomerId, $originalCustomerIds)) {
                            $DistributorCustomerArr[] = $originalCustomerId['customer_id'];
                        }
                    }
                }
                if (isset($DistributorCustomerArr) && !empty($DistributorCustomerArr)) {
                    $diffDistributorCustomerArr = array_unique($DistributorCustomerArr);
                    foreach ($diffDistributorCustomerArr as $diffCustomerArr) {
                        $diffDistributorCustomerRS = DistributorCustomerRs::findOne(['distributor_id' => $param->originalDistributorId, 'customer_id' => $diffCustomerArr]);
                        $diffDistributorCustomerRS->distributor_id = $param->targetDistributorId;
                        if (!$diffDistributorCustomerRS->save(false)) {
                            $transaction->rollBack();
                            return false;
                        }
                    }
                }
            }
          }

          $originalSalesmanIds = DistributorSalesmanRs::find()->select('salesman_id')->where(['distributor_id'=>$param->originalDistributorId])->asArray()->all();
          $targetSalesmanIds = DistributorSalesmanRs::find()->select('salesman_id')->where(['distributor_id'=>$param->targetDistributorId])->asArray()->all();
          if(empty($targetSalesmanIds)) {
              $DistributorSalesmanRS = DistributorSalesmanRs::findAll(['distributor_id' => $param->originalDistributorId]);
              foreach ($DistributorSalesmanRS as $DistributorSalesman) {
                  $DistributorSalesman->distributor_id = $param->targetDistributorId;
                  if (!$DistributorSalesman->save(false)) {
                      $transaction->rollBack();
                      return false;
                  }
              }
          }else{
              if(!empty($originalSalesmanIds)){
                  foreach ($originalSalesmanIds as $originalSalesmanId) {
                      foreach ($targetSalesmanIds as $targetSalesmanId) {
                          if ($originalSalesmanId == $targetSalesmanId) {
                              $DistributorSalesmanRS = DistributorSalesmanRs::findOne(['distributor_id' => $param->originalDistributorId, 'salesman_id' => $originalSalesmanId]);
                              if(!empty($DistributorSalesmanRS)){
                                  if (!$DistributorSalesmanRS->delete()) {
                                      $transaction->rollBack();
                                      return false;
                                  }
                              }
                          } else if ($originalSalesmanId != $targetSalesmanId && !in_array($targetSalesmanId, $originalSalesmanIds)) {
                              $DistributorSalesmanArr[] = $originalSalesmanId['salesman_id'];
                          }
                      }
                  }
                  if (isset($DistributorSalesmanArr) && !empty($DistributorSalesmanArr)) {
                      $diffDistributorSalesmanArr = array_unique($DistributorSalesmanArr);
                      foreach ($diffDistributorSalesmanArr as $diffSalesmanArr) {
                          $diffDistributorSalesmanRS = DistributorSalesmanRs::findOne(['distributor_id' => $param->originalDistributorId, 'salesman_id' => $diffSalesmanArr]);
                          $diffDistributorSalesmanRS->distributor_id = $param->targetDistributorId;
                          if (!$diffDistributorSalesmanRS->save(false)) {
                              $transaction->rollBack();
                              return false;
                          }
                      }
                  }
              }
          }

          $originalDistributorShopIds = Shop::findAll(['distributor_id'=>$param->originalDistributorId]);
          if(!empty($originalDistributorShopIds)){
              foreach ($originalDistributorShopIds as $originalDistributorShopId){
                  $originalDistributorShopId->distributor_id = $param->targetDistributorId;
                  if(!$originalDistributorShopId->save(false)){
                      $transaction->rollBack();
                      return false;
                  }
              }
          }

          $consumptionRecords = ConsumptionRecord::findAll(['distributor_id'=>$param->originalDistributorId]);
          $commissionRecords = CommissionRecord::findAll(['distributor_id'=>$param->originalDistributorId]);
          if(!empty($consumptionRecords) && !empty($commissionRecords)){
              foreach($consumptionRecords as $consumptionRecord){
                  $consumptionRecord->distributor_id = $param->targetDistributorId;
                  if(!$consumptionRecord->save(false)){
                      $transaction->rollBack();
                      return false;
                  }
              }
              foreach($commissionRecords as $commissionRecord){
                  $commissionRecord->distributor_id = $param->targetDistributorId;
                  if(!$commissionRecord->save(false)){
                      $transaction->rollBack();
                      return false;
                  }
              }
          }
          $transaction->commit();
          return true;
      }else{
          return false;
      }
    }

    protected static function getFranchiseeTransfer($param){
        if($param->validate()){
            $originalCustomerIds = FranchiseeCustomerRs::find()->select('customer_id')->where(['franchisee_id'=>$param->originalFranchiseeId])->asArray()->all();
            $targetCustomersIds = FranchiseeCustomerRs::find()->select('customer_id')->where(['franchisee_id'=>$param->targetFranchiseeId])->asArray()->all();
            $transaction = \Yii::$app->db->beginTransaction();
            if(empty($targetCustomersIds)){
                $FranchiseeCustomerRS = FranchiseeCustomerRs::findAll(['franchisee_id'=>$param->originalFranchiseeId]);
                if(!empty($FranchiseeCustomerRS)){
                    foreach ($FranchiseeCustomerRS as $FranchiseeCustomer){
                        $FranchiseeCustomer->franchisee_id = $param->targetFranchiseeId;
                        if(!$FranchiseeCustomer->save(false)){
                            $transaction->rollBack();
                            return false;
                        }
                    }
                }
            }else{
               if(!empty($originalCustomerIds)){
                   foreach ($originalCustomerIds as $originalCustomerId) {
                       foreach ($targetCustomersIds as $targetCustomerId){
                           if($originalCustomerId == $targetCustomerId){
                               $FranchiseeCustomerRS = FranchiseeCustomerRs::findOne(['franchisee_id'=>$param->originalFranchiseeId,'customer_id'=>$originalCustomerId]);
                               if(!empty($FranchiseeCustomerRS)){
                                   if(!$FranchiseeCustomerRS->delete()){
                                       $transaction->rollBack();
                                       return false;
                                   }
                               }
                           }else if( $originalCustomerId != $targetCustomerId  && !in_array($targetCustomerId,$originalCustomerIds)){
                               $FranchiseeCustomerArr[]= $originalCustomerId['customer_id'];
                           }
                       }
                   }
                   if(isset($FranchiseeCustomerArr) && !empty($FranchiseeCustomerArr)){
                       $diffFranchiseeCustomerArr = array_unique($FranchiseeCustomerArr);;
                       foreach($diffFranchiseeCustomerArr as $diffCustomerArr){
                           $diffFranchiseeCustomerRS = FranchiseeCustomerRs::findOne(['franchisee_id'=>$param->originalFranchiseeId,'customer_id'=>$diffCustomerArr]);
                           $diffFranchiseeCustomerRS->franchisee_id = $param->targetFranchiseeId;
                           if(!$diffFranchiseeCustomerRS->save(false)){
                               $transaction->rollBack();
                               return false;
                           }
                       }
                   }
               }
            }

            $originalSalesmanIds = FranchiseeSalesmanRs::find()->select('salesman_id,recommender_id')->where(['franchisee_id'=>$param->originalFranchiseeId])->asArray()->all();
            $targetSalesmanIds = FranchiseeSalesmanRs::find()->select('salesman_id')->where(['franchisee_id'=>$param->targetFranchiseeId])->asArray()->all();
            if(empty($targetSalesmanIds)){
                $recommenderIds = FranchiseeSalesmanRs::findAll(['recommender_id'=>$param->originalFranchiseeId]);
                if(!empty($recommenderIds)){
                    foreach ($recommenderIds as $recommenderId){
                        $recommenderId->recommender_id = $param->targetFranchiseeId;
                        if(!$recommenderId->save(false)){
                            $transaction->rollBack();
                            return false;
                        }
                    }
                }
                $FranchiseeSalesmanRs = FranchiseeSalesmanRs::findAll(['franchisee_id'=>$param->originalFranchiseeId]);
                foreach($FranchiseeSalesmanRs as $FranchiseeSalesman){
                    $FranchiseeSalesman->franchisee_id = $param->targetFranchiseeId;
                        if(!$FranchiseeSalesman->save(false)){
                            $transaction->rollBack();
                            return false;
                        }
                }
            }else{

                if(!empty($originalSalesmanIds)){
                    foreach ($originalSalesmanIds as $originalSalesmanId) {
                        foreach ($targetSalesmanIds as $targetSalesmanId){
                            if(($originalSalesmanId['salesman_id'] == $targetSalesmanId)){
                                $FranchiseeSalesmanRs = FranchiseeSalesmanRs::findOne(['franchisee_id'=>$param->originalFranchiseeId,'salesman_id'=>$originalSalesmanId['salesman_id']]);
                                if($originalSalesmanId['recommender_id'] == $param->originalFranchiseeId){
                                    $FranchiseeSaveSalesmanRs = FranchiseeSalesmanRs::findOne(['franchisee_id'=>$param->targetFranchiseeId,'salesman_id'=>$originalSalesmanId['salesman_id']]);
                                    $FranchiseeSaveSalesmanRs->recommender_id = $param->targetFranchiseeId;
                                    if(!$FranchiseeSaveSalesmanRs->save(false)){
                                        $transaction->rollBack();
                                        return false;

                                    }
                                }
                                if(!$FranchiseeSalesmanRs->delete()){
                                    $transaction->rollBack();
                                    return false;
                                }
                            }else if($originalSalesmanId['salesman_id'] !== $targetSalesmanId && !in_array($originalSalesmanId['salesman_id'],$targetSalesmanIds)){
                                $FranchiseeSalesmanArr[]= $originalSalesmanId['salesman_id'];
                            }
                        }
                    }
                    if(isset($FranchiseeSalesmanArr) && !empty($FranchiseeSalesmanArr)){
                        $diffFranchiseeSalesmanArr = array_unique($FranchiseeSalesmanArr);
                        foreach($diffFranchiseeSalesmanArr as $diffFranchiseeSalesman){
                            $diffFranchiseeSalesmanRS = FranchiseeSalesmanRs::findOne(['franchisee_id'=>$param->originalFranchiseeId,'salesman_id'=>$diffFranchiseeSalesman]);
                            if($diffFranchiseeSalesmanRS->recommender_id == $param->originalFranchiseeId){
                                $diffFranchiseeSalesmanRS->recommender_id = $param->targetFranchiseeId;
                            }
                            $diffFranchiseeSalesmanRS->franchisee_id = $param->targetFranchiseeId;
                            if(!$diffFranchiseeSalesmanRS->save(false)){
                                $transaction->rollBack();
                                return false;
                            }
                        }
                    }
                }
            }

            $originalFranchiseeShopIds = Shop::findAll(['franchisee_id'=>$param->originalFranchiseeId]);
            if(!empty($originalFranchiseeShopIds)){
                foreach ($originalFranchiseeShopIds as $originalFranchiseeShopId){
                    $originalFranchiseeShopId->franchisee_id = $param->targetFranchiseeId;
                    if(!$originalFranchiseeShopId->save(false)){
                        $transaction->rollBack();
                        return false;
                    }
                }
            }

            $consumptionRecords = ConsumptionRecord::findAll(['franchisee_id'=>$param->originalFranchiseeId]);
            $commissionRecords = CommissionRecord::findAll(['franchisee_id'=>$param->originalFranchiseeId]);
            if(!empty($consumptionRecords) && !empty($commissionRecords)){
                foreach($consumptionRecords as $consumptionRecord){
                    $consumptionRecord->franchisee_id = $param->targetFranchiseeId;
                    if(!$consumptionRecord->save(false)){
                        $transaction->rollBack();
                        return false;
                    }
                }
                foreach($commissionRecords as $commissionRecord){
                    $commissionRecord->franchisee_id = $param->targetFranchiseeId;
                    if(!$commissionRecord->save(false)){
                        $transaction->rollBack();
                        return false;
                    }
                }
            }
            $transaction->commit();
            return true;
        }else{
            return false;
        }
    }

    protected static function getShopTransfer($param){
        if ($param->validate()){
            $originalCustomerIds = ShopCustomerRs::find()->select('customer_id')->where(['shop_id'=>$param->originalShopId])->asArray()->all();
            $targetCustomersIds = ShopCustomerRs::find()->select('customer_id')->where(['shop_id'=>$param->targetShopId])->asArray()->all();
            $transaction = \Yii::$app->db->beginTransaction();
            if(empty($targetCustomersIds)){
                $ShopCustomerRS = ShopCustomerRs::findAll(['shop_id'=>$param->originalShopId]);
                foreach($ShopCustomerRS as $ShopCustomer){
                    $ShopCustomer->shop_id = $param->targetShopId;
                    if(!$ShopCustomer->save(false)){
                        $transaction->rollBack();
                        return false;
                    }
                }
            }else{
                if(!empty($originalCustomerIds)){
                    foreach ($originalCustomerIds as $originalCustomerId) {
                        foreach ($targetCustomersIds as $targetCustomerId){
                            if($originalCustomerId == $targetCustomerId){
                                $ShopCustomerRS = ShopCustomerRs::findOne(['shop_id'=>$param->originalShopId,'customer_id'=>$originalCustomerId]);
                                if(!empty($ShopCustomerRS)){
                                    if(!$ShopCustomerRS->delete()){
                                        $transaction->rollBack();
                                        return false;
                                    }
                                }
                            }else if( $originalCustomerId != $targetCustomerId  && !in_array($targetCustomerId,$originalCustomerIds)){
                                $ShopCustomerArr[]= $originalCustomerId['customer_id'];
                            }
                        }
                    }
                    if(isset($ShopSalesmanArr) && !empty($ShopCustomerArr)){
                        $diffShopCustomerArr = array_unique($ShopCustomerArr);
                        foreach($diffShopCustomerArr as $diffCustomerArr){
                            $diffShopCustomerRS = ShopSalesmanRs::findOne(['shop_id'=>$param->originalShopId,'salesman_id'=>$diffCustomerArr]);
                            $diffShopCustomerRS->shop_id = $param->targetShopId;
                            if(!$diffShopCustomerRS->save(false)){
                                $transaction->rollBack();
                                return false;
                            }
                        }
                    }
                }
            }

            $originalSalesmanIds = ShopSalesmanRs::find()->select('salesman_id')->where(['shop_id'=>$param->originalShopId])->asArray()->all();
            $targetSalesmanIds = ShopSalesmanRs::find()->select('salesman_id')->where(['shop_id'=>$param->targetShopId])->asArray()->all();
            if(empty($targetSalesmanIds)){
                $ShopSalesmanRS = ShopSalesmanRS::findAll(['shop_id'=>$param->originalShopId]);
                foreach($ShopSalesmanRS as $ShopSalesman){
                    $ShopSalesman->shop_id = $param->targetShopId;
                    if(!$ShopSalesman->save(false)){
                        $transaction->rollBack();
                        return false;
                    }
                }
            }else{
                if(!empty($originalSalesmanIds)){
                    foreach ($originalSalesmanIds as $originalSalesmanId) {
                        foreach ($targetSalesmanIds as $targetSalesmanId){
                            if($originalSalesmanId == $targetSalesmanId){
                                $ShopSalesmanRS = ShopSalesmanRs::findOne(['shop_id'=>$param->originalShopId,'salesman_id'=>$originalSalesmanId]);
                                if(!empty($ShopSalesmanRS)){
                                    if(!$ShopSalesmanRS->delete()){
                                        $transaction->rollBack();
                                        return false;
                                    }
                                }

                            }else if($originalSalesmanId != $targetSalesmanId && !in_array($originalSalesmanId,$targetSalesmanIds)){
                                $ShopSalesmanArr[]= $originalSalesmanId['salesman_id'];
                            }
                        }
                    }
                    if(isset($ShopSalesmanArr) && !empty($ShopSalesmanArr)){
                        $diffShopSalesmanArr = array_unique($ShopSalesmanArr);
                        foreach($diffShopSalesmanArr as $diffShopSalesman){
                            $diffShopSalesmanRS = ShopSalesmanRs::findOne(['shop_id'=>$param->originalShopId,'salesman_id'=>$diffShopSalesman]);
                            $diffShopSalesmanRS->shop_id = $param->targetShopId;
                            if(!$diffShopSalesmanRS->save(false)){
                                $transaction->rollBack();
                                return false;
                            }
                        }
                    }
                }
            }

            $originalMerchantId = Shop::find()->select('merchant_id')->where(['id'=>$param->originalShopId])->scalar();
            $targetMerchantId = Shop::find()->select('merchant_id')->where(['id'=>$param->targetShopId])->scalar();
            $originalFranchiseeSalesmans = FranchiseeSalesmanRs::findAll(['recommender_id'=>$originalMerchantId]);
            if(!empty($originalFranchiseeSalesmans)){
                foreach ($originalFranchiseeSalesmans as $originalFranchiseeSalesman){
                    $originalFranchiseeSalesman->recommender_id = $targetMerchantId;
                    if(!$originalFranchiseeSalesman->save(false)){
                             $transaction->rollBack();
                             return false;
                     }
                }
            }

            $consumptionRecords = ConsumptionRecord::findAll(['shop_id'=>$param->originalShopId]);
            $commissionRecords = CommissionRecord::findAll(['shop_id'=>$param->originalShopId]);
            if(!empty($consumptionRecords) && !empty($commissionRecords)){
              foreach($consumptionRecords as $consumptionRecord){
                  $consumptionRecord->shop_id = $param->targetShopId;
                  if(!$consumptionRecord->save(false)){
                      $transaction->rollBack();
                      return false;
                  }
              }
                foreach($commissionRecords as $commissionRecord){
                    $commissionRecord->shop_id = $param->targetShopId;
                    if(!$commissionRecord->save(false)){
                        $transaction->rollBack();
                        return false;
                    }
                }
            }
            $transaction->commit();
            return true;
        }else{
            return false;
        }
    }

    protected static function gerSalesmanTransfer($param){
         if($param->validate()){
             return true;
         }else{
             return false;
         }
    }
}