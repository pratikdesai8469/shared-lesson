<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mail;
use Carbon\Carbon;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Lesson;

class UserController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['update', 'viewProfile', 'changePassword']]);
        $this->otp = mt_rand(100000, 999999);
        $this->lesson = new Lesson();
    }

    public function checkLogin(Request $request) {
        $lessonId = null;
        if (!empty(\Request::segment(2))) { 
            $lessonId = \Request::segment(2);
            // $email = Auth::user()->email;
            if(Auth::user()){
                $userId = Auth::user()->id;
                $this->copyLession(\Request::segment(2), $userId);
                return redirect('/plan');
            }
        }
        if(Auth::check()){
            return redirect('/');
        }
        return view('website.profile.login',compact('lessonId'));
    }

    public function copyLession($lessionId, $userId) {
        try {
            $lessionId = decrypt($lessionId);
            $lession = $this->lesson->whereUserId(Auth::user()->id)->whereId($lessionId)->first();
            if (!$lession) {
                $lession = $this->lesson->whereId($lessionId)->first();
                $copyLession = $this->lesson;
                $copyLession->user_id = $userId;
                $copyLession->teacher_authors = $lession->teacher_authors;
                $copyLession->date = $lession->date;
                $copyLession->subject = $lession->subject;
                $copyLession->grade = $lession->grade;
                $copyLession->unit = $lession->unit;
                $copyLession->unit_topic = $lession->unit_topic;
                $copyLession->lesson = $lession->lesson;
                $copyLession->objective = $lession->objective;
                $copyLession->standards = $lession->standards;
                $copyLession->entry_activity = $lession->entry_activity;
                $copyLession->notes = $lession->notes;
                $copyLession->vocabulary = $lession->vocabulary;
                $copyLession->concept_demonstration = $lession->concept_demonstration;
                $copyLession->guided_practice = $lession->guided_practice;
                $copyLession->informal_assessment = $lession->informal_assessment;
                $copyLession->student_work = $lession->student_work;
                $copyLession->formal_assessment = $lession->formal_assessment;
                $copyLession->rubric = $lession->rubric;
                $copyLession->differentiation = $lession->differentiation;
                $copyLession->homework = $lession->homework;
                $copyLession->additional_resources = $lession->additional_resources;
                $copyLession->save();
                session()->flash('success', 'Copy lesson successfully.');
                return true;
            }
            session()->forget('lession_id');
            session()->flash('error', 'The lession which is shared to you is not found.');
        } catch (Exception $e) {
            log::debug($e);
        }
    }

    public function login(Request $request)
    {
        $rule = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $email = strtolower($request->email);
        if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
            $user = User::whereEmail($email)->whereIsVerified(1)->first();
            if ($user) {
                if ($request->is_subscribe) {
                    User::whereEmail($request->email)->update(['is_subscribe' => 1]);
                }
                if (isset($request->lession_id) && !empty($request->lession_id)) {
                    $this->copyLession($request->lession_id, $user->id);
                    return redirect('/plan');
                }
                return redirect()->intended('/');
            }
            Auth::logout();
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
                $message->from('info@shared-lessons.org', 'Lession Planning');
                $message->to($email)->subject('OTP from Lession Planning');
            });
            // session(['email' => $email]);
            $sessionData = [];
            $sessionData['email'] = $email;
            if (isset($request->lession_id) && !empty($request->lession_id)) {
                $sessionData['lession_id'] = $request->lession_id;
            }
            session($sessionData);
            session()->flash('error', 'Your email address is not verified.Please verify email address to continue using website');
            return redirect('/otp');
        }
        session()->flash('error', 'Invalid login credentials');
        return redirect()->back()->withInput();
    }

    public function sendOtp(Request $request)
    {
        $otp = $this->otp;
        $email = $request->email;
        if (!$email) {
            return ['status' => 'false'];
        }
        User::whereEmail($email)->update([
            'otp' => $otp,
            'email_verified_at' => null
        ]);
        $user = User::whereEmail($email)->first();
        $data['name'] = ucwords(strtolower($user->name));
        $data['otp'] = $otp;
        Mail::send('emails.send_otp', $data, function ($message) use ($email) {
            $message->from('info@shared-lessons.org', 'Lession Planning');
            $message->to($email)->subject('OTP from Lession Planning');
        });
        return ['status' => 'true'];
    }

    public function register(Request $request)
    {
        $rule = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:100',
            'password' => 'required|confirmed|min:6|max:15',
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $email = strtolower($request->email);
        $isUserExists = User::whereEmail($email)->first();
        if ($isUserExists) {
            if ($isUserExists->email == $email && $isUserExists->is_verified == 0) {
                $otp = $this->otp;
                User::whereEmail($email)->update([
                    'otp' => $otp,
                    'email_verified_at' => null
                ]);
                $data['name'] = ucwords(strtolower($isUserExists->name));
                $data['otp'] = $otp;
                Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                    $message->from('info@shared-lessons.org', 'Lession Planning');
                    $message->to($email)->subject('OTP from Lession Planning');
                });
                session()->flash('error', 'Your email address is not verified.Please verify email address to continue');
                // session(['email' => $email]);
                $sessionData = [];
                $sessionData['email'] = $email;
                if (isset($request->lession_id) && !empty($request->lession_id)) {
                    $sessionData['lession_id'] = $request->lession_id;
                }
                session($sessionData);
                return redirect('/otp');
            } else {
                session()->flash('error', 'The email has already been taken.');
                return redirect()->back()->withInput();
            }
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $email;
        $user->password = bcrypt($request->password);
        $user->otp = $this->otp;
        $user->is_subscribe = $request->is_subscribe ? 1 : 0;
        $user->save();
        // Auth::login($user);
        // if (isset($request->lession_id) && !empty($request->lession_id)) {
        //     $this->copyLession($request->lession_id, $user->id);
        // }
        $data['name'] = ucwords(strtolower($user->name));
        $data['otp'] = $user->otp;
        Mail::send('emails.send_otp', $data, function ($message) use ($email) {
            $message->from('info@shared-lessons.org', 'Lession Planning');
            $message->to($email)
                ->subject('OTP from Lession Planning');
        });
        session()->flash('success', 'OTP has been sent to your email address');

        $sessionData = [];
        $sessionData['email'] = $email;
        if (isset($request->lession_id) && !empty($request->lession_id)) {
            $sessionData['lession_id'] = $request->lession_id;
        }
        session($sessionData);
        return redirect('/otp');
        // return $this->sendResponse(2, 'OTP has been sent to your email address', null, 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|max:6',
            'email' => 'required|email|max:100',
        ]);
        $otp = $request->otp;
        $email = strtolower($request->email);
        if (User::whereOtpAndEmail($otp, $email)->exists()) {
            User::whereOtpAndEmail($otp, $email)->update(['otp' => null, 'is_verified' => 1, 'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            session()->flash('success', 'User successfully verified');
            if (isset($request->lession_id) && !empty($request->lession_id)) {
                return redirect('/web-login/'. $request->lession_id);
            }
            return redirect('/web-login');
        }
        session()->flash('error', 'Invalid OTP');
        return back();
    }

    public function viewProfile()
    {
        $user = Auth::user();
        return view('website.profile.view_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $email = strtolower($request->email);
        $rule = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'. $user->id,
        ];

        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $user->name = $request->name;
        $user->otp = $this->otp;
        $status = 0 ;
        if ($user->email  != $email) {
            $data['name'] = ucwords(strtolower($user->name));
            $data['otp'] = $user->otp;
            Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                $message->from('info@shared-lessons.org', 'Lession Planning' );
                $message->to($email)->subject('OTP from Lession Planning');
            });
            $user->email_verified_at = null;
            $user->is_verified = 0;
            $status = 1;
        }
        $user->email = $email;
        $user->save();
        session()->flash('success', 'Update profile successfully');
        if ($status) {
            session(['email' => $user->email]);
            return redirect('/otp');
        }     
        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|max:15|required',
        ]);     
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) { 
            User::whereEmail($user->email)->update(['password' => bcrypt($request->password)]);
            session()->flash('success', 'Password successfully changed');
            return redirect()->back();
        }
        return redirect()->back()->withInput()->withErrors(['old_password' => 'Old password is wrong']);
    }


    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
        ]);     
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $user = User::whereEmail(strtolower($request->email))->first();
        if ($user) {
            $otp = $this->otp;
            User::whereEmail(strtolower($request->email))->update(['otp' => $otp]);
            $email = $user->email;
            $data['name'] = ucwords(strtolower($user->name));
            $data['otp'] = $otp;
            Mail::send('emails.send_otp', $data, function ($message) use ($email) {
                $message->from('info@shared-lessons.org', 'Lession Planning' );
                $message->to($email)->subject('OTP from Lession Planning');
            });
            session()->flash('success', 'OTP successfully sent to your registered emails');
            return redirect()->back();
        } 
        session()->flash('error', 'User does not exists');
        return redirect()->back();
    }


   public function resetPassword(Request $request)
   {
        $request->validate([
            'otp' => 'required|max:6',
            'email' => 'required|email|max:100',
        ]);
        $otp = $request->otp;
        $email = strtolower($request->email);
        if (User::whereOtpAndEmail($otp, $email)->exists()) {
            User::whereOtpAndEmail($otp, $email)->update(['otp' => null, 'is_verified' => 1, 'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            session()->flash('success', 'User successfully verified');
            return redirect('/web-login');
        }
        session()->flash('error', 'Invalid OTP');
        return back();
   }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
}
