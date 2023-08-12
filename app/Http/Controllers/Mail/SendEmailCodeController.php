<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailCodeController extends Controller
{
    public function sendCodeMail($emailCustomer, $subject, $bodyMail, $code, $user_id)
    {
        try {
            $data["email"] = $emailCustomer;
            $data["subject"] = $subject;
            $data["emailBody"] = $bodyMail;
            $data["code"] = $code;
            $data["user_id"] = $user_id;

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
