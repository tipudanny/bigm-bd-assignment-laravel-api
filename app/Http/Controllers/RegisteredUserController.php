<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\RegisteredUser;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $page = (request()->get('page')) ? request()->get('page') : 1;
        $name = (request()->get('name')) ? request()->get('name') : '';
        $email = (request()->get('email')) ? request()->get('email') : '';

        $users = RegisteredUser::when($name, function ($query) use ($name) {
                return $query->where('name', 'like', $name );
            })
            ->when($email, function ($query) use ($email) {
                return $query->where('email','like',$email);
            })
            ->orderBy('id', 'desc')->paginate(15);

        return UserResource::collection($users);
    }

    public function store(UserRegistrationRequest $request)
    {
        $data = $request->validated();

        $data['educations'] = json_encode($request->educations, true);
        $data['trainings'] = json_encode($request->trainings, true);

        $data['profile_image'] = uniqid() . $request->profile_image->getClientOriginalName();
        $data['cv_attachment'] = uniqid() . $request->cv_attachment->getClientOriginalName();

        try {
            $request->profile_image->storeAs('/public/images', $data['profile_image']);
            $request->cv_attachment->storeAs('/public/docs', $data['cv_attachment']);
            $user = RegisteredUser::create($data);
            return response()->json([
                'user' => $user,
                'message' => 'Registration Successful',
            ], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
