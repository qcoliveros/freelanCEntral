<?php

namespace App\Traits;

use App\Models\Parameter\MessengerType;
use App\Models\Parameter\PhoneType;

trait HasContacts
{
    public function phoneType()
    {
        return $this->hasOne(PhoneType::class, 'id', 'phone_type_id');
    }

    public function messengerType()
    {
        return $this->hasOne(MessengerType::class, 'id', 'messenger_type_id');
    }
}
