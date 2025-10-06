<?php

namespace App\WebsitePost\IO\Http;

use App\WebsitePost\Entities\Website;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\WebsitePost\UseCases\AttachUsersToWebsiteUseCase;
use Illuminate\Validation\ValidationException;

class WebsiteController extends Controller
{
    private AttachUsersToWebsiteUseCase $attachUsersUseCase;

    public function __construct(AttachUsersToWebsiteUseCase $attachUsersUseCase)
    {
        $this->attachUsersUseCase = $attachUsersUseCase;
    }

    public function attachUsers(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'website'    => 'required|int',
                'user_ids'   => 'required|array',
                'user_ids.*' => 'integer|exists:users,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        $website = Website::findOrFail($data['website']);

        $this->attachUsersUseCase->execute($website, $data['user_ids']);

        return response()->json([
            'success' => true,
            'message' => 'Users subscribed successfully'
        ]);
    }

    public function index(): JsonResponse
    {
        $websites = Website::select('id', 'url')->get();

        return response()->json($websites, 200);
    }
}
