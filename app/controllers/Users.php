<?php
    class Users extends Controller
    {
        private $user;

        public function __construct()
        {
            $this->user = $this->model('User');
        }

        public function index() {
            // $this->view('home/index', $data);
            // session_init();
            // $_SESSION[] = $data;
            Controller::session_init();
            if (isset($_SESSION['username']))
                $this->view('users/index');
            else
                $this->view('home/index');
        }
        
        public function login() {
            Controller::session_init();
            if (isset($_POST['submit'])) {
                $_SESSION['username_error'] = '';
                $_SESSION['password_error'] = '';
                $_SESSION['username'] = $_POST['username'];
            } else {
                $_SESSION = ['username' => '', 'username_error' => '', 'password_error' => ''];
            }
            if (isset($_POST['submit'])) {
                $this->user->setUserName($_POST['username']);
                // check for user credentials conformity
                $user = $this->user->findUserByName($_POST['username']);
                if ($user) {
                    $this->verifyPassword($user, $_SESSION);
                } else {
                    if (empty($_POST['username']))
                        $_SESSION['username_error'] = 'Empty username';
                    else
                        $_SESSION['username_error'] = 'No such user';
                }
                if (empty($_SESSION['username_error']) && empty($_SESSION['password_error'])) {
                    if ($user->active == true) {
                        $_SESSION['logged-in-user'] = $_POST['username'];
                        return $this->redirect('users/index');
                    }
                    else
                        $_SESSION['username_error'] = 'Please Activate your account before logging in.';
                }
            }
            $this->view('users/login');
        }
        
        public function verifyPassword($user, &$data) {
            if (hash('whirlpool', $_POST['password']) === $user->password) {
                $data['password_error'] = '';
                return true;
            }
            $data['password_error'] = 'Wrong password';
            return false;
        }

        public function register() {
            Controller::session_init();
            if (isset($_POST['submit'])) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['username_error'] = '';
                $_SESSION['email_error'] = '';
                $_SESSION['password_error'] = '';
                $_SESSION['confirm_password_error'] = '';
            }
            // Something has been submitted from the registration form
            if (isset($_POST['submit'])) {
                if (empty($_POST['username']))
                    $_SESSION['username_error'] = 'username can\'t be empty';
                $this->user->setUserName($_POST['username']);
                $this->user->setPassword($_POST['password']);
                $this->user->setEmail($_POST['email']);
                $this->verifyUserCredentials($_SESSION);
                if (!empty($_SESSION['email_error']) || !empty($_SESSION['password_error']) || 
                !empty($_SESSION['confirm_password_error']) || !empty($_SESSION['username_error'])
                ) {
                    return $this->view('users/register');
                }
                $this->user->save();
                if ($this->mailAccountActivationLink() === true)
                    return Controller::redirect('users/login');
            }
            else {
                // var_dump($_SESSION);//
                $this->view('users/register');
            }
        }
        /*
        **  Verifies Whether the user account is already taken or not
        **  in success it returns null, otherwise it return a data array
        **  describing the errors
        */
        private function verifyUserCredentials(&$data) {
            if (filter_var($this->user->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
                $data['email_error'] = 'invalid email';
            }
            $user = false;
            if (!empty($data['email']))
            {
                $user = $this->user->findUserByEmail($this->user->getEmail());
            }
            if (!empty($data['username']) && $user === false)
            {
                $user = $this->user->findUserByName($this->user->getUserName());
                // var_dump($user);
            }
            empty($data['username']) ? $data['username_error'] = 'Empty username' : 0;
            if ($user) {
                if ($user->email === $data['email'])
                    $data['email_error'] = 'email already registred';
                if ($user->username === $data['username'])
                    $data['username_error'] = 'username is already taken, please choose another one!';
            }
            if (preg_match('/^[a-zA-Z0-9]{8,20}$/', $this->user->getUserName()) == 0) {
                $data['username_error'] = 'username must contain alphabets and numbers and must be 8 up to 20 characters.';
            }
            $this->checkPasswordStrength($data);
            if ($this->user->getPassword() != $_POST['confirm_password'])
                $data['confirm_password_error'] = 'Passwords do not match !';
            // var_dump($data);die();
        }

        public function logout()
        {
            Controller::session_init();
            if (isset($_SESSION['logged-in-user'])) {
                unset($_SESSION['logged-in-user']);
                unset($_SESSION);
            }
            $this->redirect('home/index');
        }

        /*
        **  Confirms the user's account once the activation link
        **  is clicked
        */

        public function activate($userHashId = "") {
            $user = $this->user->findUserByHash($userHashId);
            $this->data['active'] = false;
            if ($user != null && $user->active == false) {
                $this->user->updateRecord($user->id, 'active', true);
                $this->data['active'] = true;
            }
            $this->view('users/activate', $this->data);
        }

        private function mailAccountActivationLink() {
            $user = $this->user->findUserByEmail($_SESSION['email']);
            $link = URLROOT . '/users/activate/' . $user->hash;
            $toEmail = $user->email;
			$subject = "User Registration Activation Mail";
			$txt = "Click this link to activate your account:\n <a href='" . $link . "'>Activate</a>\n";
            $mailHeaders = "From: Admin\r\n";
			$mailHeaders .= "MIME-Version: 1.0" . "\r\n";
			$mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			if(mail($toEmail, $subject, $txt, $mailHeaders))
                return true;
            return false;
        }
        

        private function checkPasswordStrength(&$data) {

            if (strlen($this->user->getPassword()) < 8)
                $data['password_error'] = 'Password too short';
            if (!preg_match("#[0-9]+#", $this->user->getPassword()))
                $data['password_error'] = 'Password must include at least one number !';
            if (!preg_match("#[a-zA-Z]+#", $this->user->getPassword()))
                $data['password_error'] = 'Password must include at least one letter !';
        }
    }
