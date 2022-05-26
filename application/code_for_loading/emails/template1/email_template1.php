<?php
$html = "
<!DOCTYPE html>
<html lang=\"" . $html_language . "\">

<head>
    <meta charset=\"utf-8\">
    <title></title>
</head>";
$html .= "
<body style=\"background-color:" . $body_background_color . "\">

    <table style=\"max-width:" . $table_max_width . "; padding:" . $table_padding . "; margin:" . $table_margin . "; border-collapse: " . $table_border_collapse . ";\">";
if (isset($logo_image)) {
    $html .= "
        <tr>
            <td style=\"background-color: " . $logo_background_color . "; text-align: " . $logo_text_align . "; padding: " . $logo_padding . "\">
                <a href=\"" . $logo_link_url . "\">
                    <img width=\"" . $logo_size . "\" style=\"display:" . $logo_display . "; margin: " . $logo_margin . "\" src=\"" . $logo_image . "\">
                </a>
            </td>
        </tr>";
}
if (isset($body_main_image)) {
    $html .= "        
        <tr>
            <td style=\"background-color: " . $body_main_image_background_color . "; padding:" . $body_main_image_td_padding . "\">
                <img style=\"margin: " . $body_main_image_margin . "; padding:" . $body_main_image_padding . "; display: " . $body_main_image_display . "\" src=\"" . $body_main_image . "\" width=\"" . $body_main_image_size . "\">
            </td>
        </tr>";
}
$html .= "
        <tr style=\"padding:0px; margin: 0px\">
            <td style=\"padding:0px; margin: 0px; background-color: " . $body_text_background_color . "\">
                <div style=\"color: " . $body_text_color . "; margin: " . $body_text_margin . "; text-align: " . $body_text_align . ";font-family: " . $body_text_font_family . "\">";
if ($h2) {
    $html .= "
                    <h2 style=\"color: " . $h2_color . "; margin: " . $h2_margin . "\">" . $h2 . "</h2>
    ";
}
if ($main_text) {
    $html .= "
                    <p style=\"margin: " . $main_text_margin . "; font-size: " . $main_text_font_size . "\">" . $main_text;
    $html .= "
                    </p>
    ";
}
if ($list) {
    $html .= "
                    <ul style=\"font-size: " . $list_font_size . ";  margin: " . $list_margin . "\">";
    foreach ($list as $value) {
        $html .= "
                        <li>" . $value . "</li>";
    }
    $html .= "
                    </ul>";
}
if ($carrousel) {
    $html .= "
                    <div style=\"width: " . $carrousel_width . ";margin: " . $carrousel_margin . "; display: " . $carrousel_display . ";text-align: " . $carrousel_text_align . "\">";
    foreach ($carrousel as $value) {
        $html .= "
                        <img style=\"padding: " . $carrousel_img_padding . "; width: " . $carrousel_img_width . "; margin: " . $carrousel_img_margin . "\" src=\"" . $value . "\">";
    }
    $html .= "
                    </div>";
}
if ($button_call_to_action) {
    $html .= "
                    <div style=\"width: " . $button_call_to_action_width . "; text-align: " . $button_call_to_action_text_align . "\">
                        <a style=\"text-decoration: " . $button_call_to_action_text_decoration . "; border-radius: " . $button_call_to_action_border_radius . "; padding: " . $button_call_to_action_padding . "; color: " . $button_call_to_action_color . "; background-color: " . $button_call_to_action_background_color . "\"
                            href=\"" . $button_call_to_action_url . "\">" . $button_call_to_action . "</a>
                    </div>
    ";
}
if ($footer) {
    $html .= "
                    <p style=\"color: " . $footer_color . "; font-size: " . $footer_font_size . "; text-align: " . $footer_text_align . ";margin: " . $footer_margin . "\">" . $footer . "</p>
    ";
}
$html .= "            
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
";
