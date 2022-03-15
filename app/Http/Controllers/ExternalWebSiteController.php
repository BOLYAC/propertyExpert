<?php

namespace App\Http\Controllers;

use App\Models\Client;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\Ad;
use FacebookAds\Object\Fields\LeadFields;
use FacebookAds\Object\Lead;
use FacebookAds\Object\LeadgenForm;
use FacebookAds\Object\Page;
use Illuminate\Http\Request;

class ExternalWebSiteController extends Controller
{
    public function getExpoForm(Request $request)
    {
        $d = $request->all();

        /*$this->validate($request, [
            'form.name' => 'required|regex:/^[a-z0-9\s]+$/i',
            'fields.name.value' => 'required|regex:/^[a-z0-9\s]+$/i',
            'fields.email.value' => ['nullable', 'string', 'email', 'max:255', 'unique:clients,client_email,deleted_at'],
            'fields.field_6268666.value' => ['nullable', 'max:255', 'unique:clients,client_number,deleted_at'],
            'meta.date.value' => 'date',
            'meta.user_agent.value' => 'required|url',
        ]);*/

        $input = [
            'form_name' => $d['form']['name'],
            'full_name' => $d['fields']['name']['value'],
            'email' => $d['fields']['email']['value'],
            'phone' => $d['fields']['field_6268666']['value'],
            'submit_date' => $d['meta']['date']['value'],
            'page_name' => $d['meta']['page_url']['value'],
            'user_agent' => $d['meta']['user_agent']['value']
        ];

        $client = new Client([
            'form_name' => $input['form_name'],
            'full_name' => $input['full_name'],
            'client_email' => $input['email'],
            'client_number' => $input['phone'],
            'source_id' => 10,
            'status' => 1,
            'agency_id' => 1,
            'ad_click_date' => $input['submit_date'],
            'search_partner_network' => $input['user_agent'],
            'adset_name' => $input['page_name'],
            'user_id' => 89,
            'created_by' => 1,
            'updated_by' => 1,
            'department_id' => 1
        ]);

        $client->save();

        \Illuminate\Support\Facades\Log::info($client);
        return response()->json(['success' => true, 'message' => 'Mesajınız gönderildi. Teşekkür ederiz']);
    }

    public function getHashimForm(Request $request)
    {
        $d = $request->all();

        /*$this->validate($request, [
            'form.name' => 'required|regex:/^[a-z0-9\s]+$/i',
            'fields.name.value' => 'required|regex:/^[a-z0-9\s]+$/i',
            'fields.email.value' => ['nullable', 'string', 'email', 'max:255', 'unique:clients,client_email,deleted_at'],
            'fields.field_6268666.value' => ['nullable', 'max:255', 'unique:clients,client_number,deleted_at'],
            'meta.date.value' => 'date',
            'meta.user_agent.value' => 'required|url',
        ]);*/

        $input = [
            'form_name' => $d['form']['name'],
            'full_name' => $d['fields']['name']['value'],
            'email' => $d['fields']['email']['value'],
            'phone' => $d['fields']['field_6268666']['value'],
            'submit_date' => $d['meta']['date']['value'],
            'page_name' => $d['meta']['page_url']['value'],
            'user_agent' => $d['meta']['user_agent']['value']
        ];

        $client = new Client([
            'form_name' => $input['form_name'],
            'full_name' => $input['full_name'],
            'client_email' => $input['email'],
            'client_number' => $input['phone'],
            'source_id' => 10,
            'status' => 1,
            'agency_id' => 1,
            'ad_click_date' => $input['submit_date'],
            'search_partner_network' => $input['user_agent'],
            'adset_name' => $input['page_name'],
            'user_id' => 26,
            'created_by' => 1,
            'updated_by' => 1,
            'department_id' => 1
        ]);

        $client->save();

        \Illuminate\Support\Facades\Log::info($client);
        return response()->json(['success' => true, 'message' => 'Mesajınız gönderildi. Teşekkür ederiz']);
    }

    public function getExpoShowForm()
    {

        $d = $request->all();

        $input = [
            'form_name' => $d['form']['name'],
            'full_name' => $d['fields']['full_name']['value'],
            'email' => $d['fields']['email']['value'],
            'phone' => $d['fields']['phone_number']['value'],
            'submit_date' => $d['meta']['date']['value'],
            'page_name' => $d['meta']['page_url']['value'],
            'user_agent' => $d['meta']['user_agent']['value']
        ];

        $client = new Client([
            'form_name' => $input['form_name'],
            'full_name' => $input['full_name'],
            'client_email' => $input['email'],
            'client_number' => $input['phone'],
            'source_id' => 10,
            'status' => 1,
            'agency_id' => 1,
            'ad_click_date' => $input['submit_date'],
            'search_partner_network' => $input['user_agent'],
            'adset_name' => $input['page_name'],
            'user_id' => 89,
            'created_by' => 1,
            'updated_by' => 1,
            'department_id' => 4
        ]);

        $client->save();

        \Illuminate\Support\Facades\Log::info($client);
        return response()->json(['success' => true, 'message' => 'Mesajınız gönderildi. Teşekkür ederiz']);
    }

