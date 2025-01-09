<?php

namespace App\Controllers;

use App\Models\QuizModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    private function checkSession()
    {
        // Check if the user is logged in via session
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You need to log in first.');
        }

        // Return user data from the session
        return session()->get('user');
    }

    public function index()
    {
        // Validate session
        $user = $this->checkSession();
        if ($user instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $user; // Redirect if the session is invalid
        }

        // Fetch quizzes from the database
        $quizModel = new QuizModel();
        $quizzes = $quizModel->findAll();

        // Pass data to the view
        return view('dashboard', ['quizzes' => $quizzes, 'user' => $user]);
    }

    public function logout()
    {
        // Destroy the session and redirect to home
        session()->destroy();
        return redirect()->to('/');
    }
}
