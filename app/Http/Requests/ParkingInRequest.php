<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ParkingInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required',
            // 'phone_no' => '',
            // 'deposit' => 'required',
            // 'in_time' => 'required',
            // 'paid_amount' => 'required',
            // 'sock_cost_at_time' => 'required',
            // 'socks' => '',
            // 'water_cost_at_time' => 'required',
            // 'water' => 'required',
            // 'no_of_client' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'error' => 'true',
            'message' => 'Invalid data sent',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
