<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    // Display registration form (HTML form)
    public function register()
    {
        // Check if the request is a JSON request (for Postman)
        if ($this->request->isAJAX() || $this->request->getMethod() == 'post') {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Use POST method to register via API']);
        }
        
        // If it's a GET request (HTML form), render the registration page
        return view('auth/register');  // Return the register form view
    }

    // Handle registration (POST request)
    public function save()
    {
        $data = $this->request->getJSON(true);
    
        if (!$data || !isset($data['username'], $data['email'], $data['password'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Missing required fields']);
        }
    
        $userModel = new UserModel();
        $dataToSave = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role' => 'User',
        ];
    
        if ($userModel->save($dataToSave)) {
            $userId = $userModel->insertID();
            $token = createJWT(['id' => $userId, 'role' => 'User'], env('JWT_SECRET'));
    
            return $this->response->setStatusCode(201)->setJSON(['message' => 'Registration successful', 'token' => $token]);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Registration failed']);
        }
    }

    // Display login form (HTML form)
    public function login()
    {
        // Check if it's a JSON request (for Postman)
        if ($this->request->isAJAX() || $this->request->getMethod() == 'post') {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Use POST method to login via API']);
        }

        // If it's a GET request, render the login form
        return view('auth/login');  // Return the login form view
    }

    public function loginAttempt()
    {
        $isJsonRequest = $this->request->isAJAX() || $this->request->getHeaderLine('Content-Type') === 'application/json';
    
        if ($isJsonRequest) {
            // Handle JSON requests (API)
            $data = $this->request->getJSON(true);
        } else {
            // Handle form submissions (view)
            $data = $this->request->getPost();
        }
    
        // Validate input
        if (!isset($data['email'], $data['password'])) {
            if ($isJsonRequest) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Email or password missing']);
            } else {
                return redirect()->back()->with('error', 'Email or password missing')->withInput();
            }
        }
    
        // Check user credentials
        $userModel = new UserModel();
        $user = $userModel->where('email', $data['email'])->first();
    
        if ($user && password_verify($data['password'], $user['password'])) {
            // Set session data
            session()->set([
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                ],
                'isLoggedIn' => true,
            ]);
    
            if ($isJsonRequest) {
                // Respond with JSON for API
                $token = createJWT(['id' => $user['id'], 'role' => $user['role']], env('JWT_SECRET'));
                return $this->response->setJSON(['message' => 'Login successful', 'token' => $token]);
            } else {
                // Redirect to dashboard for views
                return redirect()->to('/dashboard');
            }
        } else {
            if ($isJsonRequest) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid email or password']);
            } else {
                return redirect()->back()->with('error', 'Invalid email or password')->withInput();
            }
        }
    }
    
      
    
    
    

    // Logout user (Clear session)
    public function logout()
    {
        session()->destroy();
        return $this->response->setStatusCode(200)->setJSON(['message' => 'Successfully logged out']);
    }
}