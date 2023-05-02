<?php

namespace EventSpeechOrganizer\Classes;

if (!defined('ABSPATH')) {
    exit;
}


class SpeakerSlots
{
    public function get()
    {

        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers_slots';
        $sql = "SELECT * FROM $table_name";

        $results = $wpdb->get_results($sql);

        foreach ($results as $key => $value) {
            $results[$key]->speakers = json_decode($value->speakers);
        }

        return array(
            'data' => $results
        );
    }

    public function delete($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers_slots';
        $wpdb->delete($table_name, array('id' => $id));
    }

    public function update($data)
    {
        global $wpdb;
        
        unset($data['visible']);
        
        $table_name = $wpdb->prefix . 'speakers_slots';
        $wpdb->update($table_name, $data, array('id' => $data['id']));
    }

    public function insert($data)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers_slots';
        $wpdb->insert($table_name, $data);

        if ($wpdb->last_error) {
            return array(
                'status' => false,
                'message' => $wpdb->last_error
            );
        };
    }
}
