<?php

include_once "Controllers/Controller.php";
include_once "Models/User.php";
require_once __DIR__ . '/../lib/RobThree/Auth/TwoFactorAuth.php';
require_once __DIR__ . '/../lib/RobThree/Auth/Algorithm.php';

require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Qr/IQRCodeProvider.php';
require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Qr/BaseHTTPQRCodeProvider.php';
require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Qr/ImageChartsQrCodeProvider.php';

require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Rng/IRNGProvider.php';
require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Rng/CSRNGProvider.php';

require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Time/ITimeProvider.php';
require_once __DIR__ . '/../lib/RobThree/Auth/Providers/Time/LocalMachineTimeProvider.php';

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Algorithm;
use RobThree\Auth\Providers\Qr\ImageChartsQrCodeProvider;
use RobThree\Auth\Providers\Rng\CSRNGProvider;
use RobThree\Auth\Providers\Time\LocalMachineTimeProvider;

class LoginController extends Controller {
    function route() {
        global $controller;
        $controller = ucfirst($controller);
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : "login";

        $qrcodeProvider = new ImageChartsQrCodeProvider();
        $rngProvider = new CSRNGProvider();
        $timeProvider = new LocalMachineTimeProvider();

        $tfa = new TwoFactorAuth(
            $qrcodeProvider,
            'Depanneur du Souvenir',
            6,
            30,
            Algorithm::Sha1,
            $rngProvider,
            $timeProvider
        );

        if ($action == "login") {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $data = User::authenticate($_POST['username'], $_POST['password']);
                if (is_null($data)) {
                    $_SESSION['login_error'] = "Invalid username or password.";
                    $this->render("login", "login");
                } else {
                    $secret = User::getTwoFASecret($data->id);
                    if (!$secret) {
                        $secret = $tfa->createSecret();
                        User::setTwoFASecret($data->id, $secret);
                        $qrCodeUrl = $tfa->getQRCodeImageAsDataUri($data->username, $secret);
                        $_SESSION['pending_user_id'] = $data->id;
                        $_SESSION['pending_secret'] = $secret;
                        $this->render("login", "setup", ['qrCodeUrl' => $qrCodeUrl]);
                    } else {
                        $_SESSION['pending_user_id'] = $data->id;
                        $this->render("login", "verify");
                    }
                }
            } else {
                $this->render("login", "login");
            }
        }
        elseif ($action == "verify") {
            $code = $_POST['code'];
            $userId = $_SESSION['pending_user_id'];
            $secret = User::getTwoFASecret($userId);

            if (preg_match('/^\d{6}$/', $code) && $tfa->verifyCode($secret, $code, 1) ) {
                // User::clearTwoFASecret($userId);
                $_SESSION['user_id'] = $userId;
                $_SESSION['token'] = bin2hex(random_bytes(16));
                $_SESSION['role'] = User::getRole($userId);
                unset($_SESSION['pending_user_id']);
                header('Location: ' . dirname($path) . "/product/list");
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid 2FA code.";
                $this->render("login", "verify");
            }
        }
        elseif ($action == "resend") {
            $userId = $_SESSION['pending_user_id'] ?? null;
            if ($userId) {
                $secret = $tfa->createSecret();
                User::setTwoFASecret($userId, $secret);
                $_SESSION['pending_secret'] = $secret;
                $qrCodeUrl = $tfa->getQRCodeImageAsDataUri(User::getUsername($userId), $secret);
                $this->render("login", "setup", ['qrCodeUrl' => $qrCodeUrl]);
            } else {
                header("Location: " . dirname($path) . "/login/setup");
                exit;
            }
        }
       elseif ($action == "reset") {
            $userId = $_SESSION['pending_user_id'] ?? null; 
                if ($userId) {
                    User::clearTwoFASecret($userId);
                    unset($_SESSION['pending_user_id']);
                    unset($_SESSION['pending_secret']);
                }
                header("Location: " . dirname($path) . "/login/login");
                exit;
            }            
        elseif ($action == "logout") {
            session_unset();
            session_destroy();
            header("Location: " . dirname($path) . "/login/login");
            exit;
        }
    }
}
