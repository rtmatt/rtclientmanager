<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/16/16
 * Time: 2:30 PM
 */

namespace RTMatt\MonthlyService;

class PriorityAlertProcessor
{

    protected $input;

    protected $home_email = "team@designledge.com";

    protected $home_name = "DESIGNLEDGE Team";

    protected $cc_email = "ridethe@redtrainwebservices.com";

    protected $cc_name = "RedTrain Team";


    function __construct($input)
    {
        $this->input = $input;
    }


    public static function process($input)
    {
        $processor = new static($input);
        $processor->doProcess();
    }


    private function doProcess()
    {
        $this->alert = PriorityAlert::create($this->input);

        $this->notifyClient();
        $this->notifyHome();
    }


    private function getNotificationEmail()
    {
        $this->client_notification_email = new  \stdClass();
        if ( ! empty( $this->input['contact_email'] )) {
            $this->client_notification_email->address = $this->input['contact_email'];
            $this->client_notification_email->source  = "input";

            return $this->client_notification_email;

        }
        $this->client_notification_email->address = $this->alert->client->primary_contact_email;
        $this->client_notification_email->source  = "client";

        return $this->client_notification_email;
    }


    private function notifyClient()
    {
        $notification_email = $this->getNotificationEmail()->address;
        $notification_name  = $this->getNotificationName();

        \Mail::queue('rtclientmanager::emails.client-notification', compact('notification_name'),
            function ($m) use ($notification_email, $notification_name) {
                $m->from('noreply@designledge.com', 'DESIGNLEDGE');
                $m->to($notification_email, $notification_name)->subject('We Received Your DESIGNLEDGE Priority Alert');
            });
    }


    private function getNotificationName()
    {

        //if email is from input
        if ($this->client_notification_email->source == "input") {
            // and input has name
            if ( ! empty( $this->input['contact_name'] )) {
                //-- input name
                return $this->input['contact_name'];
            }

            return $this->alert->client->name;
        }

        return $this->alert->client->primary_contact_name;
    }


    private function notifyHome()
    {
        $alert                = $this->alert->toArray();
        $alert['client_name'] = $this->alert->client->name;

        $info_dict  = [
            'to'      => $this->home_email,
            'to_name' => $this->home_name,
            'cc'      => $this->cc_email,
            'cc_name' => $this->cc_name

        ];



        \Mail::queue('rtclientmanager::emails.home-notification', compact('alert'),
            function ($m) use ($alert, $info_dict/*, $attachFile*/) {
                $m->from('noreply@designledge.com', 'DESIGNLEDGE');
                $m->to($info_dict['to'], $info_dict['to_name']);
                if (array_key_exists('cc', $info_dict)) {
                    $m->cc($info_dict['cc'], $info_dict['cc_name']);
                }
                $m->subject('New DESIGNLEDGE Priority Alert - ' .$alert['client_name']  );
            });

    }
}