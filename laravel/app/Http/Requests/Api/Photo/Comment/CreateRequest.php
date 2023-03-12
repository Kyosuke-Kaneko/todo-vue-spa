<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Photo\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'max:500']
        ];
    }
}
