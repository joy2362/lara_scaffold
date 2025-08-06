<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Modules\Auth\DTO\Api\V1\{ForgetPasswordDTO, LoginDTO, RegisterUserDTO, ResetPasswordDTO};
use Modules\Auth\Http\Requests\Api\V1\{ForgetPasswordRequest, LoginRequest, RegisterUserRequest, ResetPasswordRequest, ResetTokenValidationRequest};
use Modules\Auth\Service\Api\V1\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(public AuthService $service)
    {
    }

    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $dto = new RegisterUserDTO(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
        );

        $response = $this->service->register($dto);

        return response()->json($response['data'], $response['status']);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $dto = new LoginDTO(
            email: $validated['email'],
            password: $validated['password'],
            remember: $validated['remember'] ?? false
        );

        $response = $this->service->login($dto);

        return response()->json($response['data'], $response['status']);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $validated = $request->validated();

        $dto = new ForgetPasswordDTO(
            email: $validated['email']
        );

        $response = $this->service->forgetPassword($dto);
        return response()->json($response['data'], $response['status']);
    }

    public function verifyResetOtp(ResetTokenValidationRequest $request)
    {
        return response()->json(['success' => true], Response::HTTP_OK);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $dto = new ResetPasswordDTO(
            token: $validated['token'],
            email: $validated['email'],
            password: $validated['password'],
            confirm_password: $validated['confirm_password']
        );

        $response = $this->service->resetPassword($dto);
        return response()->json($response['data'], $response['status']);
    }
}
