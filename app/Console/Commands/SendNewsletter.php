<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendNewsletter extends Command
{
    protected $signature = 'newsletter:send {content}';

    protected $description = 'Send newsletters to all subscribers';

    public function handle()
    {
        $content = $this->argument('content');
        $subscribers = NewsletterSubscriber::where('is_subscribed', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterMail($content));
        }

        $this->info('Newsletter sent successfully!');
    }
}
