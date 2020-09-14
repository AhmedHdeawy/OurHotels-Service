<?php
namespace App\NotificationService;

interface Service
{
    public function send($data): string;

}
