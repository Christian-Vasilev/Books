<?php


namespace App\Libraries;


class ValidateRequest
{
    public static function validate($fields)
    {
        $validated = [];

        foreach ($fields as $field => $rules) {
            $validated[$field] = !in_array(false, $rules);
        }

        self::flash($validated);

        return !in_array(false, $validated);
    }

    /**
     * Creates flash messages and inputs for the given fields
     *
     * @param $fields
     */
    private static function flash($fields)
    {
        if (in_array(false, $fields)) {
            foreach ($fields as $field => $passes) {
                if (!$passes) {
                    FlashMessage::create($field, "The {$field} has invalid input");
                } else {
                    $value = isset($_POST[$field]) ? $_POST[$field] : '';

                    FlashInputValues::create($field, $value);
                }
            }
        }
    }
}