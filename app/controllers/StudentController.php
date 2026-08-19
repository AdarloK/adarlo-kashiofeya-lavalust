<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');


class StudentController extends Controller
{
    // Access condition for this activity: a 4-digit PIN.
    // TODO: change this to your own PIN if you want.
    private $portal_pin = '0125';

    public function before_action()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function index()
    {
        $data = [
            'page_title' => 'Kashiofeya Student Portal',
            'unlocked'   => !empty($_SESSION['portal_unlocked']),
            'message'    => $_SESSION['access_message'] ?? null,
        ];

        // Clear the one-time flash message after reading it
        unset($_SESSION['access_message']);

        $this->call->view('student_home', $data);
    }

    public function verify()
    {
        $pin = isset($_POST['pin']) ? trim($_POST['pin']) : '';

        if ($pin === $this->portal_pin) {
            $_SESSION['portal_unlocked'] = true;
            $_SESSION['access_message'] = 'Access granted. StudentMiddleware verified your PIN.';
            redirect('student/profile');
        } else {
            $_SESSION['portal_unlocked'] = false;
            $_SESSION['access_message'] = 'Incorrect PIN. StudentMiddleware blocked access to the profile page.';
            redirect('student');
        }
    }

    public function lock()
    {
        $_SESSION['portal_unlocked'] = false;
        $_SESSION['access_message'] = 'Portal locked. Profile access has been revoked.';
        redirect('student');
    }

    public function profile()
    {
        $student = [
            // ===== REQUIRED FIELDS — replace with YOUR OWN information =====
            'student_id'  => 'MCC2024-0009',
            'name'        => 'Kashiofeya S. Adarlo',
            'course'      => 'BS Information Technology',
            'year'        => '3rd Year',
            'section'     => '3F1',
            'email'       => 'kashiofeyaa@gmail.com',
        ];

        $this->call->view('student_profile', $student);
    }
}
