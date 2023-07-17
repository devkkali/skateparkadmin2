<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterMembershipUserRequest extends FormRequest
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
            'card_id' => 'required|unique_normal_cards|unique_membership_user_card|unique_package_user_card',
            'membership_type_id' => 'required|exists:membership_types,id',
            'name' => 'required',
            'phone_no' => 'required',
            'paid' => 'required',
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

    public function messages()
    {
        return [
            'card_id.unique_normal_cards' => 'The card id has already been taken in Normal Cards',
            'card_id.unique_membership_user_card'=>'The card id has already been taken in Membership',
            'card_id.unique_package_user_card'=>'The card id has already been taken in Package',
        ];
    }
}
