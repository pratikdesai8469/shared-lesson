<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Base\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserSession;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    private $apiToken;
    private $otp;
    public function __construct(){
        $this->apiToken = uniqid(base64_encode(Str::random(80)));
        $this->otp = mt_rand(100000, 999999);
    }


    public function login(Request $request) {

    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
        	return $this->sendResponse(0, $validator->errors()->first(), null, 401);
    	}
        $email = $request->email;

        if(Auth::attempt(['email' => $email, 'password' => $request->password])){
            $user = User::whereEmail($email)->whereIsVerified(1)->first();
            if ($user) {
                $user->token = $this->apiToken;
                UserSession::updateOrCreate([
                    'user_id' => $user->id
                ], [
                    'token' => $user->token
                ]);

                return $this->sendResponse(1, 'Login successfully', $user, 200);
            }

            $otp = $this->otp;
            $email = $request->email;
            User::whereEmail($email)->update([
                'otp' => $otp,
                'email_verified_at' => null
            ]);

            $user = User::whereEmail($email)->first();
            $data['name'] = ucwords(strtolower($user->name));
            $data['otp'] = $otp;
            Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                $message->from('jaydip.f1996@gmail.com', 'Lession Planning' );
                $message->to($email)
                ->subject('OTP from Lession Planning');
            });

            return $this->sendResponse(2, 'Your email address is not verified.Please verify email address to continue using app.', null, 401);
        }
    	return $this->sendResponse(0, 'Invalid login credentials', null, 401);
    }

    public function register(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:15',
        ]);

        if($validator->fails()){
            return $this->sendResponse(0, $validator->errors()->first(), null, 422);
        }

        $email = $request->email;
        $isUserExists = User::whereEmail($email)->first();
        if ($isUserExists != null) {
            if ($isUserExists->email == $email && $isUserExists->is_verified == 1) {
                return $this->sendResponse(0, 'The email has already been taken.', null, 422);
            } else if ($isUserExists->email == $email && $isUserExists->is_verified == 0) {
                $otp = $this->otp;
                User::whereEmail($email)->update([
                    'otp' => $otp,
                    'email_verified_at' => null
                ]);
                $data['name'] = ucwords(strtolower($isUserExists->name));
                $data['otp'] = $otp;
                $isMailSend = Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                    $message->from('jaydip.f1996@gmail.com', 'Lession Planning' );
                    $message->to($email)->subject('OTP from Lession Planning');
                });

                return $this->sendResponse(2, 'Your email address is not verified.Please verify email address to continue using app.', null, 401);
            }
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->otp = $this->otp;
        $user->save();

        $email = $user->email;
        $data['name'] = ucwords(strtolower($user->name));
        $data['otp'] = $user->otp;
        Mail::send('emails.send_otp', $data, function ($message) use ($email) {
            $message->from('jaydip.f1996@gmail.com', 'Lession Planning' );
            $message->to($email)
            ->subject('OTP from Lession Planning');
        });

        return $this->sendResponse(2, 'OTP has been sent to your email address', null, 200);
    }


    public function editProfile(Request $request) {
        $user = $this->getUser($request->header('Authorization'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
        ]);

        if($validator->fails()){
            return $this->sendResponse(0, $validator->errors()->first(), null, 422);
        }
        $status = 1;
        $message = 'Update profile successfully';
        $user->name = $request->name;
        $user->otp = $this->otp;
        $email = $request->email;
        if ($user->email != $email) {

            $data['name'] = ucwords(strtolower($user->name));
            $email = $request->email;
            $data['otp'] = $user->otp;
            Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                $message->from('jaydip.f1996@gmail.com', 'Lession Planning' );
                $message->to($email)
                ->subject('OTP from Lession Planning');
            });
            $user->email_verified_at = null;
            $user->is_verified = 0;
            $status = 2;
            $message = 'OTP has been sent to your email address.';
        }
        $user->email = $email;
        $user->save();

        return $this->sendResponse($status, $message, $user, 200);
    }

    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);

        if($validator->fails()){
            return $this->sendResponse(0, $validator->errors()->first(), null, 422);
        }

        $user = User::whereEmail($request->email)->first();
        if ($user) {
            $otp = $this->otp;
            User::whereEmail($request->email)->update([
                'otp' => $otp
            ]);

            $email = $user->email;
            $data['name'] = ucwords(strtolower($user->name));
            $data['otp'] = $otp;
            Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                $message->from('jaydip.f1996@gmail.com', 'Lession Planning' );
                $message->to($email)
                ->subject('OTP from Lession Planning');
            });
            return $this->sendResponse(1, 'OTP successfully sent to your registered email', null, 200);
        }

        return $this->sendResponse(0, 'User does not exists', null, 401);
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'min:6|max:15|required',
        ]);

        if($validator->fails()){
            return $this->sendResponse(0, $validator->errors()->first(), null, 422);
        }

        $user = User::whereEmail($request->email)->first();
        if ($user) {
            User::whereEmail($request->email)->update([
                'password' => bcrypt($request->password)
            ]);

            $user->token = $this->apiToken;

            UserSession::updateOrCreate([
                'user_id' => $user->id
            ], [
                'token' => $user->token
            ]);
            return $this->sendResponse(1, 'Password successfully changed', $user, 200);
        }

        return $this->sendResponse(0, 'User does not exists', null, 401);
    }

    public function resendOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);

        if($validator->fails()){
            return $this->sendResponse(0, $validator->errors()->first(), null, 401);
        }

        $email = $request->email;
        $user = User::whereEmail($email)->first();
        if($user){
            $otp = $this->otp;
            User::whereEmail($request->email)->update([
                'otp' => $otp
            ]);
            $data['name'] = ucwords(strtolower($user->name));
            $data['otp'] = $otp;
            Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                $message->from('jaydip.f1996@gmail.com', 'Lession Planning' );
                $message->to($email)
                ->subject('OTP from Lession Planning');
            });
            return $this->sendResponse(1, 'OTP has been successfully send', null, 200);
        }
        return $this->sendResponse(0, 'User does not exists', null, 401);
    }

    public function verifyOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|max:6',
            'email' => 'required|email|max:100',
            'type' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendResponse(0, $validator->errors()->first(), null, 422);
        }

        $otp = $request->otp;
        $email = $request->email;
        if (User::whereOtpAndEmail($otp, $email)->exists()) {
            if (User::whereOtpAndEmail($otp, $email)->update(['otp' => null, 'is_verified' => 1, 'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')])) {
                $user = User::whereEmail($email)->first();

                if ($request->type == 1) {
                    $user->token = UserSession::whereUserId($user->id)->value('token');
                }else{
                    $user->token = $this->apiToken;
                    UserSession::updateOrCreate([
                        'user_id' => $user->id
                    ], [
                        'token' => $user->token
                    ]);
                }
                return $this->sendResponse(1, 'User successfully verified', $user, 200);
            }   
            return $this->sendResponse(0, 'Internal Server Error', null, 500);
        }
        return $this->sendResponse(0, 'Invalid OTP', null, 401);
    }

    public function logout(Request $request) {
        UserSession::whereToken($request->header('Authorization'))->delete();
        return $this->sendResponse(1, 'Successfully logout', null, 200);
    }
}
