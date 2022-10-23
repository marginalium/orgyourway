<?php

namespace App\Service;

class UploadUsersCsvLoader
{
    private const ACCEPTED_CONTACT_HEADER_VALUES = [
        "Email Address" => "email",
        "First Name" => "first_name",
        "Last Name" => "last_name",
        "Subscribed? Yes/No" => "is_subscribed",
        "Unsubscribed Date" => "unsubscribed_at"
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
                if (array_key_exists($userColumnKey, self::ACCEPTED_CONTACT_HEADER_VALUES)) {
                    $keyValuePair = explode('.', self::ACCEPTED_CONTACT_HEADER_VALUES[$userColumnKey]);
                    $validatedUserArray[$userRowKey][$keyValuePair[0]] = $userColumnValue;
                }
            }
        }

        return $validatedUserArray;
    }
}
