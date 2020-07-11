<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Base\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Lession;
use Validator;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LessionController extends ApiController {

    public function index(Request $request) {
        $user = $this->getUser($request->header('Authorization'));
        $lession = Lession::whereUserId($user->id)->get();

        return $this->sendResponse(1, 'Lession Successfully get', $lession, 200);
           
    }

    public function add(Request $request) {
    	$validator = Validator::make($request->all(), [
            'unit_title' => 'required|max:250'
        ]);

        if($validator->fails()){
        	return $this->sendResponse(0, $validator->errors()->first(), null, 422);
    	}

    	$user = $this->getUser($request->header('Authorization'));
    	$lession = new Lession;
    	$lession->user_id = $user->id;
    	$lession->unit_title = $request->unit_title;
    	$lession->objective = $request->objective;
    	$lession->standard = $request->standard;
    	$lession->standard_duration = $request->standard_duration;
    	$lession->starter = $request->starter;
    	$lession->starter_duration = $request->starter_duration;
    	$lession->mini_lession = $request->mini_lession;
    	$lession->mini_lession_duration = $request->mini_lession_duration;
        $lession->guided_practice  = $request->guided_practice;
        $lession->guided_practice_duration  = $request->guided_practice_duration;
        $lession->informal_assessment  = $request->informal_assessment;
        $lession->informal_assessment_duration  = $request->informal_assessment_duration;
        $lession->student_work  = $request->student_work;
        $lession->student_work_duration = $request->student_work_duration;
        $lession->student_work_option_1  = $request->student_work_option_1;
        $lession->student_work_option_1_duration  = $request->student_work_option_1_duration;
        $lession->student_work_option_2  = $request->student_work_option_2;
        $lession->student_work_option_2_duration  = $request->student_work_option_2_duration;
        $lession->extra_credit  = $request->extra_credit;
        $lession->extra_credit_duration  = $request->extra_credit_duration;
        $lession->differentiation  = $request->differentiation;
        $lession->differentiation_duration  = $request->differentiation_duration;
        $lession->materials  = $request->materials;
        $lession->materials_duration = $request->materials_duration;
    	$lession->save();


        $number = $lession->id;
        $digits = strlen($number);
        if ($digits != 7) {
            $number = $number . substr(str_shuffle(str_repeat("0123456789", (7 - $digits))), 0, (7 - $digits));
        }

        Lession::whereId($lession->id)->update([
            'unit_id' => (int)$number
        ]);
        $lession->unit_id = (int)$number;
    	return $this->sendResponse(1, 'Lession Successfully added', $lession, 200);

	}

	public function edit(Request $request) {
    	$validator = Validator::make($request->all(), [
            'unit_title' => 'required|max:250'
        ]);

        if($validator->fails()){
        	return $this->sendResponse(0, $validator->errors()->first(), null, 422);
    	}


    	if (Lession::whereId($request->id)->exists()) {
			$user = $this->getUser($request->header('Authorization'));
    		$lession = Lession::whereId($request->id)->first();

    		if ($user->id == $lession->user_id) {
		    	$lession->unit_title = $request->unit_title;
		    	$lession->objective = $request->objective;
		    	$lession->standard = $request->standard;
		    	$lession->standard_duration = $request->standard_duration;
		    	$lession->starter = $request->starter;
		    	$lession->starter_duration = $request->starter_duration;
		    	$lession->mini_lession = $request->mini_lession;
		    	$lession->mini_lession_duration = $request->mini_lession_duration;
                $lession->guided_practice  = $request->guided_practice;
                $lession->guided_practice_duration  = $request->guided_practice_duration;
                $lession->informal_assessment = $request->informal_assessment;
                $lession->informal_assessment_duration  = $request->informal_assessment_duration;
                $lession->student_work = $request->student_work;
                $lession->student_work_duration = $request->student_work_duration;
                $lession->student_work_option_1  = $request->student_work_option_1;
                $lession->student_work_option_1_duration  = $request->student_work_option_1_duration;
                $lession->student_work_option_2  = $request->student_work_option_2;
                $lession->student_work_option_2_duration  = $request->student_work_option_2_duration;
                $lession->extra_credit  = $request->extra_credit;
                $lession->extra_credit_duration  = $request->extra_credit_duration;
                $lession->differentiation  = $request->differentiation;
                $lession->differentiation_duration  = $request->differentiation_duration;
                $lession->materials  = $request->materials;
                $lession->materials_duration = $request->materials_duration;
                $lession->save();

		    	return $this->sendResponse(1, 'Lession Successfully updated', $lession, 200);
    		}
    		return $this->sendResponse(0, 'Access forbiddon', null, 403);
    	}
    	return $this->sendResponse(0, 'Lession not found', null, 401);
	}

    public function view(Request $request, $id) {
        $user = $this->getUser($request->header('Authorization'));
        $lession = Lession::whereId($request->id)->first();
        if ($lession) {
            if ($user->id == $lession->user_id) {
                return $this->sendResponse(1, 'Lession Successfully get', $lession, 200);
            }
            return $this->sendResponse(0, 'Access forbiddon', null, 403);
        }
        return $this->sendResponse(0, 'Lession not found', null, 401);
    }

    public function delete(Request $request, $id) {
        $user = $this->getUser($request->header('Authorization'));
        $lession = Lession::whereId($request->id)->first();
        if ($lession) {
            if ($user->id == $lession->user_id) {
                $lession->delete();
                return $this->sendResponse(1, 'Lession delete successfully',null, 200);
            }
            return $this->sendResponse(0, 'Access forbiddon', null, 403);
        }
        return $this->sendResponse(0, 'Lession not found', null, 401);
    }
}
