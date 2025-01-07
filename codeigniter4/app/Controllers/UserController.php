<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfileModel;
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
        $data = $this->request->getJSON(true);  // Get JSON request data

        if (!$data) {
            // If no JSON data was sent, fall back to form data
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];
        }

        // Validate the input data
        if (!isset($data['username'], $data['email'], $data['password'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Missing required fields']);
        }

        $userModel = new UserModel();

        // Prepare data for saving
        $dataToSave = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role' => 'User',  // Default role is 'User'
        ];

        // Save the user data to the database
        if ($userModel->save($dataToSave)) {
            // Return a JSON response for API requests
            return $this->response->setStatusCode(201)->setJSON(['message' => 'Registration successful. Please login.']);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Registration failed. Check your input.']);
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
        // Determine if the request is an API or a web request
        $isApiRequest = $this->request->isAJAX() || $this->request->getHeaderLine('Content-Type') === 'application/json';
    
        $data = $isApiRequest ? $this->request->getJSON(true) : $this->request->getPost();
    
        // Validate the input data
        if (!isset($data['email'], $data['password'])) {
            if ($isApiRequest) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Email or password missing']);
            } else {
                return redirect()->back()->with('error', 'Email or password missing');
            }
        }
    
        $userModel = new UserModel();
        $email = $data['email'];
        $password = $data['password'];
    
        // Check if the user exists
        $user = $userModel->where('email', $email)->first();
    
        if ($user && password_verify($password, $user['password'])) {
            // Define tokens for Admin and User
            $adminToken = "TIRHRRADah7zNjQaNLFTFC5AUelExF_C-D8BO2egzYGwmuX2nPaED-U1h1sgkiJFWaDsIUGblvxIAjqhD1ZO-Q"; // Admin Token
            $userToken = "urhiC4D9TQoao9P583pTmFNmSA5Vdv-Nh6XuY3d98DJd0i1e4r-vbx25F9QdY_U-Oyu7TYkeiMZoqpjQ3ws4xA";
    
            if ($isApiRequest) {
                // Check user role and assign appropriate token
                if ($user['role'] === 'Admin') {
                    return $this->response->setStatusCode(200)->setJSON([
                        'message' => 'Login successful',
                        'token' => $adminToken,
                        'user' => ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']],
                    ]);
                } else {
                    return $this->response->setStatusCode(200)->setJSON([
                        'message' => 'Login successful',
                        'token' => $userToken, // Send the user token
                        'user' => ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']],
                    ]);
                }
            } else {
                // Set session data for web clients
                session()->set([
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],  // Store the user role
                    ],
                    'isLoggedIn' => true,
                ]);
    
                return redirect()->to('/dashboard');
            }
        } else {
            if ($isApiRequest) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid email or password']);
            } else {
                return redirect()->back()->with('error', 'Invalid email or password');
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