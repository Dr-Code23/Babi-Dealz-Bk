<?php

namespace Modules\Auth\Http\Controllers\Api\Auth;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\ApiResource\ApiResponse;
use Modules\Auth\Http\Requests\CreateAgencyRequest;
use Modules\Auth\Http\Requests\CreateDealsRequest;
use Modules\Auth\Http\Requests\CreateRequest;
use Modules\Auth\Http\Requests\loginRequest;
use Modules\Auth\Http\Requests\VerifyRequest;
use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Auth\Transformers\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{ use ApiResponse;
    private $UserRepository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * @param CreateRequest $request
     * @return mixed
     */
    public function register(CreateRequest $request): mixed
    {
        return $this->UserRepository->register($request);

    }

    /**
     * @param VerifyRequest $request
     * @return void
     */
public function verify(VerifyRequest $request)
{
    return $this->UserRepository->verify($request);

}

    /**
     * @param loginRequest $request
     * @return mixed
     */
    public function Login(loginRequest $request): mixed
    {

        return   $this->UserRepository->login($request);

    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }


    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $this->apiResponse($validated);
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return $this->apiResponse([],'Invalid credentials provided.', 422);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );

        $token = $user->createToken('api_token')->plainTextToken;
        return $this->apiResponse([new UserResource($userCreated),$token],'success',200);

    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'google'])) {
            return response()->json(['error' => 'Please login using facebook or google'], 422);
        }
    }

    /**
     * @return mixed
     */
    public function notification()
    {

        return $this->UserRepository->notification();

    }

    /**
     * @return mixed
     */
    public function unreadNotification()
    {

        return $this->UserRepository->unreadNotification();

    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteNotification($id)
    {

        return $this->UserRepository->deleteNotification($id);

    }

public function agencyRegister(CreateAgencyRequest $request)
{

    return $this->UserRepository->agencyRegister($request);

}
    public function dealsRegister(CreateDealsRequest $request)
    {

        return $this->UserRepository->dealsRegister($request);

    }


}
