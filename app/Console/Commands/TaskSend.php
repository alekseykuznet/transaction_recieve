<?php

namespace App\Console\Commands;

use App\Models\TaskRpc;
use App\Models\Transaction;
use Illuminate\Console\Command;

class TaskSend extends Command
{
    /**
     * @var string
     */
    protected $signature = 'task:send';

    /**
     * @var string
     */
    protected $description = 'send transactions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Start send');

        $taskRpcs = TaskRpc::where('send', TaskRpc::STATUS_NOT_SEND)
            ->get();

        foreach ($taskRpcs as $taskRpc) {

        }

        $this->info('End');
    }
}
