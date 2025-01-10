<?php

namespace App\Controllers;

use App\Models\QuizModel;
use CodeIgniter\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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

    public function materi()
    {
        $json = '{
            "status": 200,
            "data": [
                {
                    "id": "1",
                    "name": "Aritmatika Sosial"
                },
                {
                    "id": "2",
                    "name": "Aljabar"
                },
                {
                    "id": "3",
                    "name": "Geometri"
                },
                {
                    "id": "4",
                    "name": "Statistika dan Probabilitas"
                },
                {
                    "id": "5",
                    "name": "Bilangan dan Pola"
                }
            ]
        }';
        // Membuat client HTTPS
        $client = new Client();

        // Alamat API login
        $loginUrl = 'http://ec2-18-205-163-69.compute-1.amazonaws.com:8081/auth/login';
        // Data login
        $loginData = [
            'headers' => [
                'Host' => 'ec2-18-205-163-69.compute-1.amazonaws.com:8081',
                'Accept' => 'application/json'
            ],
            'json' => [
                'email' => 'mamborifa@example.com',
                'password' => 'mamborifa'
            ]
        ];

        try {
            // Melakukan request login
            $response = $client->post($loginUrl, $loginData);

            // Mengambil response dan decoding JSON
            $loginResponse = json_decode($response->getBody()->getContents(), true);

            // Mengecek apakah login berhasil
 
                // Endpoint untuk mendapatkan materi
                $materiUrl = 'http://ec2-18-205-163-69.compute-1.amazonaws.com:8081/topik/';

                // Request untuk mendapatkan materi
                $materiResponse = $client->request('GET', $materiUrl, [
                    'headers' => [
                        'Host' => 'ec2-18-205-163-69.compute-1.amazonaws.com:8081',
                        'Accept' => 'application/json'
                    ]
                ]);

                // Mengambil data materi
                $materiData = json_decode($materiResponse->getBody()->getContents(), true);

        
                return view('materi', ['items' => $json]);

 

        } catch (RequestException $e) {
            // Menangani error saat melakukan request
            return view('error_view', ['error' => 'Request failed: ' . $e->getMessage()]);
        }
    }

    public function materi1($materiId){
        $json = '{
            "status": 200,
            "data": {
                "name": "Aritmatika Sosial",
                "description": "Topik ini mencakup penerapan konsep matematika dalam kehidupan sehari-hari, seperti perhitungan keuntungan, kerugian, diskon, bunga, dan pajak. Siswa akan mempelajari cara menyelesaikan masalah yang melibatkan bilangan bulat, pecahan, dan persentase untuk memahami konsep aritmatika sosial secara praktis.",
                "video_link": "https://youtu.be/VQqEdbStxsM?si=0LohetNSZiPyd6tW"
            }
        }';
        // Membuat client HTTPS
        $client = new Client();

        // Alamat API login
        $loginUrl = 'http://ec2-18-205-163-69.compute-1.amazonaws.com:8081/auth/login';
        // Data login
        $loginData = [
            'headers' => [
                'Host' => 'ec2-18-205-163-69.compute-1.amazonaws.com:8081',
                'Accept' => 'application/json'
            ],
            'json' => [
                'email' => 'mamborifa@example.com',
                'password' => 'mamborifa'
            ]
        ];

        try {
            // Melakukan request login
            $response = $client->post($loginUrl, $loginData);

            // Mengambil response dan decoding JSON
            $loginResponse = json_decode($response->getBody()->getContents(), true);

            // Mengecek apakah login berhasil
 
                // Endpoint untuk mendapatkan materi
                $materiUrl = 'http://ec2-18-205-163-69.compute-1.amazonaws.com:8081/topik/';

                // Request untuk mendapatkan materi
                $materiResponse = $client->request('GET', $materiUrl, [
                    'headers' => [
                        'Host' => 'ec2-18-205-163-69.compute-1.amazonaws.com:8081',
                        'Accept' => 'application/json'
                    ]
                ]);

                // Mengambil data materi
                $materiData = json_decode($materiResponse->getBody()->getContents(), true);

        
                return view('materi1', ['items' => $json]);

 

        } catch (RequestException $e) {
            // Menangani error saat melakukan request
            return view('error_view', ['error' => 'Request failed: ' . $e->getMessage()]);
        }
    }


    public function logout()
    {
        // Destroy the session and redirect to home
        session()->destroy();
        return redirect()->to('/');
    }
}
