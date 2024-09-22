<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class MyNotesMenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function my_notes_menu_item_is_visible_for_authenticated_users()
    {
        // Oturum açmış bir kullanıcı oluştur
        $user = User::factory()->create();

        // Kullanıcı oturum açmış durumda /notes rotasına erişmeli ve "My Notes" öğesini görmeli
        $this->actingAs($user)
             ->get('/notes')
             ->assertSee('My Notes');
    }
}
