<?php

namespace App\Http\Controllers\UserList;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserListController extends Controller
{
    /**
     * Display a paginated list of users based on role permissions
     */
    public function index()
    {
        $currentUserRole = Session::get('role');
        $currentUserCompany = Session::get('company');

        if (!$currentUserRole) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $users = User::query();

        if ($currentUserRole === 'admin') {
            $users->where('role', 'employee')
                ->where('company', $currentUserCompany);
            $view = 'admin.manage-employees';
        } elseif ($currentUserRole === 'superuser') {
            $users->where('role', 'admin');
            $view = 'SU.admin-list';
        } else {
            return view('users.list', ['users' => []]);
        }

        $paginatedUsers = $users
            ->orderBy('emp_id', 'asc')
            ->select([
                'id',
                'emp_id',
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'role',
                'position',
                'department',
                'company',
                'created_at'
            ])
            ->paginate(12);

        $paginatedUsers->transform(function ($user) {
            $user->emp_id = $this->normalizeEmpId($user->emp_id);
            $user->first_name = $this->normalizeName($user->first_name);
            $user->middle_name = $user->middle_name
                ? $this->normalizeName($user->middle_name)
                : null;
            $user->last_name = $this->normalizeName($user->last_name);
            $user->position = $this->normalizeTitleCase($user->position);
            $user->department = $this->normalizeTitleCase($user->department);
            $user->company = $this->normalizeTitleCase($user->company);
            return $user;
        });

        return view($view, ['users' => $paginatedUsers]);
    }

    /* ==========================
       Helpers
       ========================== */

    private function normalizeName(string $name): string
    {
        return Str::title(Str::lower(trim($name)));
    }

    private function normalizeEmpId(string $empId): string
    {
        return strtoupper(preg_replace('/\s+/', '', trim($empId)));
    }

    private function normalizeTitleCase(string $text): string
    {
        return Str::title(Str::lower(trim($text)));
    }

    private function canEditUser($currentUserRole, $currentUserCompany, $targetUser): bool
    {
        if ($currentUserRole === 'admin') {
            return $targetUser->role === 'employee'
                && $targetUser->company === $currentUserCompany;
        }

        if ($currentUserRole === 'superuser') {
            return $targetUser->role === 'admin';
        }

        return false;
    }
}