<?php
/** Admiko configuration file **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
/**
 * @param length_menu_table         php pagination limits for table template
 * @param length_menu_table_card    php pagination limits for card template
 * @param length_menu_table_gallery php pagination limits for gallery template
 * @param length_menu_table_JS      JS pagination limits for table (dataTable)
 * @param filesystem                File storage settings. Variable must be defined in config.filesystem
 * @param table_date_time_format    PHP Date & Time format on the table page for elements with Date and Time (examples: https://www.php.net/manual/en/datetime.format.php)
 * @param form_date_time_format     JS Date & Time format on the form page for elements with Date and Time (examples: https://momentjs.com/docs/#/displaying/format/)
 * @param table_date_format         PHP Date format on the table page for elements with Date only (examples: https://www.php.net/manual/en/datetime.format.php)
 * @param form_date_format          JS Date format on the form page for elements with Date only (examples: https://momentjs.com/docs/#/displaying/format/)
 * @param table_time_format         PHP Time format on the table page for elements with Time only (examples: https://www.php.net/manual/en/datetime.format.php)
 * @param form_time_format          JS Time format on the form page for elements with Time only (examples: https://momentjs.com/docs/#/displaying/format/)
 * @param google_map_api_key        API key for Google maps
 * @param bing_map_api_key          API key for Bing maps
 * @param map_start_zoom            Default Zoom level on map load
 * @param map_star_latitude         Starting Latitude on map load
 * @param map_star_longitude        Starting Longitude on map load
 * @param backup_location           Backup location to store old files when updating admiko default files and import new pages
 */
return [
    'length_menu_table'        => [10 => 10, 50 => 50, 100 => 100, 99999 => "Todo"],
    'length_menu_table_card'    => [12 => 12, 48 => 48, 96 => 96, 99999 => "Todo"],
    'length_menu_table_gallery' => [24 => 24, 48 => 48, 96 => 96, 99999 => "Todo"],
    'length_menu_table_JS'      => '[[10, 50, 100, -1], [10, 50, 100, "Todo"]]',
    'filesystem'             => 'public_folder',
    'table_date_time_format' => 'M d, Y H:i:s',
    'form_date_time_format'  => 'MMM DD, Y HH:mm:ss',
    'table_date_format'      => 'M d, Y',
    'form_date_format'       => 'MMM DD, Y',
    'table_time_format'      => 'H:i:s',
    'form_time_format'       => 'HH:mm:ss',
    'bing_map_api_key'       => '',
    'google_map_api_key'     => '',
    'map_start_zoom'           => 13,
    'map_star_latitude'        => 40.70290175364676,
    'map_star_longitude'       => -74.01507115297852,
    'backup_location'        => '_admiko_backup',
];