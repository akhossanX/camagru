<?php
    class Users extends Controller
    {
        private $user;

        public function __construct()
        {
            $this->user = $this->model('User');
        }

        public function index() {
            $data = [];
            $this->view('home/index', $data);
        }
        
        public function login() {
            $data = [];
            if (isset($_POST['submit'])) {
                $data['username'] = $_POST['username'];
                $data['password'] = $_POST['password'];
                $data['username_error'] = '';
                $data['password_error'] = '';
                $this->user->setUserName($_POST['username']);
                // check for user credentials conformity
                $user = $this->user->findUserByName($data['username']);
                if ($user) {
                    $this->verifyPassword($user, $data);
                } else {
                    if (empty($_POST['username']))
                        $data['username_error'] = 'Empty username';
                    else
                        $data['username_error'] = 'No such user';
                }
                if (empty($data['username_error']) && empty($data['password_error'])) {
                    $this->view('users/index', $data);
                    return true;
                }
            } else {
                $data['username'] = '';
                $data['email'] = '';
                $data['email_error'] = '';
                $data['username_error'] = '';
                $data['password_error'] = '';
            }
            $this->view('users/login', $data);
        }
        
        public function verifyPassword($user, &$data) {
            if (hash('whirlpool', $data['password']) === $user->password) {
                $data['password_error'] = '';
                return true;
            }
            $data['password_error'] = 'Wrong password';
            return false;
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
                $this->verifyUserCredentials($data);
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
            $user = $this->user->findUserByEmail($this->user->getEmail());
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

        private function verifyUserCredentials(&$data) {
            if (filter_var($this->user->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
                $data['email_error'] = 'invalid email';
            }
            if ($this->user->findUserByEmail($this->user->getEmail())) {
                $data['email_error'] = 'email already registred';
            }
            if (preg_match('/^[a-zA-Z0-9]{8,20}$/', $this->user->getUserName()) == 0) {
                $data['username_error'] = 'username must contain alphabets and numbers and must be 8 up to 20 characters.';
            }
            $this->checkPasswordStrength($data);
            if ($this->user->getPassword() != $_POST['confirm_password'])
                $data['confirm_password_error'] = 'Passwords do not match !';
        }

        private function checkPasswordStrength(&$data) {

            if (strlen($this->user->getPassword()) < 8)
                $data['password_error'] = 'Password too short';
            if (!preg_match("#[0-9]+#", $this->user->getPassword()))
                $data['password_error'] = 'Password must include at least one number !';
            if (!preg_match("#[a-zA-Z]+#", $this->user->getPassword()))
                $data['passwor_error'] = 'Password must include at least one letter !';
        }
    }
