<?php

namespace Convmyr\Conversation;

use Convmyr\Conversation\Models\ConversationMessage;
use Convmyr\Conversation\Models\ConversationModels;
use Convmyr\Conversation\Models\ConversationParticipant;
use Convmyr\Conversation\Models\ConversationThread;
use Illuminate\Support\ServiceProvider;

class ConversationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            base_path('vendor/conversmyr/conversation/src/config/config.php') => config_path('conversation.php'),
            base_path('vendor/conversmyr/conversation/src/migrations') => base_path('database/migrations'),
        ]);

        $this->setConversationModels();
        $this->setUserModel();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            base_path('vendor/conversmyr/conversation/src/config/config.php'), 'conversation'
        );
    }

    private function setConversationModels()
    {
        $config = $this->app->make('config');

        ConversationModels::setMessageModel($config->get('conversation.message_model', ConversationMessage::class));
        ConversationModels::setThreadModel($config->get('conversation.thread_model', ConversationThread::class));
        ConversationModels::setParticipantModel($config->get('conversation.participant_model', ConversationParticipant::class));

        ConversationModels::setTables([
            'messages' => $config->get('conversation.messages_table', ConversationModels::message()->getTable()),
            'participants' => $config->get('conversation.participants_table', ConversationModels::participant()->getTable()),
            'threads' => $config->get('conversation.threads_table', ConversationModels::thread()->getTable()),
        ]);
    }

    private function setUserModel()
    {
        $config = $this->app->make('config');

        $model = $config->get('auth.providers.users.model', function () use ($config) {
            return $config->get('auth.model', $config->get('messenger.user_model'));
        });

        ConversationModels::setUserModel($model);

        ConversationModels::setTables([
            'users' => (new $model)->getTable(),
        ]);
    }
}
