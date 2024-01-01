<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
  /**
   * A basic test example.
   */
  use RefreshDatabase;
  public function test_user_can_store_contact(): void
  {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $contact = Contact::factory()->makeOne([
        'phone_number' => '123456789',
        'user_id' => $user->id
    ]);
    $response = $this->actingAs($user)->post(route('contacts.store'), $contact->getAttributes());
    $response->assertRedirect(route('home'));
    //$this->assertDatabaseCount('contacts',1);
    $this->assertDatabaseHas('contacts', [
        'user_id' => $user->id,
        'phone_number' => '123456789',
        'name' => $contact->name,
        'email' => $contact->email,
        'age' => $contact->age,
    ]);
  }

  public function test_user_cant_store_contact(): void
  {
    $user = User::factory()->create();
    $contact = Contact::factory()->makeOne([
        'phone_number' => 'wrong',
        'name' => null,
        'email' => 'wrong',
        'age' => 'wrong',
    ]);
    $response = $this->actingAs($user)->post(route('contacts.store'), $contact->getAttributes());
    $response->assertSessionHasErrors(['phone_number', 'name', 'email', 'age']);
    $this->assertDatabaseCount('contacts', 0);
  }

  /**
   * @depends test_user_can_store_contact
   * @depends test_user_cant_store_contact
   */
  public function test_only_owner_can_update_and_delete_contact(): void
  {
    [$owner, $notOwner] = User::factory(2)->create();
    $contact = Contact::factory()->createOne([
        'phone_number' => '123456789',
        'user_id' => $owner->id
    ]);
    $response = $this->actingAs($notOwner)
        ->put(route('contacts.update', $contact->id),$contact->getAttributes());
    $response->assertForbidden();

    $response = $this->actingAs($notOwner)
        ->delete(route('contacts.destroy', $contact->id),$contact->getAttributes());
    $response->assertForbidden();
  }
}
