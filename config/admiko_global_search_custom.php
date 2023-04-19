<?php
/** Admiko configuration file for your custom pages**/

/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */

return [
//    [
//        'name'     => 'Title for results',
//        'route_id' => 'route_id',
//        'model'    => 'PathToModel',
//        'fields'   => [
//            ['field' => 'filed_to_search', 'show' => true],
//        ]
//    ]
];

/** IMPORTANT INFO
 * IMPORTANT: in this file you can add your pages into global search
 * Example for a single page:
 * return [
 *      [
 *      'name'     => 'Gallery', - model title used in the results
 *      'route_id' => 'gallery_id', - your route ID from routes (ex: )
 *      'model'    => 'Gallery', - path to your model class inside the model folder
 *      'fields'   => [
 *              [
 *                  'field' => 'title', - field to search in database
 *                  'show' => true  - show value from field in the results
 *              ],
 *          ]
 *      ]
 * ]
 *  * Example for a model in a folder with multiple search fields:
 * return [
 *      [
 *      'name'     => 'Gallery > Images', - model title used in the results
 *      'route_id' => 'gallery_images_id', - your route ID from routes (ex: )
 *      'model'    => 'Gallery/Images', - path to your model class inside the model folder
 *      'fields'   => [
 *              [
 *                  'field' => 'title', - field to search in database
 *                  'show' => true  - show value from field in the results
 *              ],
 *              [
 *                  'field' => 'content', - field to search in database
 *                  'show' => false  - show value from field in the results
 *              ],
 *          ]
 *      ]
 * ]
 * IMPORTANT INFO FOR CHILD GLOBAL SEARCH!!
 * If you add global search for your child page in your child model you have to setup array $admikoGlobalSearchParent
 * It is used to create correct link in results to your child edit page
 * 
 * example: static $admikoGlobalSearchParent = ["parent_model"=>"Gallery", 'child_parent_id'=>"gallery_images_parent_id"];
 * parent_model - path to parent model
 * child_parent_id - field in child table that contains parent ID
 **/