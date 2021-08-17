<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $userRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function mark($id)
    {
        $this->userRepo->markNotification($id);

        return redirect()->route('users.show', $id);
    }

    public function markAll()
    {
        $user = Auth::user();
        $this->userRepo->markAllNotification($user);

        return redirect()->back();
    }
}
