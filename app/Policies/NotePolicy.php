<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;

class NotePolicy
{
    /**
     * Kullanıcı yalnızca kendi notlarını düzenleyebilir.
     */
    public function update(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }

    /**
     * Kullanıcı yalnızca kendi notlarını silebilir.
     */
    public function delete(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }
}