    public function getCitizenShipHashimForm(Request $request)
    {

        $d = $request->all();
        \Illuminate\Support\Facades\Log::info($d);
        return response()->json(['success' => true, 'message' => 'Mesajınız gönderildi. Teşekkür ederiz']);

        $input = [
            'full_name' => $request->full_name,
            'email' => $$request->email,
            'phone' => $request->phone,
            'submit_date' => now(),
            'page_name' => $request->page_name,
            'user_agent' => $request->user_agent
        ];

        $client = new Client([
            'form_name' => $input['form_name'],
            'full_name' => $input['full_name'],
            'client_email' => $input['email'],
            'client_number' => $input['phone'],
            'source_id' => 10,
            'status' => 1,
            'agency_id' => 1,
            'ad_click_date' => $input['submit_date'],
            'search_partner_network' => $input['user_agent'],
            'adset_name' => $input['page_name'],
            'user_id' => 89,
            'created_by' => 1,
            'updated_by' => 1,
            'department_id' => 1
        ]);

        $client->save();

        \Illuminate\Support\Facades\Log::info($client);
        return response()->json(['success' => true, 'message' => 'Mesajınız gönderildi. Teşekkür ederiz']);
    }

    public function getLeads()
    {
        $access_token = 'EAACllxnAgegBAI99pIZB9zi0Js1geQFEZBxHLlP2nDZAGYAcIPdhKFHaZB9kOw1U4hEjMGEZBfAc8LVlRnOhqcO0op3qCuQiKlzaMhrbpZAsfAC6jFEvztb22z6JdFUZAS91dZCP0TZAgqJ2PYMZC2OTkomxXW7Rmarl4WNZCDQijl6i4XyvjwgqlEaU2RKV3vSH5eBjRXtDodEEhH6iLd2ONx9';
        $app_secret = 'e09e3023fa9f521053488a82804770aa';
        $app_id = '114546569990168';
        $id = '114546569990168';

        $api = Api::init($app_id, $app_secret, $access_token);

        $page_id = '114546569990168';

        $page = new Page($page_id);

        //dd($page);

        $leadgenForms = $page->getLeadgenForms();


        $api->setLogger(new CurlLogger());

        $fields = array();

        $params = array();

        $result = json_encode((new Lead($id))->getSelf(
            $fields,
            $params
        )->exportAllData(), JSON_PRETTY_PRINT);

        foreach ($leadgenForms as $leadgenForm) {

            $leads = $leadgenForm->getLeads(array(
                LeadFields::FIELD_DATA,
                "retailer_item_id",
            ));
            foreach ($leads as $fbLead) {

                foreach ($fbLead->getData()['field_data'] as $fieldData) {
                    $result[] = $fieldData;
                }
            }
        }


        foreach ($leadgenForms as $leadgenForm) {
            $fn[] = $formName = $leadgenForm->getData()['leads_count'];

            $leads = $leadgenForm->getLeads(array(
                LeadFields::FIELD_DATA,
                "retailer_item_id",
            ));
            dd($leads);
            $l[] = $leadgenForm;
            $le[] = $leads;
            foreach ($leads as $fbLead) {

                $result[] = $fbLead->getData()['field_data'];

                foreach ($fbLead->getData()['field_data'] as $fieldData) {
                    if ($fieldData['name'] == 'when_are_you_planning_to_buy_or_invest_in_real_estate?_') {
                        //$client->setPlanning($fieldData['values'][0]);
                    }
                    if ($fieldData['name'] == 'email') {
                        //$client->setEmail($fieldData['values'][0]) ;
                    }
                    if ($fieldData['name'] == 'full_name') {
                        //$client->setFullname($fieldData['values'][0]);
                    }
                    if ($fieldData['name'] == 'name') {
                        //$client->setPhone($fieldData['values'][0]);
                    }
                    if ($fieldData['name'] == 'phone_number') {
                        //$client->setPhone($fieldData['values'][0]);
                    }
                }
            }
        }



        $ads = json_decode($this->getAllLeadsAds($page_id));

        $result = array();

        foreach ($ads->data as $item) {
            $leads = json_decode($this->getLeadAdInfo($item->id));

            $i = 0;
            foreach ($leads->data as $value) {
                $result[$i]['ad_id'] = $item->id;
                $result[$i]['lead_id'] = $value->id;
                $result[$i]['form'] = $value->field_data;
                $i++;
            }
        }
    }

    function getAllLeadsAds($page)
    {
        $page = new Page($page);
        return $page->getLeadgenForms()->getResponse()->getBody();
    }

    function getLeadAdInfo($ad)
    {
        $ad = new Ad($ad);
        return $ad->getLeads()->getResponse()->getBody();
    }


}
