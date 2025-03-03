<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('category');
        

        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $id, // {{ ignore thr current name on update  }}
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,archived',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The category name must be unique.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2MB.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either "active" or "archived".',
            'parent_id.exists' => 'The selected parent category does not exist.',
        ];
    }
}
