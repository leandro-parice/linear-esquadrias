<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\SendResetEmail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        //$this->notify(new SendResetEmail($token));

        $view = view('mail.reset-password', ['link' => route('password.reset', $token)])->render();
        $to = $this->email;

        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = env('MAIL_HOST'); // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = env('MAIL_USERNAME'); // SMTP username
            $mail->Password = env('MAIL_PASSWORD'); // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = env('MAIL_PORT'); // TCP port to connect to

            //Recipients
            $mail->setFrom('site@artemisjau.com.br');
            $mail->addReplyTo('site@artemisjau.com.br');
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Esqueci minha senha';
            $mail->Body = utf8_decode($view);

            $mail->send();
        } catch (Exception $e) {
            dd('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
        }
    }

    public function showType()
    {
        switch ($this->type) {
            case 'superadmin': $typeString = 'Superadministrador'; break;
            case 'admin': $typeString = 'Administrador'; break;
            default: $typeString = 'Administrador'; break;
        }

        return $typeString;
    }

    public function showStatus()
    {
        $statusString = ($this->status) ? 'Ativo' : 'Inativo';
        return $statusString;
    }
}
