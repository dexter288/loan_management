<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_id',
        'loan_type_id',
        'loan_status',
        'principal_amount',
        'loan_release_date',
        'loan_duration',
        'duration_period',
        'transaction_reference',
        'borrower_id',
        'loan_type_id',
    ];

    public function loan_type()
    {

        return $this->belongsTo(LoanType::class, 'loan_type_id','id');
    }

    public function borrower()
    {

        return $this->belongsTo(Borrower::class, 'borrower_id','id');
    }

    public function getLoanDueDateAttribute($value) {
        return date('d,F Y', strtotime($value));
    }


    protected $casts = [
        'activate_loan_agreement_form' => 'boolean',
    ];


}
