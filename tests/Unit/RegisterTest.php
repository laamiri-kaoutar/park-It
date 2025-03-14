<?php

namespace Tests\Unit;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\AuthController;
use PHPUnit\Framework\TestCase;
use Mockery;

class RegisterTest extends TestCase
{
    
    public function test_register_with_valid_data()
    {
        // Arrange: Mock the RegisterUserRequest to return valid data
        $mockRequest = Mockery::mock(RegisterUserRequest::class);
        $mockRequest->shouldReceive('validated')->andReturn([
            'name' => 'kaoutar',
            'email' => 'koko@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'role_id' => 1
        ]);

        // Arrange: Mock the User model
        $mockUser = Mockery::mock(User::class);
        $mockUser->shouldReceive('create')->andReturnSelf();
        $mockUser->shouldReceive('createToken')->andReturnSelf();
        $mockUser->plainTextToken = 'someToken';  // Mock token value

        // Act: Call the register method
        $controller = new AuthController();
        $response = $controller->register($mockRequest);

        // Assert: Check if the response contains the user and token
        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('token', $response);
        $this->assertEquals('someToken', $response['token']); // Assert token value
    }
}
