<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

class MemberController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.members.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.members.add_new');
    }

    public function store(MemberRequest $request)
    {
        $image = $request->file;
        $path = '';
        $imageName = '';
        if (isset($image)) {
            $fileName = $image->getClientOriginalName();
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $path = 'images/members/';
            $imageName = $request->name . "." . $extension;
            $image->storeAs($path, $imageName);
        }
        $member = $this->userRepo->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'about' => $request->about,
            'image' => $path . $imageName ?? null,
            'status' => config('user.confirm'),
            'download_free' => config('user.download_free'),
            'upload' => config('user.upload'),
            'coin' => config('user.coin'),
            'password' => Hash::make($request->password),
        ]);
        $role = $this->userRepo->getRoleAdmin();
        $this->userRepo->setRole($member, $role->id);
        $message = __('member.add_success');

        return redirect(route('admin.members.index'))->with('success', $message);
    }

    public function upgrade($id)
    {
        $member = $this->userRepo->find($id);
        $role = $this->userRepo->getRoleAdmin();
        if ($member->role_id != $role->id) {
            $this->userRepo->setRole($member, $role->id);
        } else {
            $roleUser = $this->userRepo->getRoleUser();
            $this->userRepo->setRole($member, $roleUser->id);
        }
        $code = config('code.success');

        return response()->json($code);
    }

    public function ban($id)
    {
        $member = $this->userRepo->find($id);
        $status =  config('user.banned_status');
        if ($member->status == $status) {
            $this->userRepo->update($member, [
                'status' => config('user.confirm'),
            ]);
        } else {
            $this->userRepo->update($member, [
                'status' => $status,
            ]);
        }
        $code = config('code.success');

        return response()->json($code);
    }
}
