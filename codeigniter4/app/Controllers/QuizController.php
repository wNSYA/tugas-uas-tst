<?php

namespace App\Controllers;

use App\Models\QuizModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use CodeIgniter\RESTful\ResourceController;

class QuizController extends ResourceController
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
    // Method untuk mengambil daftar quiz
    public function listQuiz()
    {
        $decoded = $this->validateToken();
        if (!$decoded) return;
    
        $quizModel = new QuizModel();
        $quizzes = $quizModel->findAll();
    
        if (empty($quizzes)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No quizzes found']);
        }
    
        return $this->respond($quizzes);
    }

    public function getQuizDetails($quizId) 
    {
        $decoded = $this->validateToken();
        if (!$decoded) return;
    
        // If the token is valid, retrieve quiz data
        $db = \Config\Database::connect();
    
        // Get quiz basic info
        $quizQuery = $db->table('quizzes')
            ->select('title, description')
            ->where('id', $quizId);
    
        $quiz = $quizQuery->get()->getRowArray();
    
        if ($quiz) {
            // Get questions
            $questionsQuery = $db->table('questions')
                ->select('id, question_text')
                ->where('quiz_id', $quizId);
    
            $questions = $questionsQuery->get()->getResultArray();
    
            // Process each question and its options
            foreach ($questions as &$question) {
                // Select different fields based on token type
                if ($decoded->role == 'Admin') {
                    $optionsQuery = $db->table('options')
                        ->select('option_text, is_correct')
                        ->where('question_id', $question['id']);
                    
                    // For admin: get options with their correct/incorrect status
                    $options = $optionsQuery->get()->getResultArray();
                    foreach ($options as &$option) {
                        $option['option_text'] = [
                            'text' => $option['option_text'],
                            'value' => $option['is_correct']
                        ];
                        unset($option['is_correct']);
                    }
                } else {
                    // For regular users: just get option text
                    $optionsQuery = $db->table('options')
                        ->select('option_text')
                        ->where('question_id', $question['id']);
                    
                    $options = $optionsQuery->get()->getResultArray();
                }
                
                $question['options'] = $options;
            }
    
            // Prepare the final data to return
            $data = [
                'quiz' => $quiz,
                'questions' => $questions
            ];
    
            return $this->response->setJSON($data);
        }
    
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Quiz not found']);
    }

    public function startQuiz($quizId)
    {
        $quizModel = new QuizModel();
        $questionModel = new QuestionModel();
        $optionModel = new OptionModel();
    
        // Fetch the quiz data
        $quiz = $quizModel->find($quizId);
        if (!$quiz) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Quiz not found');
        }
    
        // Fetch the related questions and options for the quiz
        $questions = $questionModel->where('quiz_id', $quizId)->findAll();
        foreach ($questions as &$question) {
            $question['options'] = $optionModel->where('question_id', $question['id'])->findAll();
        }
    
        return view('quiz/start', [
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }


    public function submitQuiz()
    {
        $quizId = $this->request->getPost('quiz_id');
        $userId = session()->get('user_id'); // Get the logged-in user ID
        $answers = $this->request->getPost('answers'); // Answers from the form
    
        if (empty($answers) || empty($quizId)) {
            return redirect()->to('/dashboard')->with('error', 'No answers provided or invalid quiz');
        }
    
        // Fetch quiz and questions
        $quizModel = new QuizModel();
        $questionModel = new QuestionModel();
        $optionModel = new OptionModel();
    
        // Calculate score
        $score = 0;
        $correctAnswers = [];
    
        foreach ($answers as $questionId => $selectedOptionId) {
            $question = $questionModel->find($questionId);
            $correctOption = $optionModel->where('question_id', $questionId)
                                         ->where('is_correct', true)
                                         ->first();
    
            // Check if the answer is correct
            if ($selectedOptionId == $correctOption['id']) {
                $score++;
            }
    
            // Collect answers for showing result
            $correctAnswers[$questionId] = [
                'selected_option_id' => $selectedOptionId,
                'correct_option_id' => $correctOption['id'],
            ];
        }
    
        // Return a result view showing the score and answers
        return view('quiz/quiz_result', [
            'score' => $score,
            'totalQuestions' => count($answers),
            'quizTitle' => $quizModel->find($quizId)['title'],
            'correctAnswers' => $correctAnswers,
        ]);
    }
    
    public function answerQuiz()
    {
        $decoded = $this->validateToken();
        if (!$decoded) return;

    
        // Ambil data JSON dari request body
        $data = $this->request->getJSON(true);
    
        // Validasi input
        if (!isset($data['quiz_id']) || !isset($data['answers']) || !is_array($data['answers'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid quiz ID or answers format']);
        }
    
        $quizId = $data['quiz_id'];
        $userAnswers = $data['answers']; // format: { "sequence": selected_option_position, ... }
    
        // Ambil quiz dari database
        $quizModel = new QuizModel();
        $quiz = $quizModel->find($quizId);
    
        if (!$quiz) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Quiz not found']);
        }
    
        // Ambil pertanyaan untuk quiz ini
        $questionModel = new QuestionModel();
        $questions = $questionModel->where('quiz_id', $quizId)->findAll();
    
        if (empty($questions)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No questions found for this quiz']);
        }
    
        // Petakan pertanyaan berdasarkan sequence
        $mappedQuestions = [];
        $sequence = 1;
    
        foreach ($questions as $question) {
            $mappedQuestions[$sequence] = $question; // Pemetaan sequence ke pertanyaan
            $sequence++;
        }
    
        // Ambil semua jawaban benar dan format data
        $optionModel = new OptionModel();
        $quizData = [];
        $sequence = 1;
    
        foreach ($mappedQuestions as $sequence => $question) {
            // Ambil opsi yang benar
            $correctOption = $optionModel->where('question_id', $question['id'])
                                         ->where('is_correct', true)
                                         ->first();
    
            // Ambil semua opsi untuk soal ini
            $options = $optionModel->where('question_id', $question['id'])->findAll();
    
            // Cari posisi opsi yang benar
            $correctPosition = null;
            foreach ($options as $index => $option) {
                if ($option['id'] === $correctOption['id']) {
                    $correctPosition = $index + 1; // Posisi dimulai dari 1
                    break;
                }
            }
    
            // Posisi yang dipilih pengguna berdasarkan sequence
            $selectedPosition = isset($userAnswers[$sequence]) ? $userAnswers[$sequence] : null;
    
            $quizData[] = [
                'question_sequence' => $sequence, // Gunakan urutan angka untuk ID
                'question_text' => $question['question_text'],
                'correct_position' => $correctPosition,
                'user_selected_position' => $selectedPosition,
            ];
        }
    
        // Kembalikan data kuis, pertanyaan, dan posisi jawaban benar
        return $this->response->setJSON([
            'quiz_id' => $quizId,
            'quiz_title' => $quiz['title'],
            'questions' => $quizData,
        ]);
    }        
}
