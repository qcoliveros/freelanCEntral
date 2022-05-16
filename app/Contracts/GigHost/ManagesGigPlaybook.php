<?php

namespace App\Contracts\GigHost;

interface ManagesGigPlaybook
{
    public function saveContract(array $input);

    public function sendContract(array $input);

    public function rejectContract(array $input);

    public function acceptContract(array $input);

    public function saveTask(array $input);

    public function deleteTask(array $input);

    public function submitTasks(array $input);

    public function startTask(array $input);

    public function holdTask(array $input);

    public function completeTask(array $input);

    public function closeTask(array $input);

    public function publishComment($user, array $input);
}
