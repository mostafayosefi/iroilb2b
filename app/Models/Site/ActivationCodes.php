<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActivationCodes extends Model
{
    use HasFactory;

    protected $table = 'app_activation_codes';
    protected $fillable = ['user_id', 'email_code', 'phone_code'];

    public function scopeCreateCode($query, $user, $phoneCode, $emailCode)
    {
        $check = DB::table($this->table)->where('user_id', $user->id)->first();
        if ($check == null) {
            return $query->create([
                'user_id' => $user->id,
                'email_code' => $emailCode,
                'phone_code' => $phoneCode
            ]);
        } else {
            DB::table($this->table)
                ->where('user_id', $user->id)
                ->update([
                    'email_code' => $emailCode,
                    'phone_code' => $phoneCode
                ]);
            return true;
        }

    }

}
