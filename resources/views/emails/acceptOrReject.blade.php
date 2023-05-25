<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>Request Review!</title>
    <style type="text/css">

        @media only screen and (max-width: 600px){
            body{font-size:12px !important;}
            table{width: 1000px;}

        }
    </style>
</head>
<body style="font-family: 'Open Sans', sans-serif; color:#000; font-size:15px;" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="width:100%;">
    <tr>
        <td  align="center">
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="max-width:600px; width:100%;">
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="width:100%; background-color:#fff; border: 1px solid #ddd;padding: 0px 20px;">
                            <tr style="float:left;width:100%;padding: 20px 0px;">
                                @php
                                    $company_id = $request_data->company_id;
                                    $company = \App\Models\Company::where('id',$company_id)->first();
                                @endphp
                                @if(!is_null($company->logo))
                                    <td style="float:left;width:100%;" align="center">
                                    <img src="{{asset('image/'.$company->logo)}}" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                                    </td>
                                @endif
                            </tr>
                            <tr style="float:left;width:100%;padding-bottom:20px;">
                                <td style="float:left;width:100%;" align="center">
                                    <h1 style="font-size: 40px;margin-top: 0px;margin-bottom: 10px;">Expense Management</h1>
                                </td>
                            </tr>
                            <tr style="float:left;width:100%;padding-bottom:20px;">
                                <td style="float:left;width:100%;" align="center">
                                    <h1 style="font-size: 30px;margin-top: 0px;margin-bottom: 10px;">Request Details</h1>
                                </td>
                            </tr>
                            <tr style="float:left;width:100%;padding-bottom:20px;">
                                <td style="float:left;width:100%;" align="center">
{{--                                    <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Hi Admin!, </strong> New Request Created! Please review & respond.</p> <br>--}}
                                    @isset($request_data['initiator'])
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Initiator :</strong>{{$request_data['initiator'] ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->comapny->name)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Company :</strong>{{$company->name ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->department->name)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Department :</strong>{{$request_data->department->name ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->supplier->supplier_name)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Supplier :</strong>{{$request_data->supplier->supplier_name ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->typeOfExpense->name)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Type Of Expanse :</strong>{{$request_data->typeOfExpense->name ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->currency)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Currency :</strong>{{$request_data->currency ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->amount)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Amount :</strong>{{$request_data->amount ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->amount_in_gel)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Amount in GEL :</strong>{{$request_data->amount_in_gel ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->payment_date)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Due Date of Payment :</strong>{{$request_data->payment_date ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->submission_date)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Due Date :</strong>{{$request_data->submission_date ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->status)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Status :</strong>{{$request_data->status ?? ''}}</p>
                                    @endisset
                                    @isset($request_data->basis)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Basis :</strong>
                                        <?php 
                      $files=explode(',',$request_data->basis);
                      foreach($files as $file){ ?>
                      <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>
                  <?php  }   
                  ?></p>
                                    @endisset
                                    @isset($request_data->description)
                                        <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;"><strong>Description :</strong>{{$request_data->description ?? ''}}</p>
                                    @endisset

                                </td>
                            </tr>
                            <tr style="float:left;width:100%;padding-bottom:40px;">
                                <td style="float:left;width:100%;" align="center">
                                    <a style="background: #99ca3b;color: #fff;text-decoration: none;border-radius: 40px;padding: 10px 30px;font-size: 20px;font-weight: 600;" href="{{url('/login')}}">Login</a>
                                </td>
                            </tr>
                            <tr style="float:left;width:100%;padding-bottom:20px;">
                                <td style="float:left;width:100%;" align="left;">
                                    <p style="line-height: 25px;font-size: 16px;margin-top: 0px;font-style: italic;">Thanks,<br><strong>Expense Management Team</strong></p>
                                </td>
                            </tr>
                            <!--  <tr style="background: #efefef;float:left;width:100%;padding: 20px 0px;">
                                <td style="float:left;width:100%;font-size: 14px;color: #666;" align="center">
                                   <address>
                                      2347, Melbourne. Australia<br>
                                      +123 456 789 000 <br>
                                      ebul@gmail.com
                                   </address>
                                </td>
                             </tr> -->
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
