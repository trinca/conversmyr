<?php

return [

    'user_model' => App\User::class,

    'message_model' => Convmyr\Conversation\Models\ConversationMessage::class,

    'participant_model' => Convmyr\Conversation\Models\ConversationParticipant::class,

    'thread_model' => Convmyr\Conversation\Models\ConversationThread::class,

    /**
     * Define custom database table names.
     */
    'conversation_messages_table' => null,

    'conversation_participants_table' => null,

    'conversation_threads_table' => null,
];
