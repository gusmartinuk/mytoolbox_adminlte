<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Note;

class NoteCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_note()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/notes', [
            'title' => 'First Note',
            'content' => '<p>This is a note with HTML content.</p>',
            'tags' => 'laravel,php',
        ]);

        $this->assertDatabaseHas('notes', ['title' => 'First Note']);
    }

    /** @test */
    public function a_user_can_update_a_note()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->put("/notes/{$note->id}", [
            'title' => 'Updated Title',
            'content' => '<p>Updated HTML content.</p>',
            'tags' => 'updated,tag',
        ]);

        $this->assertDatabaseHas('notes', ['title' => 'Updated Title']);
    }

    /** @test */
    public function a_user_can_delete_a_note()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->delete("/notes/{$note->id}");

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }
}
