<?php

namespace App\Controllers;

use App\Models\QuizModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    private function validateToken()
{
    $token = getBearerToken();
    if (!$token) {
        return $this->response->setStatusCode(401)->setJSON(['error' => 'Token not provided']);
    }

    $decoded = validateJWT($token, env('JWT_SECRET'));
    if (!$decoded) {
        return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid token']);
    }

    return $decoded; // Return decoded token for further use
}
    public function index()
    {
        $decoded = $this->validateToken();
        if (!$decoded) return;
    
        $quizModel = new QuizModel();
        $quizzes = $quizModel->findAll();
    
        return view('dashboard', ['quizzes' => $quizzes, 'user' => $decoded]);
    }
    

    public function logout()
    {
        // Hapus data session
        session()->destroy();
        return redirect()->to('/');
    }
}
