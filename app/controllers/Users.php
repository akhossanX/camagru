<?php
    class Users extends Controller
    {
        private $userModel;
        private $data = Array();

        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function index() {
            $this->view('home/index', ['title' => 'Users default page']);
        }

        public function register() {
            $this->data = [
                'user' => $this->userModel,
                'username_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];
            // Something has been submitted from the registration form
            if (isset($_POST['submit'])) {
                if (empty($_POST['username']))
                    $this->data['username_error'] = 'username can\'t be empty';
                $this->userModel->setUserName($_POST['username']);
                $this->userModel->setPassword($_POST['password']);
                $this->userModel->setEmail($_POST['email']);
                $this->data['user'] = $this->userModel;
                $this->verifyUserCredentials();
                if ($this->data['email_error'] || $this->data['password_error'] 
                    || $this->data['confirm_password_error'] || $this->data['username_error']
                    ){
                    return $this->view('users/register', $this->data);
                }
                $this->userModel->save();
                $this->view('users/confirm_account', $this->data);
            }
            else {
                return $this->view('/users/register', $this->data);
            }
        }
        
        /*
        **  Verifies Whether the user account is already taken or not
        **  in success it returns null, otherwise it return a data array
        **  describing the errors
        */

        public function verifyUserCredentials() {
            if (filter_var($this->userModel->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
                $this->data['email_error'] = 'invalid email';
            }
            if ($this->userModel->findUserByEmail()) {
                $this->data['email_error'] = 'email already registred';
            }
            $this->checkPasswordStrength();
            if ($this->userModel->getPassword() != $_POST['confirm_password'])
                $this->data['confirm_password_error'] = 'Passwords do not match !';
        }

        public function checkPasswordStrength() {

            if (strlen($this->userModel->getPassword()) < 8)
                $this->data['password_error'] = 'Password too short';
            if (!preg_match("#[0-9]+#", $this->userModel->getPassword()))
                $this->data['password_error'] = 'Password must include at least one number !';
            if (!preg_match("#[a-zA-Z]+#", $this->userModel->getPassword()))
                $this->data['passwor_error'] = 'Password must include at least one letter !';
        }

        public function login() {
            $this->view('users/login');
        }
    }