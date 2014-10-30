<?php
require_once 'models/user.php';
class Controller_User {
    public function signin() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_SESSION['user'])) {
                    show_message('message success', 'You are already connected as ' . $_SESSION['user'] . '.');
                    include 'views/home.php';
                } else {
                    include 'views/signin.php';
                }
            break;
            case 'POST':
                if (isset($_POST['login']) && isset($_POST['password'])) {
                    $u = User::get_by_login($_POST['login']);
                    if (!is_null($u)) {
                        if ($u->password() == sha1($_POST['password'])) {
                            $_SESSION['user'] = $u->login();
                            show_message('message success', 'You are connected.');
                            header('Location: ' . BASEURL . '/index.php/note/mine');
                        } else {
                            show_message('message error', 'Wrong credentials.');
                            include 'views/signin.php';
                        }
                    } else {
                        show_message('message error', 'Wrong credentials.');
                        include 'views/signin.php';
                    }
                } else {
                    show_message('message error', 'Incomplete form.');
                    include 'views/signin.php';
                }
            break;
        }
    }
    public function signup() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_SESSION['user'])) {
                    show_message('message success', 'You are already connected as ' . $_SESSION['user'] . '.');
                    include 'views/home.php';
                } else {
                    include 'views/signup.php';
                }
            break;
            case 'POST':
                if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_check'])) {
                    $exist = User::exist_login($_POST['login']);
                    if (!$exist) {
                        if ($_POST['password'] == $_POST['password_check']) {
                            User::insert(htmlspecialchars($_POST['login']), sha1($_POST['password']), htmlspecialchars($_POST['email']));
                            show_message('message success', 'Signup of  ' . $_POST['login'] . '.');
                            include 'views/signin.php';
                        } else {
                            show_message('message error', 'Wrong password repetition.');
                            include 'views/signup.php';
                        }
                    } else {
                        show_message('message error', 'This username is already taken.');
                        include 'views/signup.php';
                    }
                } else {
                    show_message('message error', 'Incomplete form.');
                    include 'views/signup.php';
                }
            break;
        }
    }
    public function signout() {
        unset($_SESSION['user']);
        header('Location: ' . BASEURL . '/index.php');
    }
    public function account() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_SESSION['user'])) {
                    $u = User::get_by_login($_SESSION['user']);
                    $emailProfil = $u->email();
                    include 'views/account.php';
                } else {
                    include 'views/signin.php';
                }
            break;
            case 'POST':
                $u = User::get_by_login($_SESSION['user']);
                if (isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {
                    if (sha1($_POST['oldPassword']) == $u->password()) {
                        if ($_POST['newPassword'] == $_POST['newPassword2']) {
                            $u->set_password(sha1($_POST['newPassword']));
                            $u->save();
                            show_message('message success', 'Saved.');
                            include 'views/account.php';
                        } else {
                            show_message('message error', 'Wrong password verification.');
                            include 'views/account.php';
                        }
                    } else {
                        show_message('message error', 'Wrong password repetition.');
                        include 'views/account.php';
                    }
                }
                if (isset($_POST['updateMail']) && isset($_POST['updateMailPassword'])) {
                    if (sha1($_POST['updateMailPassword']) == $u->password()) {
                        $u->set_email($_POST['updateMail']);
                        $u->save();
                        include 'views/account.php';
                    } else {
                        show_message('message error', 'Wrong password verification.');
                        include 'views/account.php';
                    }
                }
                break;
            }
    }
}
