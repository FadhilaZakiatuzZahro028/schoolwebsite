<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatbotReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'string',
                'min:2',
                'max:500',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Pertanyaan wajib diisi.',
            'message.string' => 'Pertanyaan harus berupa teks.',
            'message.min' => 'Pertanyaan minimal 2 karakter.',
            'message.max' => 'Pertanyaan maksimal 500 karakter.',
        ];
    }
}