<?php

namespace App\Service;

class UploadUsersCsvLoader
{
    private const ACCEPTED_CONTACT_HEADER_VALUES = [
        "Email Address" => "email",
        "First Name" => "first_name",
        "Last Name" => "last_name",
        "Subscribed? Yes/No" => "subscribed",
        "Unsubscribed Date" => "unsubscribed_at"
    ];

    public function __invoke(array $userArray)
    {
        $validatedUserArray = $this->validateValues($userArray);
        return $validatedUserArray;
    }

    public function validateValues(array $userArray): array
    {
        $validatedUserArray = [];

        foreach ($userArray as $userRowKey => $userRowValue) {
            foreach ($userRowValue as $userColumnKey => $userColumnValue) {
                if (array_key_exists($userColumnKey, self::ACCEPTED_CONTACT_HEADER_VALUES)) {
                    $validatedUserArray[$userRowKey][self::ACCEPTED_CONTACT_HEADER_VALUES[$userColumnKey]] = $userColumnValue;
                }
            }
        }

        return $validatedUserArray;
    }
}
