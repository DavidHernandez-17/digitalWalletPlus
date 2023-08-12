<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailCodeController extends Controller
{
    public function sendCodeMail($emailCustomer, $subject, $bodyMail, $code, $document, $id_session)
    {
        try {
            $data["email"] = $emailCustomer;
            $data["subject"] = $subject;
            $data["emailBody"] = $bodyMail;
            $data["code"] = $code;
            $data["document"] = $document;
            $data["id_session"] = $id_session;

            $mailSent = Mail::send($data["emailBody"], $data, function ($message) use ($data) {
                $message->to($data["email"], $data["email"])
                        ->subject($data["subject"]);
            });

            if($mailSent){
                return true;
            }
            else{
                return false;
            }
        } catch (\Exception $th) {
            return $th->getMessage();
        }  
    }
}
