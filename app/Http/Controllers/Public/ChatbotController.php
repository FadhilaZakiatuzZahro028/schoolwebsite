<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatbotReplyRequest;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    public function reply(
        ChatbotReplyRequest $request,
        ChatbotService $chatbotService,
    ): JsonResponse {
        return response()->json([
            'answer' => $chatbotService->answer(
                $request->validated('message'),
            ),
        ]);
    }
}