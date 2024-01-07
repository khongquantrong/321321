<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $tableName = (new Category())->getTable();
        $id = request()->segment('2');

        return [
            'name' => [
                'required', 'string', 'max:50',
                Rule::unique($tableName)->ignore($id),
            ],
            'describe' => ['nullable', 'string', 'max:200']
        ];
    }
}
