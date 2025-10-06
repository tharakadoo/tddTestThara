<?php

namespace WebsitePost\Contracts;

interface EmailServiceContract
{
    /**
     * Send an email.
     *
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool;
}
