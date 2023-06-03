<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\CompanyUser;
use App\Models\DepartmentUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;

class AcceptOrRejectRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request_data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request_data)
    {
        $this->request_data = $request_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
////        $email = auth()->user()->email;
//        $request_data = $this->request_data;
//        $user_id = $request_data['user_id'];
//        $email = User::whereId($user_id)->pluck('email')->first() ?? 'mammaraltaf@gmail.com';
//        Mail::send('emails.acceptOrReject', ['request_data' => $request_data], function ($m) use ($email) {
//            $m->from('finance@mail.com', config('app.name', 'APP Name'));
//            $m->to($email)->subject('Review Request');
//        });

        $request_data = $this->request_data;
        $user_id = $request_data['user_id'];
        $email = User::whereId($user_id)->pluck('email')->first();
        $current_status=$request_data['status'];
//dd($current_status);
        switch ($current_status) {
            case StatusEnum::SubmittedForReview:
                $next_role = UserTypesEnum::Manager;
                break;
            case StatusEnum::ThresholdExceeded:
            case StatusEnum::FinanceThresholdExceeded:
                $next_role = UserTypesEnum::Director;
                break;
            case StatusEnum::ManagerConfirmed:
            case StatusEnum::ManagerThresholdExceeded:
                $next_role = UserTypesEnum::Finance;
                break;
            case StatusEnum::DirectorConfirmed:
            case StatusEnum::FinanceOk:
                $next_role = UserTypesEnum::Accounting;
                break;

            default:
                $next_role = UserTypesEnum::User;
        }

        //dd($next_role);
       $all_users_in_company=CompanyUser::where('company_id',$request_data['company_id'])->pluck('user_id')->toArray();
       $next_person_email=User::whereIn('id',$all_users_in_company)
       ->where('user_type',$next_role)
       ->pluck('email')->first();
     //  dd($next_person_email);
        // Validate the email address using filter_var() function
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a default email address if the retrieved email address is invalid
            $email = 'mammaraltaf@gmail.com';
        }

        Mail::send('emails.acceptOrReject', ['request_data' => $request_data], function ($m) use ($email) {
            $m->from(env('MAIL_FROM_ADDRESS'), config('app.name', 'APP Name'));
            $m->to($email)->subject('Review Request');
        });
        if($next_role != "user"){
            Mail::send('emails.acceptOrReject', ['request_data' => $request_data], function ($m) use ($next_person_email) {
                $m->from(env('MAIL_FROM_ADDRESS'), config('app.name', 'APP Name'));
                $m->to($next_person_email)->subject('Review Request');
            });
        }
    }
}
