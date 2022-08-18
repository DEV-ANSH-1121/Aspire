<?php

namespace App\Models\Loan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Loan\LoanRepayment;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_amount',
        'loan_term',
        'payment_frequency',
        'left_term',
        'status',
    ];

    /**
     * Different Status Of Loan.
     *
     * @var array<int, string>
     */
    public static $status = [
        1 => 'Active',
        2 => 'Paid',
        3 => 'Waiting For Approval',
        4 => 'Declined',
    ];

    /**
     * Different Payment Frequency Of Loan.
     *
     * @var array<int, string>
     */
    public static $paymentFreq = [
        1 => 'Weekly',
        2 => 'Monthly',
        3 => 'Quaterly',
        4 => 'Half Yearly',
    ];

    /**
     * Get the User that owns the Loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Repayments for Loan.
     */
    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    /**
     * Get Status id by Value.
     */
    public static function getStatusIdByValue($statusValue)
    {
        return array_search($statusValue, self::$status);
    }

    public static function getStatusKeys()
    {
        return array_keys(self::$status);
    }

    /**
     * Get Loan Freq id by Value.
     */
    public static function getPaymentFreqIdByValue($statusValue)
    {
        return array_search($statusValue, self::$paymentFreq);
    }

    public static function getPaymentFreqKeys()
    {
        return array_keys(self::$paymentFreq);
    }
}
