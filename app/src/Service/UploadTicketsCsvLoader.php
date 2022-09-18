<?php

namespace App\Service;

class UploadTicketsCsvLoader
{
    private const ACCEPTED_TICKET_HEADER_VALUES = [
        "Order ID" => "external_ticket_id",
        "Date" => "purchased_at",
        "Venue Name" => "venue_name",
        "Venue ID" => "external_venue_id",
        "Gross Revenue (USD)" => "gross_revenue_in_cents",
        "Ticket Revenue (USD)" => "ticket_venue_in_cents",
        "Eventbrite Fees (USD)" => "third_party_fees_in_cents",
        "Eventbrite Payment Processing (USD)" => "third_party_payment_processing_in_cents",
        "Tax on Eventbrite Fees (USD)" => "tax_in_cents",
        "Tickets" => "quantity",
        "Type" => "payment_type",
        "Status" => "payment_status",
        "Delivery Method" => "delivery_method",
    ];

    private const ACCEPTED_USER_HEADER_VALUES = [
        "First Name" => "user.first_name",
        "Last Name" => "user.last_name",
        "Email Address" => "user.email"
    ];

    private const ACCEPTED_EVENT_HEADER_VALUES = [
        "Event Name" => "event.name",
    ];

    public function __invoke(array $userArray): array
    {
        return $this->validateValues($userArray);
    }

    /**
     * @param array $userArray
     * @return array
     *
     * TODO: Move this out to an EventBriteProvider class to make it adaptable to other ticketing systems in the future.
     */
    public function validateValues(array $userArray): array
    {
        $validatedUserArray = [];

        foreach ($userArray as $userRowKey => $userRowValue) {
            foreach ($userRowValue as $userColumnKey => $userColumnValue) {
                if (array_key_exists($userColumnKey, self::ACCEPTED_TICKET_HEADER_VALUES)) {
                    $validatedUserArray[$userRowKey][self::ACCEPTED_TICKET_HEADER_VALUES[$userColumnKey]] = $userColumnValue;
                }
            }
        }

        return $validatedUserArray;
    }
}
