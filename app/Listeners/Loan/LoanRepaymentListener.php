<?php

namespace App\Listeners\Loan;

use App\Events\Loan\LoanRepayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Loan\Loan;

class LoanRepaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Loan\LoanRepayment  $event
     * @return void
     */
    public function handle(LoanRepayment $event)
    {
        $loan = $event->loan;
        $loanRepayment = $loan->repayments;
        $totalPaid = $loanRepayment->sum('amount_paid');
        if($totalPaid >= $loan->loan_amount){
            $leftTerm = 0;
            $status = Loan::getStatusIdByValue('Paid');
        }else{
            $leftTerm = $loan->left_term - 1;
            if ($leftTerm == 0) {
                $status = Loan::getStatusIdByValue('Paid');
            }else{
                $status = Loan::getStatusIdByValue('Active');
            }
        }

        $loan->update([
            'left_term' => $leftTerm,
            'status' => $status
        ]);
    }
}
