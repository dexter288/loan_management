<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_name',
        'interest_rate',
        'interest_cycle',
    ];

    public function loan()
    {
    return $this->hasMany(Loan::class, 'id','loan_type_id');
    }
}
