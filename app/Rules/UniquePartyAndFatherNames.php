<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use App\Models\MstParty;

// class UniquePartyAndFatherNames implements ValidationRule
class UniquePartyAndFatherNames implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
//
    }

    public function passes($attribute, $value)
    {
        $data = request()->all();

        if (isset($data['party_name']) && isset($data['father_name'])) {
            $exists = MstParty::where('party_name', $data['party_name'])
                            ->where('father_name', '!=', $data['father_name'])
                            ->exists();

            return !$exists;
        }

        return true;
    }

    public function message()
    {
        return 'The  party name with same  father name already exists.';
    }


}
