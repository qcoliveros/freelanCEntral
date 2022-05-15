<?php

namespace App\Actions\GigHost;

use App\Contracts\GigHost\ManagesGigPlaybook;
use App\Models\GigPlaybook;
use App\Models\GigPlaybookContract;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ManageGigPlaybook implements ManagesGigPlaybook
{
    public function saveContract(array $input)
    {
        $this->validateContract($input);

        GigPlaybookContract::find($input['contract_id'])->update($input);
    }

    public function sendContract(array $input)
    {
        $this->validateContract($input);

        GigPlaybookContract::find($input['contract_id'])->update([
            'clause' => $input['clause'],
            'status' => 'Pending'
        ]);
    }

    public function rejectContract(array $input)
    {
        GigPlaybookContract::find($input['contract_id'])->update([
            'status' => 'Rejected'
        ]);

        GigPlaybook::find($input['id'])->update([
            'status' => 'Contract Rejected'
        ]);
    }

    public function acceptContract(array $input)
    {
        GigPlaybookContract::find($input['contract_id'])->update([
            'status' => 'Accepted',
            'signed_date' => Date::now(),
        ]);

        GigPlaybook::find($input['id'])->update([
            'status' => 'Contract Accepted'
        ]);
    }

    private function validateContract(array $input)
    {
        $customAttributes = array(
            'clause' => 'contract',
        );

        Validator::make($input, [
            'clause' => ['required', 'string', 'max:4096'],
        ], [], $customAttributes)->validateWithBag('gigContractError');
    }
}
