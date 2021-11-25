<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UserRegistrationRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'language_proficiency' => json_decode($this->language_proficiency, true),
            'educations' => json_decode($this->educations, true),
            'trainings' => json_decode($this->trainings, true),
        ]);
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:registered_users',
            'division' => 'required',
            'district' => 'required',
            'upazila' => 'required',
            'address_line' => 'required',
            'language_proficiency' => 'required',

            'educations' => 'required',
            'educations.*.id' => 'required',
            'educations.*.exam' => 'required',
            'educations.*.university' => 'required',
            'educations.*.board' => 'required',
            'educations.*.result' => 'required',

            'trainings' => 'required_if:trainings,id,name,details',
            'trainings.*.id' => 'required_with:trainings',
            'trainings.*.name' => 'required_with:trainings.*.id',
            'trainings.*.details' => 'required_with:trainings.*.name',

            'profile_image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'cv_attachment' => 'required|mimes:pdf,docx',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
