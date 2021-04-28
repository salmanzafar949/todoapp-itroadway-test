<?php

namespace App\Http\Requests;

use App\Models\Todo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        switch ($this->method())
        {
            case "POST":
                return [
                    'user_id' => ['required', 'exists:users,id'],
                    'title' => ['required', 'string', 'min:4', 'max:20'],
                    'description' => ['required', 'string', 'max:500'],
                    'isCompleted' => ['boolean']
                ];
            case "PUT":
            case "PATCH":
            return [
                'title' => ['string', 'min:4', 'max:20'],
                'description' => ['string', 'max:500'],
                'isCompleted' => ['boolean']
            ];
        }
    }

    public function store()
    {
        $todo = Todo::create($this->validated());

        return response([
            'data' => $todo,
        ],Response::HTTP_CREATED);
    }

    public function update($todo)
    {
        $todo = Todo::findOrFail($todo);

        $todo->update($this->validated());

        return \response([
            'data' => $todo,
        ],Response::HTTP_OK);
    }
}
