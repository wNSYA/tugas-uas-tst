<?php

namespace App\Controllers;

use App\Models\QuizModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/user/login');
        }

        // Ambil data kuis dari database
        $quizModel = new QuizModel();
        $quizzes = $quizModel->findAll();

        // Kirim data kuis ke view
        return view('dashboard', ['quizzes' => $quizzes]);
    }

    public function logout()
    {
        // Hapus data session
        session()->destroy();
        return redirect()->to('/');
    }
}
