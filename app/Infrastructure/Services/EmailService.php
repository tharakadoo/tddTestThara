<?php

namespace App\Infrastructure\Services;

use App\Mail\PostPublishedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use WebsitePost\Contracts\EmailServiceContract;

class EmailService implements EmailServiceContract
{
    public function send(array $data): bool
    {
        try {
            Mail::to($data['to'])->queue(new PostPublishedMail($data['post'] ?? null));
            return true;
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
