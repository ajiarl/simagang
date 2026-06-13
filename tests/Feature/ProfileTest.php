<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the roles and default users
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test that guests cannot access the profile page.
     */
    public function test_guest_cannot_access_profile(): void
    {
        $this->get(route('profile.edit'))
            ->assertRedirect(route('login'));

        $this->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
        ])->assertRedirect(route('login'));

        $this->patch(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertRedirect(route('login'));
    }

    /**
     * Test that an authenticated user can access their profile page.
     */
    public function test_authenticated_user_can_access_profile_page(): void
    {
        $user = User::where('email', 'mhs1@simagang.test')->first();

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    /**
     * Test profile information update validation and success.
     */
    public function test_profile_info_update(): void
    {
        $user = User::where('email', 'mhs1@simagang.test')->first();

        // 1. Success update
        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => 'Budi Pratama Updated',
                'email' => 'mhs1_updated@simagang.test',
                'phone' => '08211111111',
                'nim' => '2024001001',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Profil berhasil diperbarui.');

        $user->refresh();
        $this->assertEquals('Budi Pratama Updated', $user->name);
        $this->assertEquals('mhs1_updated@simagang.test', $user->email);

        // 2. Validation error: email empty
        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => 'Budi Pratama Updated',
                'email' => '',
            ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test password update validation and success.
     */
    public function test_password_update_success(): void
    {
        $user = User::where('email', 'mhs1@simagang.test')->first();

        $response = $this->actingAs($user)
            ->patch(route('profile.password'), [
                'current_password' => 'password',
                'password' => 'newsecurepwd123',
                'password_confirmation' => 'newsecurepwd123',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Password berhasil diubah.');

        $user->refresh();
        $this->assertTrue(Hash::check('newsecurepwd123', $user->password));
    }

    /**
     * Test that current_password is required but does NOT have a min:8 rule.
     */
    public function test_current_password_has_no_min_rule(): void
    {
        // Set user password to a short password (e.g. 'abc') to verify we can use short password without validation errors
        $user = User::where('email', 'mhs1@simagang.test')->first();
        $user->update([
            'password' => Hash::make('abc')
        ]);

        // Try updating with the correct current password (which is 3 chars long, < 8 chars)
        $response = $this->actingAs($user)
            ->patch(route('profile.password'), [
                'current_password' => 'abc',
                'password' => 'newsecurepwd123',
                'password_confirmation' => 'newsecurepwd123',
            ]);

        // It should succeed (redirect without error) because 'abc' doesn't trigger a min:8 validation error on current_password
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Password berhasil diubah.');

        $user->refresh();
        $this->assertTrue(Hash::check('newsecurepwd123', $user->password));
    }

    /**
     * Test password update validation errors.
     */
    public function test_password_update_validation_errors(): void
    {
        $user = User::where('email', 'mhs1@simagang.test')->first();

        // 1. Wrong current password
        $response = $this->actingAs($user)
            ->patch(route('profile.password'), [
                'current_password' => 'wrongpassword',
                'password' => 'newsecurepwd123',
                'password_confirmation' => 'newsecurepwd123',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['current_password']);

        // 2. New password is too short (min:8)
        $response = $this->actingAs($user)
            ->patch(route('profile.password'), [
                'current_password' => 'password',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

        $response->assertSessionHasErrors(['password']);

        // 3. Password confirmation mismatch
        $response = $this->actingAs($user)
            ->patch(route('profile.password'), [
                'current_password' => 'password',
                'password' => 'newsecurepwd123',
                'password_confirmation' => 'mismatchpwd123',
            ]);

        $response->assertSessionHasErrors(['password']);
    }
}
