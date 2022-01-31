<?php

namespace common\components;

use Yii;
use yii\base\Component;

class AppHelper extends Component
{
    public function terbilang(int $nilai)
    {
        $hasil = new \NumberFormatter('id-ID', \NumberFormatter::SPELLOUT);
        return sprintf('%s Rupiah', $hasil->format($nilai));
    }

    public function formatCurrency($nilai)
    {
        // $number = number_format($nilai, 0, ',', '.');
        
        // return sprintf('Rp. %s,-', $number);
        // return Yii::$app->numberFormatter->format("Rp ###,###,###", $nilai);
        return Yii::$app->formatter->asCurrency($nilai);
    }
}
