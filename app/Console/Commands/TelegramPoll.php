<?php

namespace App\Console\Commands;

use App\Bot\Handler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Factory as HttpClient;

class TelegramPoll extends Command
{
    protected $signature = 'telegram:poll';
    protected $description = 'Poll Telegram updates and reply to commands';

    protected string $botToken;
    protected string $apiUrl;
    protected string $offsetFile = 'telegram_offset.txt';


    public function __construct(protected Handler $handler, private httpClient $http)
    {
        parent::__construct();

        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function handle()
    {
        while (true) {
            $offset = $this->getOffset();
    
            $response = $this->http->withoutVerifying()->get("{$this->apiUrl}/getUpdates", [
                'timeout' => 30,
                'offset' => $offset,
            ]);        
    
            $updates = $response->json('result') ?? [];
    
            foreach ($updates as $update) {
                $updateId = $update['update_id'];
                $message = $update['message'] ?? null;
    
                if (!$message) continue;
    
                $chatId = $message['chat']['id'];
                $text = $message['text'] ?? '';
                
                $reply = $this->handler->handle($text);
                Log::info("Replying to chat ID {$chatId} with message: {$reply}");
                $this->sendMessage($chatId, $reply);
    
                $this->setOffset($updateId + 1);
            }
    
            sleep(1); // Wait 1 second before next poll
        }
    
    }

    private function sendMessage(int $chatId, string $text): void
    {
        Http::withoutVerifying()->post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }

    private function getOffset(): int
    {
        $path = storage_path($this->offsetFile);
        return file_exists($path) ? (int)file_get_contents($path) : 0;
    }

    private function setOffset(int $offset): void
    {
        file_put_contents(storage_path($this->offsetFile), $offset);
    }
}
