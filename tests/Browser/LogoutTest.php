<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, post, assertGuest};

test('it logs out a user', function () {
    // Arrange: Kullanıcı oluştur ve login yap
    $user = User::factory()->create();
    actingAs($user);

    // Act: Logout isteği gönder
    $response = post('/logout');

    // Assert: Ana sayfaya yönlendir, kullanıcı logout oldu
    $response->assertRedirect('/');
    assertGuest();
});
