<?php

namespace Mannysoft\StoreReceiptValidator\Models;

use Illuminate\Database\Eloquent\Model;
use App\libs\Stats;

class ReceiptLog extends Model
{
    use Stats;

    protected $table = 'receipts_logs';
    
    protected $fillable = ['user_id', 'content', 'platform'];
}
