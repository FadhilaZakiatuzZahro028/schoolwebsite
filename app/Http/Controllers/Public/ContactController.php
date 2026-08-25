<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('public.contact.index');
    }

    public function store(
        StoreContactMessageRequest $request,
    ): RedirectResponse {
        $validated = $request->validated();

        ContactMessage::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'is_read' => false,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('contact.index')
            ->with(
                'success',
                'Pesan berhasil dikirim. Pihak sekolah akan menindaklanjutinya secepat mungkin.',
            );
    }
}