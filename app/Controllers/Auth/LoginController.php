<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    /**
     * Display Login Page
     */
    public function index()
    {
        if (auth()->loggedIn()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth/login', [
            'title' => 'Admin Login',
        ]);
    }

    /**
     * Handle Login Request
     */
    public function login()
    {
        // -------------------------
        // Validation
        // -------------------------
        $rules = [
            'login' => [
                'label' => 'Email or Username',
                'rules' => 'required',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // -------------------------
        // Detect Email / Username
        // -------------------------
        $login = trim($this->request->getPost('login'));

        $credentials = [
            filter_var($login, FILTER_VALIDATE_EMAIL)
                ? 'email'
                : 'username' => $login,

            'password' => $this->request->getPost('password'),
        ];

        // -------------------------
        // Remember Me
        // -------------------------
        $remember = (bool) $this->request->getPost('remember');

        $result = $remember
            ? auth()->remember()->attempt($credentials)
            : auth()->attempt($credentials);

        // -------------------------
        // Invalid Credentials
        // -------------------------
        if (! $result->isOK()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $result->reason());
        }

        // -------------------------
        // Logged In User
        // -------------------------
        $user = auth()->user();

        // -------------------------
        // Admin Group Check
        // -------------------------
        if (! $user->inGroup('admin')) {

            auth()->logout();

            return redirect()
                ->route('admin.login')
                ->with('error', 'You are not authorized to access Admin Panel.');
        }

        // -------------------------
        // Success
        // -------------------------
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Welcome back ' . $user->username . '!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth()->logout();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Logged out successfully.');
    }
}
