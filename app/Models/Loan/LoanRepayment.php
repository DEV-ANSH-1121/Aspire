<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan\Loan;

class LoanRepayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_date',
        'schedule_amount',
        'amount_paid_on',
        'amount_paid',
        'status',
    ];

    /**
     * Get the User that owns the Loan.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
