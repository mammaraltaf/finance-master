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
       // dd($current_status);
        switch($current_status){
            case 'submitted-for-review':
                $next_role="manager";
                break;
                case 'manager-confirmed':
                    $next_role="finance";
                    break;        
                case 'manager-threshold-exceeded':
                    $next_role="finance";
                    break;
                    case 'finance-ok':
                        $next_role="accounting";
                        break;
                        case 'finance-threshold-exceeded':         
                            $next_role="director";
                            break;
                            case 'director-confirmed':  
                                $next_role="accounting";
                                break;
                                case 'threshold-exceeded':
                                    $next_role="director";
                                    break;
                default:
                $next_role="user";
        break;
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
            $m->from('qdmpaymentsge@qdmpaymentsge.co', config('app.name', 'APP Name'));
            $m->to($email)->subject('Review Request');
        });
        if($next_role != "user"){
            Mail::send('emails.acceptOrReject', ['request_data' => $request_data], function ($m) use ($next_person_email) {
                $m->from('qdmpaymentsge@qdmpaymentsge.co', config('app.name', 'APP Name'));
                $m->to($next_person_email)->subject('Review Request');
            });
        }
    }
}
