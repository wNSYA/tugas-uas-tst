<?php

namespace App\Controllers;

use App\Models\QuizModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use CodeIgniter\RESTful\ResourceController;

class QuizController extends ResourceController
{
    public function getQuizDetails($quizId)
    {
        // Check if the Authorization header has the correct token
        $authHeader = $this->request->getHeaderLine('Authorization');
        $adminToken = 'Bearer TIRHRRADah7zNjQaNLFTFC5AUelExF_C-D8BO2egzYGwmuX2nPaED-U1h1sgkiJFWaDsIUGblvxIAjqhD1ZO-Q';  // Admin Token
        $userToken = 'Bearer urhiC4D9TQoao9P583pTmFNmSA5Vdv-Nh6XuY3d98DJd0i1e4r-vbx25F9QdY_U-Oyu7TYkeiMZoqpjQ3ws4xA'; // Replace this with the actual User Token
    
        if ($authHeader !== $adminToken && $authHeader !== $userToken) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid token']);
        }
    
        // If the token is valid, retrieve quiz data
        $quizModel = new QuizModel();
        $quiz = $quizModel->find($quizId);
    
        if ($quiz) {
            // Fetch the questions for the quiz
            $questionModel = new QuestionModel();
            $questions = $questionModel->where('quiz_id', $quizId)->findAll();
    
            // Initialize an array to hold the quiz details with questions and options
            $quizData = [];
    
            foreach ($questions as $question) {
                // Fetch the options for each question
                $optionModel = new OptionModel();
                $options = $optionModel->where('question_id', $question['id'])->findAll();
    
                // If the user token is used, exclude the 'is_correct' field in the options
                if ($authHeader === $userToken) {
                    // Remove 'is_correct' from options for user
                    foreach ($options as &$option) {
                        unset($option['is_correct']);
                    }
                }
    
                // Add the question with its options to the quizData array
                $quizData[] = [
                    'question' => $question,
                    'options' => $options
                ];
            }
    
            // Prepare the final data to return
            $data = [
                'quiz' => $quiz,
                'questions' => $quizData
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
    
    
    
}
