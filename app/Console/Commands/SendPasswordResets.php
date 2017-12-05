<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
use App\UserPasswordResets;

class SendPasswordResets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:password_resets {delay?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'php artisan send:password_resets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function _getEmailList() 
    {
        $result = UserPasswordResets::where('status', 0)
                    ->orderBy('created_at')
                    ->limit(1)
                    ->get();
        
        if (!$result->count())
        {
            return false;
        }

        $update_date = UserPasswordResets::where('id', $result[0]->id)
                        ->update(array(
                            'status' => '1', //发送
                            'updated_at' => time(),
                            //'msg' => 'Waiting...'
                        ));
        return $result[0];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $delay = $this->argument('delay');
        if (!empty($delay)) {
            sleep((int)$delay);
        }
        
        $email = $this->_getEmailList();
        if ($email === false) {
            die(' No email to send.');
        }

        $invalid_emails = ['xxxx@qq.com'];
        if(!empty($email->email) && !in_array($email->email,$invalid_emails))
        {
            $this->info($email->id.'...');

            // smtp 发送
            if(true)
            {
                // smtp 
                $data = new \stdClass;
                $data->email_to = $email->email;
                $data->subject = 'password resets';
                $data->htmlBody = $email->code;

                $response = Mail::send('email.password_resets', 
                    (array)$data, 
                    function($message) use($data) {
                        if (env('APP_ENV') === 'life') {
                            $message->to($data->email_to)
                                    ->subject($data->subject);
                        } else {
                            $message->to('13149992@qq.com')
                                    ->to($data->email_to)
                                    ->subject($data->subject);
                        }
                    }
                );
                // smtp
                
                //update email_jobs info
                if(empty($response))
                {
                    $array = [
                        'updated_at' => time(),
                        'status' => 1,
                        //'msg' => ' smtp proc_date:'.date("Y-m-d H:i:s", time()).' id:'.$email->id.' true',
                    ];
                    $update_jobs_list = UserPasswordResets::where('id',$email->id)->update($array);
                }
                else
                {
                    $array = [
                        'updated_at' => time(),
                        'status' => -1,
                        //'msg' => '邮件地址错误',
                    ];
                    $update_jobs_list = UserPasswordResets::where('id',$email->id)->update($array);
                }
            }
        }
        else
        {
            $array = [
                'updated_at' => time(),
                'status' => -2,
                //'msg' => '没有找到Email'.'proc_date:'.date('Y-m-d H:i:s').' id:'.$results->id,
            ];
            $update_jobs_list = UserPasswordResets::where('id',$email->id)->update($array);
        }
        
        die('Done id: '.$email->id);
    }
}
