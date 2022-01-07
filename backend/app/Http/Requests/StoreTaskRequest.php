<?php

namespace App\Http\Requests;

use App\Http\Dtos\Task\TaskDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required', 'min:5', 'max:100'],
            'description' => ['nullable', 'max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please provide a title!',
            'title.min' => 'Title must be at least 5 characters!',
            'title.max' => 'Title must not exceed 100 characters!',

            'description.max' => 'Description must not exceed 1000 characters',
        ];
    }

    public function getTaskDto(): TaskDto
    {
        return new TaskDto(
            title: $this->title,
            description: $this->description,
        );
    }
}
