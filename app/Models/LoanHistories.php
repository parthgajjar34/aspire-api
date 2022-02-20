<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanHistories extends Model
{
    protected $fillable = [
        'loan_id', 'duration', 'amount_paid', 'paid_date', 'remaining_balance'
    ];

    protected $hidden = [];
}
