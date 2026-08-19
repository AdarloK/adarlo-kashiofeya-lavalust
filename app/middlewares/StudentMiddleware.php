<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * StudentMiddleware
 *
 * Protects the /student/profile route. Access is only granted when
 * the session flag 'portal_unlocked' has been set to true — which
 * happens after a visitor submits the correct PIN on the student
 * home page (see StudentController::verify()).
 *
 * Request
 *   v
 * StudentMiddleware -- checks $_SESSION['portal_unlocked']
 *   |
 *   +-- YES -> next() -> StudentController::profile() -> view
 *   +-- NO  -> redirect back to /student with a message
 */
class StudentMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure $next
     * @return mixed
     */
    public function handle($next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['portal_unlocked']) && $_SESSION['portal_unlocked'] === true) {
            return $next();
        }

        // Access denied: leave a message for the home page and redirect there
        $_SESSION['access_message'] = 'Locked — /student/profile is currently blocked.';
        redirect('student');
        exit;
    }
}
