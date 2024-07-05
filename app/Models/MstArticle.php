<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstArticle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getArticleType()
    {
        return [
            '1' => 'Car',
            '2' => 'Home Loan',
            '3' => 'Loan Against Property',
            '4' => 'Home OverDraft'
        ];
    }

    public function getArticleTypeName($id)
    {
        $articlesArray = self::getArticleType();
        return $articlesArray[$id] ?? '';
    }
}
