<?php

namespace App\WebsitePost\UseCases;

use App\WebsitePost\Entities\Website;

class AttachUsersToWebsiteUseCase
{
    /**
     * Attach users to a website
     *
     * @param Website $website
     * @param array $userIds
     * @return void
     */
    public function execute(Website $website, array $userIds): void
    {
        $website->users()->syncWithoutDetaching($userIds);
    }
}
