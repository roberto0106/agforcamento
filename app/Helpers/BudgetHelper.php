<?php
/**
 * Created by PhpStorm.
 * User: leona
 * Date: 05/03/2018
 * Time: 12:18
 */

namespace App\Helpers;


class BudgetHelper
{
    public static function parcelsNum($max){
        for ($i=1;$i<=$max;$i++){
            $parcelas[$i] = $i;
        }
        return $parcelas;
    }
}