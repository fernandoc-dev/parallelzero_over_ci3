<?php
function build_message_about_repeated_records_for_modal($repeated_fields)
{
    /*
    * Instructions:
    * At the Controller you must set:
    * $repeated_fields = array( //Fields according to
    *    'complete_name',
    *    'username',
    *    'email'
    * );
    * $this->load->helper('modal_repeated_records');
    * $message = build_message_about_repeated_records_for_modal($repeated_fields);
    */

    $items = count($repeated_fields);
    if ($items == 1) {
        $message = "The ";
        $closing_message = " already exists, please try again using other.";
    } else {
        $message = "The ";
        $closing_message = " already exist, please try again using others.";
    }
    $counter = 1;
    foreach ($repeated_fields as $item) {
        if ($counter == 1) {
            $message .= $item;
        } elseif ($counter > 1) {
            if ($counter < $items) {
                $message .= " " . $item . ",";
            } elseif ($counter == $items) {
                $message .= " and " . $item . " ";
            }
        }
        $counter++;
    }
    $message .= $closing_message;
    return $message;
}
