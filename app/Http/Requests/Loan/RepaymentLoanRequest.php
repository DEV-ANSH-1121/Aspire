<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
 use Illuminate\Contracts\Validation\Validator;
 use Illuminate\Http\Exceptions\HttpResponseException;

class RepaymentLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'loan_id' => 'required|exists:loans',
            'amount_paid' => 'required'
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return  void
     *
     * @throws  \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
