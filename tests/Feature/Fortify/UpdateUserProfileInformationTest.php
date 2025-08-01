<?php

namespace Tests\Feature\Fortify;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateUserProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_profile_photo_called_when_photo_is_provided()
    {
        $user = User::factory()->create();

        $photo = UploadedFile::fake()->image('photo.jpg');

        $input = [
            'name' => 'Updated Name',
            'email' => 'tina70@example.com',
            'nick' => 'updatedNick',
            'photo' => $photo,
        ];

        Storage::fake('public');

        $action = new UpdateUserProfileInformation();
        $action->update($user, $input);

        Storage::disk('public')->assertExists('profile-photos/' . $photo->hashName());

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updatedNick', $user->nick);
        $this->assertEquals('tina70@example.com', $user->email);
    }

    public function test_update_user_profile_information_without_email_change()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'nick' => 'Old Nick',
            'email' => 'old@example.com',
        ]);

        $input = [
            'name' => 'Updated Name',
            'nick' => 'Updated Nick',
            'email' => 'old@example.com',
        ];

        $action = new UpdateUserProfileInformation();

        $originalName = $user->name;
        $originalNick = $user->nick;
        $originalEmail = $user->email;

        $action->update($user, $input);

        $user->refresh();

        $this->assertNotEquals($originalName, $user->name);
        $this->assertNotEquals($originalNick, $user->nick);

        $this->assertEquals($originalEmail, $user->email);
    }
}
