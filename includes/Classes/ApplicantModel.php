<?php

namespace EventSpeechOrganizer\Classes;

if (!defined('ABSPATH')) {
    exit;
}


class ApplicantModel
{


    public function getAll()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers';
        $sql = "SELECT * FROM $table_name";
        return $wpdb->get_results($sql);
    }

    public function get($request)
    {

        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers';
        $sql = "SELECT * FROM $table_name";

        $options  = isset($_REQUEST['options']) ? $_REQUEST['options'] : array();

        if (isset($options['not_status'])) {
            $exc = '';
            foreach ($options['not_status'] as $value) {
                $exc .= "'" . sanitize_text_field($value) . "',";
            }
            $exc = rtrim($exc, ",");
            $sql .= " WHERE status NOT IN ($exc)";
        }

        if (isset($options['status'])) {
            $List = implode(', ', $options['status']);
            $sql .= " WHERE status IN ('" . $List . "' )";
        }

        $sql = rtrim($sql, "AND");

        $results = $wpdb->get_results($sql);

        return array(
            'data' => $results
        );
    }

    public function searchBy($searchQuery)
    {
        //search from data using $searchQuery
        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers';
        $sql = "SELECT * FROM $table_name WHERE name LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR phone LIKE '%$searchQuery%' OR username LIKE '%$searchQuery%' OR social LIKE '%$searchQuery%' OR type LIKE '%$searchQuery%' OR topic LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' OR cospeakers LIKE '%$searchQuery%' OR audience LIKE '%$searchQuery%' OR experience LIKE '%$searchQuery%' OR question LIKE '%$searchQuery%' OR consent LIKE '%$searchQuery%' OR ip LIKE '%$searchQuery%' Limit 10";

        $results = $wpdb->get_results($sql);

        $suggestion = array();
        foreach ($results as $key => $value) {
            $suggestion[] = array(
                'label' => $value->topic,
                'value' => $value->topic
            );
        }

        return $suggestion;
    }

    public function updateStatus($query)
    {

        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers';

        $data = array(
            'status' => sanitize_text_field($query['status'])
        );
        $where = array(
            'id' => $query['id']
        );

        $wpdb->update($table_name, $data, $where);
    }

    public function update($speaker)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers';

        $data = array(
            'name' => sanitize_text_field($speaker['name']),
            'email' => sanitize_text_field($speaker['email']),
            'comment' => sanitize_text_field($speaker['comment']),
            'phone' => sanitize_text_field($speaker['phone']),
            'username' => sanitize_text_field($speaker['username']),
            'social' => sanitize_text_field($speaker['social']),
            'date' => sanitize_text_field($speaker['date']),
            'type' => sanitize_text_field($speaker['type']),
            'topic' => sanitize_text_field($speaker['topic']),
            'description' => esc_html($speaker['description']),
            'status' => sanitize_text_field($speaker['status']),
            'cospeakers' => sanitize_text_field($speaker['cospeakers']),
            'audience' => sanitize_text_field($speaker['audience']),
            'experience' => sanitize_text_field($speaker['experience']),
            'question' => sanitize_text_field($speaker['question']),
            'consent' => sanitize_text_field($speaker['consent']),
            'ip' => sanitize_text_field($speaker['ip'])
        );

        $where = array(
            'id' => $speaker['id']
        );

        $wpdb->update($table_name, $data, $where);
    }

    public function insert($speaker)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'speakers';
        $data = array(
            'name' => sanitize_text_field($speaker['name']),
            'email' => sanitize_text_field($speaker['email']),
            'comment' => sanitize_text_field($speaker['comment']),
            'phone' => sanitize_text_field($speaker['phone']),
            'username' => sanitize_text_field($speaker['username']),
            'social' => sanitize_text_field($speaker['social']),
            'date' => sanitize_text_field($speaker['date']),
            'type' => sanitize_text_field($speaker['type']),
            'topic' => sanitize_text_field($speaker['topic']),
            'description' => esc_html($speaker['description']),
            'status' => sanitize_text_field($speaker['status']),
            'cospeakers' => sanitize_text_field($speaker['cospeakers']),
            'audience' => sanitize_text_field($speaker['audience']),
            'experience' => sanitize_text_field($speaker['experience']),
            'question' => sanitize_text_field($speaker['question']),
            'consent' => sanitize_text_field($speaker['consent']),
            'ip' => sanitize_text_field($speaker['ip'])
        );

        $wpdb->insert($table_name, $data);

        if ($wpdb->last_error) {
            dd($wpdb->last_error);
        }
    }
}
