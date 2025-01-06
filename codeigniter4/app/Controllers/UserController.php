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

    // Attempt to login (POST request)
    public function loginAttempt()
    {
        $data = $this->request->getJSON(true);  // Get JSON request data

        if (!$data) {
            // If no JSON data was sent, fall back to form data
            $data = [
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];
        }

        // Validate the input data
        if (!isset($data['email'], $data['password'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Email or password missing']);
        }

        $userModel = new UserModel();
        $email = $data['email'];
        $password = $data['password'];

        // Check if the user exists
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session data for logged in user
            session()->set([
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                ],
                'isLoggedIn' => true,
            ]);

            // Return success response for API requests
            return $this->response->setStatusCode(200)->setJSON([
                'message' => 'Login successful',
                'user' => ['id' => $user['id'], 'username' => $user['username']],
            ]);
        } else {
            // Return error response for API requests
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid email or password']);
        }
    }

    // // Logout user (Clear session)
    // public function logout()
    // {
    //     session()->destroy();
    //     return $this->response->setStatusCode(200)->setJSON(['message' => 'Successfully logged out']);
    // }

    // // Display user profile (HTML form)
    // public function profile()
    // {
    //     $userModel = new UserModel();
    //     $profileModel = new ProfileModel();

    //     $user_id = session()->get('user_id');
    //     $user = $userModel->find($user_id);
    //     $profile = $profileModel->where('user_id', $user_id)->first();

    //     // Return profile in JSON format
    //     return $this->response->setStatusCode(200)->setJSON([
    //         'user' => $user,
    //         'profile' => $profile
    //     ]);
    // }

    // // Update user profile (POST)
    // public function updateProfile()
    // {
    //     $profileModel = new ProfileModel();

    //     $user_id = session()->get('user_id');
    //     $data = $this->request->getJSON(true);  // Get JSON request data

    //     if (!isset($data['full_name'], $data['bio'])) {
    //         return $this->response->setStatusCode(400)->setJSON(['error' => 'Missing required fields']);
    //     }

    //     $profileData = [
    //         'full_name' => $data['full_name'],
    //         'bio' => $data['bio']
    //     ];

    //     // Check if the profile exists
    //     $profile = $profileModel->where('user_id', $user_id)->first();
    //     if ($profile) {
    //         $profileModel->update($profile['id'], $profileData);
    //     } else {
    //         $profileData['user_id'] = $user_id;
    //         $profileModel->save($profileData);
    //     }

    //     return $this->response->setStatusCode(200)->setJSON(['message' => 'Profile updated successfully']);
    // }
}
