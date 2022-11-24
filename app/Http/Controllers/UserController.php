<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserRegistrationRequest;

use Illuminate\Support\Facades\Auth;
use App\Traits\RequestValidatorTrait as Validator;
use Lcobucci\JWT\Exception;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use Validator;

    /**
     * Register a User
     *
     * @param $request
     * @return data with Auth Token
     */
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {

            $requestStatus = Validator::isValidRequest($request, UserRegistrationRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('AuthToken')->accessToken;
            $success['user'] = $user;

            DB::commit();

            return response()->json($success, 200);

        } catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Create a User
     *
     * @param $request
     * @returns $user
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $requestStatus = Validator::isValidRequest($request, UserRegistrationRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            DB::commit();

            return response()->json($user, 200);

        } catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Authenticate a User
     *
     * @param $request
     * @returns $user with token
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password]))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('AuthToken')->accessToken;
            $success['user'] = $user;

            return response()->json($success, 200);
        }else{
            return response()->json('Unauthorized: Username/Password mismatched or User does not exists', 401);
        }
    }

    /**
     * Unauthenticate a User
     *
     * @param $request
     * @return Unauthenticated message
     */
    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json("User has been logged out.");
    }

    /**
     * Get User Details
     *
     * @param $user_id
     * @return $user
     */
    public function get($id)
    {
        $user = User::find($id);

        return response()->json($user, 200);
    }

    /**
     * Get All Users
     *
     * @param $request
     * @returns $users
     */
    public function index(Request $request)
    {
        $page_limit = $request->page_limit ?? 10;
        $users = User::paginate($page_limit);

        return response()->json($users, 200);
    }

    /**
     * Update a User
     *
     * @params $request
     * @returns $user
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $requestStatus = Validator::isValidRequest($request, UpdateUserRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            if(isset($input['password']))
            {
                $input['password'] = bcrypt($input['password']);
            }

            $user = User::find($input['id']);
            $user->update($input);

            DB::commit();

            return response()->json($user, 200);
        }catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Delete a User
     *
     * @params @user_id
     * @returns $message
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json("A user has nee successfully deleted.", 200);
    }

}
