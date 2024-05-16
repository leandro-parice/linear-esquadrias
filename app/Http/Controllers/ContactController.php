<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    public function index()
    {
        return view('site.contact');
    }

    public function send(Request $request)
    {
      $this->validate($request,[
        'name' => 'required|string|min:3',
        'email' => 'required|string|email',
        'phone' => 'required|string|min:8',
        'msg' => 'required|string|min:3',
      ]);

      $view = view('mail.contact', ['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'msg' => $request->msg ])->render();

      $mail = new PHPMailer(true);
      try {
          $mail->SMTPDebug = 0;
          $mail->isSMTP();
          $mail->Host = env('MAIL_HOST');
          $mail->SMTPAuth = true;
          $mail->Username = env('MAIL_USERNAME');
          $mail->Password = env('MAIL_PASSWORD');
          $mail->SMTPSecure = 'ssl';
          $mail->Port = env('MAIL_PORT');
          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

          $mail->setFrom(env('MAIL_USERNAME'), 'Linear Esquadrias');
          $mail->addAddress('contato@linearesquadrias.com.br', 'Contato Linear Esquadrias');
          $mail->addReplyTo($request->email, $request->name);
          $mail->isHTML(true);
          $mail->Subject = 'Contato enviado via website';
          $mail->Body = utf8_decode($view);
          //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
          $mail->send();

          $response = 'E-mail enviado com sucesso. Responderemos o mais breve possível';
      } catch (Exception $e) {
          $response = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
      }

      return view('site.contact', compact('response'));
    }
}
