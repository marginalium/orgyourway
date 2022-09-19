<?php

namespace App\Service;

class UploadTicketsCsvLoader
{
    private const ACCEPTED_TICKET_HEADER_VALUES = [
        "Order ID" => "ticket.external_ticket_id",
        "Date" => "ticket.purchased_at",
        "Gross Revenue (USD)" => "ticket.gross_revenue_in_cents",
        "Ticket Revenue (USD)" => "ticket.ticket_revenue_in_cents",
        "Eventbrite Fees (USD)" => "ticket.third_party_fees_in_cents",
        "Eventbrite Payment Processing (USD)" => "ticket.third_party_payment_processing_in_cents",
        "Tax on Eventbrite Fees (USD)" => "ticket.tax_in_cents",
        "Tickets" => "ticket.quantity",
        "Type" => "ticket.payment_type",
        "Status" => "ticket.payment_status",
        "Delivery Method" => "ticket.delivery_method",
        "First Name" => "user.first_name",
        "Last Name" => "user.last_name",
        "Email Address" => "user.email",
        "Event Name" => "event.name",
        "Venue Name" => "event.venue_name",
        "Venue ID" => "event.external_venue_id"
    ];

    public function __invoke(array $ticketArray): array
    {
        return $this->validateValues($ticketArray);
    }

    /**
     * @param array $ticketArray
     * @return array
     *
     * TODO: Move this out to an EventBriteProvider class to make it adaptable to other ticketing systems in the future.
     */
    public function validateValues(array $ticketArray): array
    {
        $validatedTicketArray = [];

        foreach ($ticketArray as $ticketRowKey => $ticketRowValue) {
            foreach ($ticketRowValue as $ticketColumnKey => $ticketColumnValue) {
                if (array_key_exists($ticketColumnKey, self::ACCEPTED_TICKET_HEADER_VALUES)) {
                    $keyValuePair = explode('.', self::ACCEPTED_TICKET_HEADER_VALUES[$ticketColumnKey]);
                    $validatedTicketArray[$ticketRowKey][$keyValuePair[0]][$keyValuePair[1]] = $ticketColumnValue;
                }
            }
        }

        return $validatedTicketArray;
    }
}
