<?php

namespace Modules\Auth\Service\Api\V1;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{DB, Hash, Log, Mail};
use Modules\Auth\DTO\Api\V1\{ForgetPasswordDTO, LoginDTO, RegisterUserDTO, ResetPasswordDTO};
use Modules\Auth\Emails\Api\V1\ForgetPasswordEmail;
use Modules\Auth\Http\Resources\Api\V1\ProfileResource;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    public const CHANNEL = 'auth';

    /**
    * @param  RegisterUserDTO  $data
    * @return array<string, mixed>
    */
    public function register(RegisterUserDTO $data): array
    {
        try {
            $user = $this->createUser($data);
            return successResponse($this->loginData($user));
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__('error'));
        }
    }

    /**
     * @param  LoginData  $data
     * @return array<string, mixed>
     */
    public function login(LoginDto $data): array
    {
        try {
            $user = User::whereEmail($data->email)->first();

            if (!$user || !Hash::check($data->password, $user->password)) {
                return errorResponse(__('auth.failed'), Response::HTTP_UNAUTHORIZED);
            }

            return successResponse($this->loginData($user));
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__('error'));
        }
    }

    /**
    * @param  ForgetPasswordDto  $data
    * @return array<string, mixed>
    */
    public function forgetPassword(ForgetPasswordDto $data): array
    {
        try {
            $user = User::query()
                ->where('email', $data->email)
                ->first();

            if (!$user) {
                return errorResponse(__('User not found'), Response::HTTP_BAD_REQUEST);
            }

            $token = rand(100000, 999999);

            $this->deletePasswordResetToken($user->email);

            $this->setPasswordResetToken($user, $token);

            $this->sendPasswordResetEmail($user, $token);

            return successResponse([
                'message' => __('password reset email sent'),
            ]);
        } catch (Exception $ex) {
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__('error'));
        }
    }

    public function resetPassword(ResetPasswordDto $data)
    {
        try {
            DB::beginTransaction();

            $user = User::query()
                ->where('email', $data->email)
                ->first();

            if (!$user) {
                return errorResponse(__('User not found'), Response::HTTP_BAD_REQUEST);
            }

            $token = $this->getPasswordResetToken($data->token, $data->email);

            if (!$token) {
                return errorResponse(__('Invalid token'), Response::HTTP_BAD_REQUEST);
            }

            $user->update([
                'password' => Hash::make($data->password),
            ]);

            $this->deletePasswordResetToken($data->token);

            DB::commit();

            return successResponse([
                'message' => __('Password update successfully'),
            ]);
        } catch (Exception $ex) {
            DB::rollback();
            Log::channel(self::CHANNEL)->error($ex->getMessage());
            return errorResponse(__('error'));
        }
    }


    /*
    |
    |--------------------------------------------------------------------------
    | class internal methods
    |--------------------------------------------------------------------------
    |
    */

    /**
    * @param $email
    * @return array
    */
    private function loginData(User $user): array
    {
        return [
            'profile' => new ProfileResource($user),
            'token' => $this->generateAuthToken($user),
        ];
    }

    /**
    * @param User $user
    * @return mixed
    */
    private function generateAuthToken(User $user): mixed
    {
        return $user->createToken('token')->plainTextToken;
    }

    /**
    * @param string $email
    * @return mixed
    */
    private function deletePasswordResetToken(string $email): void
    {
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }

    /**
    * @param User $user
    * @param string $token
    * @return void
    */
    private function setPasswordResetToken(User $user, string $token): void
    {

        DB::table('password_reset_tokens')
            ->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now(),
            ]);
    }

    /**
    * @param string $token
    * @param string $email
    * @return mixed
    */
    private function getPasswordResetToken(string $token, string $email): mixed
    {
        return DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $email)
            ->first();
    }

    /**
    * @param User $user
    * @param string $token
    * @return void
    */
    private function sendPasswordResetEmail(User $user, string $token): void
    {
        Mail::to($user->email)->send(new ForgetPasswordEmail($user, $token));
    }

    private function createUser(RegisterUserDTO $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }
}
