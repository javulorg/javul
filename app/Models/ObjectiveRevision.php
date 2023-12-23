<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ObjectiveRevision extends Model
{
    public $timestamps = false;

    protected $table = 'objective_revisions';

    protected $fillable = ['user_id'];

    public static function strBytes($str)
    {
        $strlen_var = strlen($str);
        $d = 0;
        for($c = 0; $c < $strlen_var; ++$c){
            $ord_var_c = ord($str[$c]);
            switch(true){
                case(($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
                $d++;
                break;
                case(($ord_var_c & 0xE0) == 0xC0):
                    $d+=2;
                break;
                case(($ord_var_c & 0xF0) == 0xE0):
                    $d+=3;
                break;
                case(($ord_var_c & 0xF8) == 0xF0):
                    $d+=4;
                break;
                case(($ord_var_c & 0xFC) == 0xF8):
                    $d+=5;
                break;
                case(($ord_var_c & 0xFE) == 0xFC):
                    $d+=6;
                break;
                default:
                    $d++;
            };
        };
        return $d;
    }
}