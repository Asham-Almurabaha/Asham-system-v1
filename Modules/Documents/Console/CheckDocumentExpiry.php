<?php

namespace Modules\Documents\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Modules\Documents\Models\Document;
use Modules\Documents\Notifications\DocumentExpiring;

class CheckDocumentExpiry extends Command
{
    protected $signature = 'hr:check-document-expiry {--window=60}';
    protected $description = 'Check documents expiring within given window and notify';

    public function handle(): int
    {
        $window = (int) $this->option('window');
        $documents = Document::expiringWithin($window)->get();
        foreach ($documents as $doc) {
            $days = $doc->days_left;
            if (in_array($days, [60,30,15,7,1], true)) {
                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    try {
                        $users = \Spatie\Permission\Models\Role::findByName('HR Admin')->users;
                        Notification::send($users, new DocumentExpiring($doc, $days));
                    } catch (\Throwable $e) {
                        $this->warn('HR Admin role not found');
                    }
                } else {
                    $this->warn('TODO: configure notification channels');
                }
            }
        }
        $this->info('Checked '.count($documents).' documents');
        return self::SUCCESS;
    }
}
