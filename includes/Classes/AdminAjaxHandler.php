<?php

namespace EventSpeechOrganizer\Classes;

use EventSpeechOrganizer\Classes\ApplicantModel;
use EventSpeechOrganizer\Classes\SpeakerSlots;

class AdminAjaxHandler
{
    public function registerEndpoints()
    {
        add_action('wp_ajax_event_speech_organizer_admin_ajax', array($this, 'handleEndPoint'));
    }
    public function handleEndPoint()
    {
        $route = sanitize_text_field($_REQUEST['route']);

        $validRoutes = array(
            'get_data' => 'getData',
            // 'save' => 'saveSpeaker',
            'update_status' => 'updateStatus',
            'get_slots' => 'getSlots',
            'save_slots' => 'saveSlots',
            'delete_slot' => 'deleteSlot',
            'search_speakers' => 'searchSpeakers',
            'add_applicant' => 'addApplicant',
            'edit_applicant' => 'editApplicant',
        );

        if (isset($validRoutes[$route])) {
            do_action('event_speech_organizer/doing_ajax_forms_' . $route);
            return $this->{$validRoutes[$route]}();
        }
        do_action('event_speech_organizer/admin_ajax_handler_catch', $route);
    }

    public function editApplicant()
    {
        $applicant = $_REQUEST['data'];
        $applicantModel = new ApplicantModel();
        $applicantModel->update($applicant);
    }


    public function addApplicant()
    {
        $applicant = $_REQUEST['data'];
        $applicantModel = new ApplicantModel();
        $applicant['question'] = '';
        $applicant['consent'] = '';
        $applicant['ip'] = '';

        $applicantModel->insert($applicant);
    }

    public function searchSpeakers()
    {
        $speakerModel = new ApplicantModel();
        $eventSpeechOrganizer = $speakerModel->searchBy($_REQUEST['search_by']);
        wp_send_json($eventSpeechOrganizer);
    }

    public function getSlots()
    {
        $speakerModel = new SpeakerSlots();
        $slots = $speakerModel->get();
        wp_send_json($slots);
    }

    public function deleteSlot()
    {
        $speakerModel = new SpeakerSlots();
        $speakerModel->delete($_REQUEST['id']);
    }

    public function saveSlots()
    {
        $slot = $_REQUEST['data'];
        $speakerModel = new SpeakerSlots();

        $speakers = json_encode($slot['speakers']);

        foreach ($slot as $key => $value) {
            $slot[$key] = sanitize_text_field($value);
        }

        $slot['speakers'] = $speakers;

        if (isset($slot['id'])) {
            return $speakerModel->update($slot);
        }

        $speakerModel->insert($slot);
    }

    protected function getData()
    {
        $speakerModel = new ApplicantModel();
        $speakers = $speakerModel->get($_REQUEST);
        wp_send_json($speakers);
    }

    public function saveSpeaker()
    {
        $speakers = $_REQUEST['data'];

        $speakerModel = new ApplicantModel();

        foreach ($speakers as $speaker) {
            $speakerModel->insert($speaker);
        }
    }

    public function updateStatus()
    {
        $speakerModel = new ApplicantModel();
        $speakerModel->updateStatus($_REQUEST['options']);
    }
}
