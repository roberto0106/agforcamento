<?php

namespace App\Models;

class Config
{

    public static function getMonthOfConclusion()
    {
        return [
            7 => '(20.1) - 1º SEMESTRE',
            12 => '(20.2) - 2º SEMESTRE'
        ];
    }

    public static function getConclusionYear()
    {
        $start = 2020;
        $end = date('Y') + 8;
        $return = [];

        for ($i = $start; $i <= $end; $i++){
            $return[$i] = $i;
        }

        return $return;
    }

    public static function yesNo()
    {
        return [
            0 => "Não",
            1 => "Sim",
        ];
    }

    public static function status()
    {
        return [
            0 => "Inativo",
            1 => "Ativo",
        ];
    }

}
