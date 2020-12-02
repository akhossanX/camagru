<?php
    class Users extends Controller
    {
        private $user;

        public function __construct()
        {
            $this->user = $this->model('User');
        }

        public function index() {
            $this->view('home/index', ['title' => 'Users default page']);
        }

        public function register() {
            $data = [
                'user' => $this->user,
                'username' => '',
                'email' => '',
                'username_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];
            // Something has been submitted from the registration form
            if (isset($_POST['submit'])) {
                if (empty($_POST['username']))
                    $data['username_error'] = 'username can\'t be empty';
                $this->user->setUserName($_POST['username']);
                $this->user->setPassword($_POST['password']);
                $this->user->setEmail($_POST['email']);
                $data['user'] = $this->user;
                // $this->verifyUserCredentials();
                if ($data['email_error'] || $data['password_error'] 
                    || $data['confirm_password_error'] || $data['username_error']
                    ) {
                    return $this->view('users/register', $data);
                }
                $this->user->save();
                if ($this->mailAccountActivationLink() == true)
                    $this->view('users/login', $data);
            }
            else {
                $this->view('/users/register', $data);
            }
        }

        public function login() {
            $data = [
                'username' => '',
                'email' => '',
                'username_error' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            if (isset($_POST['submit'])) {
                $data['username'] = $_POST['username'];
                $data['email'] = $_POST['email'];
                // check for user credentials conformity
            } else {
                $data['username'] = '';
                $data['email'] = '';
                $data['email_error'] = '';
                $data['username_error'] = '';
                $data['password_error'] = '';
            }
            $this->view('users/login', $data);
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
            $user = $this->user->findUserByEmail();
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
        
        /*
        **  Verifies Whether the user account is already taken or not
        **  in success it returns null, otherwise it return a data array
        **  describing the errors
        */

        private function verifyUserCredentials() {
            if (filter_var($this->user->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
                $this->data['email_error'] = 'invalid email';
            }
            if ($this->user->findUserByEmail()) {
                $this->data['email_error'] = 'email already registred';
            }
            $this->checkPasswordStrength();
            if ($this->user->getPassword() != $_POST['confirm_password'])
                $this->data['confirm_password_error'] = 'Passwords do not match !';
        }

        private function checkPasswordStrength() {

            if (strlen($this->user->getPassword()) < 8)
                $this->data['password_error'] = 'Password too short';
            if (!preg_match("#[0-9]+#", $this->user->getPassword()))
                $this->data['password_error'] = 'Password must include at least one number !';
            if (!preg_match("#[a-zA-Z]+#", $this->user->getPassword()))
                $this->data['passwor_error'] = 'Password must include at least one letter !';
        }
    }
