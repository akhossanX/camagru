<?php
    class Users extends Controller
    {
        private $user;

        public function __construct() {
            $this->user = $this->model('User');
            $this->sanitizeArray($_POST);
            Controller::session_init();
        }

        public function index() {
            if (isset($_SESSION['logged-in-user'])) {
                $this->redirect('images/camera');
            }
            else
                $this->redirect('home/index');
        }
        
        public function login() {
            if (isset($_POST['login'])) {
                $_SESSION['username_error'] = '';
                $_SESSION['password_error'] = '';
                $_SESSION['username'] = $_POST['username'];
            } else {
                $_SESSION = ['username' => '', 'username_error' => '', 'password_error' => ''];
            }
            if (isset($_POST['login'])) {
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
                        $_SESSION['logged-in-user'] = $user;
                        return $this->redirect('users/index');
                    }
                    else
                        $_SESSION['username_error'] = 'Please Activate your account before logging in.';
                }
            }
            $this->view('users/login');
        }
        
        

        public function register() {
            $_SESSION['username'] = "";
            $_SESSION['email'] = "";
            $_SESSION['username_error'] = '';
            $_SESSION['email_error'] = '';
            $_SESSION['password_error'] = '';
            $_SESSION['confirm_password_error'] = '';
            if (isset($_POST['register'])) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['email'] = $_POST['email'];
                if (empty($_POST['username']))
                    $_SESSION['username_error'] = 'username can\'t be empty';
                $this->user->setUserName($_POST['username']);
                $this->user->setPassword($_POST['password']);
                $this->user->setEmail($_POST['email']);
                $this->verifyRegisterCredentials($_SESSION);
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
                $this->view('users/register');
            }
        }
        /*
        **  Verifies Whether the user account is already taken or not
        **  in success it returns null, otherwise it return a data array
        **  describing the errors
        */
        private function verifyRegisterCredentials(&$data) {
            $user = false;
            $user = $this->user->findUserByEmail($this->user->getEmail());
            $data['email_error'] = validateEmail($this->user->getEmail());
            $data['username_error'] = validateUserName($this->user->getUserName());
            if ($user) {
                if ($user->email === $data['email'])
                    $data['email_error'] = 'email already registered';
                if ($user->username === $data['username'])
                    $data['username_error'] = 'username is already taken, please choose another one!';
            }
            $data['password_error'] = validatePassword($this->user->getPassword());
            if ($this->user->getPassword() != $_POST['confirm_password'])
                $data['confirm_password_error'] = 'Passwords do not match !';
        }

        public function logout() {
            if (isset($_SESSION['logged-in-user'])) {
                session_destroy();
            }
            $this->redirect('home/index');
        }

        /*
        **  Manage user profile editing
        */

        public function profile() {
            // var_dump($_SESSION['logged-in-user']->password);
            $_SESSION['username_error'] = '';
            $_SESSION['email_error'] = '';
            $_SESSION['current_password_error'] = '';
            $_SESSION['new_password_error'] = '';
            $_SESSION['confirm_new_password_error'] = '';
            if (isAuthentified()) {
                if (isset($_POST['save'])) {
                    $_SESSION['username_error'] = validateUserName($_POST['username']);
                    $_SESSION['email_error'] = validateEmail($_POST['email']);
                    if (hash('whirlpool', $_POST['current_password']) !== $_SESSION['logged-in-user']->password) {
                        $_SESSION['current_password_error'] = "wrong password";
                    }
                    if (isset($_POST["new_password"])) {
                        if ($_POST['new_password'] !== "") {
                            $_SESSION['new_password_error'] = validatePassword($_POST["new_password"]);
                            if ($_POST["confirm_new_password"] !== $_POST["new_password"]) {
                                $_SESSION['confirm_new_password_error'] = "Passwords do not match";
                            }
                        } else if ($_POST["confirm_new_password"] !== "") {
                            $_SESSION["confirm_new_password_error"] = "new password must be set first";
                        }
                    }
                    if (hasErrors($_SESSION) === false) {
                        $this->user->setUserName($_POST['username']);
                        $this->user->setPassword($_POST["new_password"]);
                        $this->user->setEmail($_POST["email"]);
                        $this->user->setNotify(isset($_POST["notify"]) ? 1 : 0);
                        $this->user->updateColumn($_SESSION['logged-in-user']->id, "username", $this->user->getUserName());
                        $this->user->updateColumn($_SESSION['logged-in-user']->id, "email", $this->user->getEmail());
                        if ($this->user->getPassword() !== "") {
                            $newPassword = hash('whirlpool', $this->user->getPassword());
                            $this->user->updateColumn($_SESSION['logged-in-user']->id, "password", $newPassword);
                            $_SESSION['logged-in-user']->password = $newPassword;
                        }
                        $this->user->updateColumn($_SESSION['logged-in-user']->id, "notify", $this->user->getNotify());
                        $_SESSION['logged-in-user']->username = $this->user->getUserName();
                        $_SESSION['logged-in-user']->email = $this->user->getEmail();
                        $_SESSION['logged-in-user']->notify = $this->user->getNotify();
                        $this->redirect("users/index");
                    } else {
                        $this->view("users/profile");
                    }
                } else {
                    $this->view("users/profile");
                }
            } else {
                $this->redirect("home/index");
            }
        }

        private function verifyPassword($user, &$data) {
            if (hash('whirlpool', $_POST['password']) === $user->password) {
                $data['password_error'] = '';
                return true;
            }
            $data['password_error'] = 'Wrong password';
            return false;
        }



        /*
        **  Confirms the user's account once the activation link
        **  is clicked
        */

        public function activateAccount($userHashId = "") {
            $user = $this->user->findUserByHash($userHashId);
            $_SESSION['active'] = false;
            if ($user) {
                if ($user->active == false) {
                    $this->user->updateColumn($user->id, 'active', true);
                    $_SESSION['active'] = true;
                }
            }
            else {
                $_SESSION['active'] = 'Invalid activation token';
            }
            $this->view('users/activate');
        }

        private function mailAccountActivationLink() {
            $user = $this->user->findUserByEmail($_SESSION['email']);
            $link = URLROOT . '/users/activate-account/' . $user->hash;
            $toEmail = $user->email;
			$subject = "User Registration Activation Mail";
			$txt = "Click this link to activate your account:\n <a href='" . $link . "'>Activate</a>\n";
            $mailHeaders = "From: abdelilah.khossan@gmail.com\r\n";
			$mailHeaders .= "MIME-Version: 1.0" . "\r\n";
			$mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			if(mail($toEmail, $subject, $txt, $mailHeaders))
                return true;
            return false;
        }
        
        

        public function forgotPassword() {
            if (isset($_POST) && isset($_POST['forgot'])) {
                $email = $_POST['email'];
                if (empty($email)) {
                    $_SESSION['email_error'] = "Email can't be empty";
                    return $this->view('users/forgot_password');
                }
                //send password reset link to email
                $user = $this->user->findUserByEmail($email);
                if ($user && $user->active) {
                    $token = md5(uniqid($user->username));
                    $this->user->updateColumn($user->id, 'hash', $token);
                    $link = URLROOT . '/users/reset-password/' . $user->id . '/' . $token;
                    $subject = "Password reset";
                    $txt = "Click this link to reset your password:\n <a href='" . $link . "'>Reset Password</a>\n";
                    $mailHeaders = "From: abdelilah.khossan@gmail.com\r\n";
                    $mailHeaders .= "MIME-Version: 1.0" . "\r\n";
                    $mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    mail($email, $subject, $txt, $mailHeaders);
                }
                $this->redirect('users/login');
            } else {
                $_SESSION['email_error'] = '';
                $this->view('users/forgot_password');
            }
        }

        public function resetPassword($id=null, $token=null) {
            if (isset($_POST) && isset($_POST['reset'])) {
                if (empty($_POST['password']))
                    $_SESSION['password_error'] = "Empty password";
                elseif (empty($_POST['confirm_password']))
                    $_SESSION['confirm_password_error']  = "passwords do not match";
                else {
                    $user = $this->user->findUserById($_POST['id']);
                    $password = hash('whirlpool', $_POST['password']);
                    $this->user->updateColumn($_POST['id'], 'password', $password);
                    // prevent another reset to the password using the same token
                    $this->user->updateColumn($_POST['id'], 'hash', ""); 
                    return $this->redirect('users/login');
                }
                $this->view('users/reset_password');
            } elseif ($id && $token) {
                $user = $this->user->findUserById($id);
                if ($user && $user->hash === $token) {
                    $_SESSION['id'] = $id;
                    $_SESSION['password_error'] = '';
                    $_SESSION['confirm_password_error'] = '';
                    $this->view('users/reset_password'); // Load reset password view
                } else {
                    $this->redirect('users/forgot-password'); // redirect to forgot password form
                }
            } else  {
                $this->redirect('users/login'); // redirect to login page
            }
        }
    }
