<?php

namespace App\Service;

class UploadTicketsCsvLoader
{
    private const ACCEPTED_CONTACT_HEADER_VALUES = [
        "Order ID" => "external_ticket_id",
        "Date" => "purchased_at",

    ];
}