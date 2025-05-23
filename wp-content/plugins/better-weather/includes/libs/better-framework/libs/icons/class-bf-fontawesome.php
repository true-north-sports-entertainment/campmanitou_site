<?php

/**
 * Used for handling all actions about Fontawesome in PHP
 */
class BF_Fontawesome{

    /**
     * List of all icons
     *
     * @var array
     */
    public $icons = array();


    /**
     * List of all categories
     *
     * @var array
     */
    public $categories = array();


    /**
     * Version on current Awesomefont
     * @var string
     */
    public $version = '4.2.0';


    function __construct(){

        // Categories
        $this->categories = array(
            1 => array(
                'id'    =>  1,
                'label'  =>  'Web Application Icons'
            ),
            2 => array(
                'id'    =>  2,
                'label'  =>  'Form Control Icons'
            ),
            3 => array(
                'id'    =>  3,
                'label'  =>  'Currency Icons'
            ),
            4 => array(
                'id'    =>  4,
                'label'  =>  'Text Editor Icons'
            ),
            5 => array(
                'id'    =>  5,
                'label'  =>  'Directional Icons'
            ),
            6 => array(
                'id'    =>  6,
                'label'  =>  'Video Player Icons'
            ),
            7 => array(
                'id'    =>  7,
                'label'  =>  'Brand Icons'
            ),
            8 => array(
                'id'    =>  8,
                'label'  =>  'Medical Icons'
            ),
            9 => array(
                'id'    =>  9,
                'label'  =>  'Chart Icons'
            ),
            10 => array(
                'id'    =>  10,
                'label'  =>  'Payment Icons'
            ),

        );

        // Icons
        $this->icons = array(
            'fa-adjust' => array(
                'label' => 'Adjust',
                'category'=> array( 1 )
            ),
            'fa-anchor' => array(
                'label' => 'Anchor',
                'category'=> array( 1 )
            ),
            'fa-archive' => array(
                'label' => 'Archive',
                'category'=> array( 1 )
            ),
            'fa-arrows' => array(
                'label' => 'Arrows',
                'category'=> array( 1, 5 )
            ),
            'fa-arrows-h' => array(
                'label' => 'Arrows Horizontal',
                'category'=> array( 1, 5 )
            ),
            'fa-arrows-v' => array(
                'label' => 'Arrows Vertical',
                'category'=> array( 1, 5 )
            ),
            'fa-asterisk' => array(
                'label' => 'Asterisk',
                'category'=> array( 1 )
            ),
            'fa-ban' => array(
                'label' => 'Ban',
                'category'=> array( 1 )
            ),
            'fa-bar-chart-o' => array(
                'label' => 'Bar Chart',
                'category'=> array( 1 )
            ),
            'fa-barcode' => array(
                'label' => 'Barcode',
                'category'=> array( 1 )
            ),
            'fa-bars' => array(
                'label' => 'Bars',
                'category'=> array( 1 )
            ),
            'fa-beer' => array(
                'label' => 'Beer',
                'category'=> array( 1 )
            ),
            'fa-bell' => array(
                'label' => 'Bell',
                'category'=> array( 1 )
            ),
            'fa-bell-o' => array(
                'label' => 'Bell <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-bolt' => array(
                'label' => 'Bolt',
                'category'=> array( 1 )
            ),
            'fa-book' => array(
                'label' => 'Book',
                'category'=> array( 1 )
            ),
            'fa-bookmark' => array(
                'label' => 'Bookmark',
                'category'=> array( 1 )
            ),
            'fa-bookmark-o' => array(
                'label' => 'Bookmark <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-briefcase' => array(
                'label' => 'Briefcase',
                'category'=> array( 1 )
            ),
            'fa-bug' => array(
                'label' => 'Bug',
                'category'=> array( 1 )
            ),
            'fa-building-o' => array(
                'label' => 'Building <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-bullhorn' => array(
                'label' => 'Bullhorn',
                'category'=> array( 1 )
            ),
            'fa-bullseye' => array(
                'label' => 'Bullseye',
                'category'=> array( 1 )
            ),
            'fa-calendar' => array(
                'label' => 'Calendar',
                'category'=> array( 1 )
            ),
            'fa-calculator' => array(
                'label' => 'Calculator',
                'category'=> array( 1 )
            ),
            'fa-calendar-o' => array(
                'label' => 'Calendar <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-camera' => array(
                'label' => 'Camera',
                'category'=> array( 1 )
            ),
            'fa-camera-retro' => array(
                'label' => 'Camera Retro',
                'category'=> array( 1 )
            ),
            'fa-caret-square-o-down' => array(
                'label' => 'Caret Square Down <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 5 )
            ),
            'fa-caret-square-o-left' => array(
                'label' => 'Caret Square Left <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 5 )
            ),
            'fa-caret-square-o-right' => array(
                'label' => 'Caret Square Right <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 5 )
            ),
            'fa-caret-square-o-up' => array(
                'label' => 'Caret Square Up <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 5 )
            ),
            'fa-certificate' => array(
                'label' => 'Certificate',
                'category'=> array( 1 )
            ),
            'fa-check' => array(
                'label' => 'Check',
                'category'=> array( 1 )
            ),
            'fa-check-circle' => array(
                'label' => 'Check Circle',
                'category'=> array( 1 )
            ),
            'fa-check-circle-o' => array(
                'label' => 'Check Circle <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-check-square' => array(
                'label' => 'Check Square',
                'category'=> array( 1 , 2 )
            ),
            'fa-check-square-o' => array(
                'label' => 'Check Square <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 2 )
            ),
            'fa-circle' => array(
                'label' => 'Circle',
                'category'=> array( 1 , 2 )
            ),
            'fa-circle-o' => array(
                'label' => 'Circle <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 2 )
            ),
            'fa-clock-o' => array(
                'label' => 'Clock <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-cloud' => array(
                'label' => 'Cloud',
                'category'=> array( 1 )
            ),
            'fa-cloud-download' => array(
                'label' => 'Cloud Download',
                'category'=> array( 1 )
            ),
            'fa-cloud-upload' => array(
                'label' => 'Cloud Upload',
                'category'=> array( 1 )
            ),
            'fa-code' => array(
                'label' => 'Code',
                'category'=> array( 1 )
            ),
            'fa-code-fork' => array(
                'label' => 'Code Fork',
                'category'=> array( 1 )
            ),
            'fa-coffee' => array(
                'label' => 'Coffee',
                'category'=> array( 1 )
            ),
            'fa-cog' => array(
                'label' => 'Cog',
                'category'=> array( 1 )
            ),
            'fa-cogs' => array(
                'label' => 'Cogs',
                'category'=> array( 1 )
            ),
            'fa-comment' => array(
                'label' => 'Comment',
                'category'=> array( 1 )
            ),
            'fa-comment-o' => array(
                'label' => 'Comment <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-comments' => array(
                'label' => 'Comments'
            ),
            'fa-comments-o' => array(
                'label' => 'Comments <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-compass' => array(
                'label' => 'Compass',
                'category'=> array( 1 )
            ),
            'fa-credit-card' => array(
                'label' => 'Credit Card',
                'category'=> array( 1 )
            ),
            'fa-crop' => array(
                'label' => 'Crop',
                'category'=> array( 1 )
            ),
            'fa-crosshairs' => array(
                'label' => 'Crosshairs',
                'category'=> array( 1 )
            ),
            'fa-cutlery' => array(
                'label' => 'Cutlery',
                'category'=> array( 1 )
            ),
            'fa-dashboard' => array(
                'label' => 'Dashboard',
                'category'=> array( 1 )
            ),
            'fa-desktop' => array(
                'label' => 'Desktop',
                'category'=> array( 1 )
            ),
            'fa-dot-circle-o' => array(
                'label' => 'Dot Circle <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 2 )
            ),
            'fa-download' => array(
                'label' => 'Download',
                'category'=> array( 1 )
            ),
            'fa-edit' => array(
                'label' => 'Edit',
                'category'=> array( 1 )
            ),
            'fa-ellipsis-h' => array(
                'label' => 'Ellipsis Horizontal',
                'category'=> array( 1 )
            ),
            'fa-ellipsis-v' => array(
                'label' => 'Ellipsis Vertical',
                'category'=> array( 1 )
            ),
            'fa-envelope' => array(
                'label' => 'Envelope',
                'category'=> array( 1 )
            ),
            'fa-envelope-o' => array(
                'label' => 'Envelope <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-eraser' => array(
                'label' => 'fa-eraser',
                'category'=> array( 1 , 4 )
            ),
            'fa-exchange' => array(
                'label' => 'Exchange',
                'category'=> array( 1 )
            ),
            'fa-exclamation' => array(
                'label' => 'Exclamation',
                'category'=> array( 1 )
            ),
            'fa-exclamation-circle' => array(
                'label' => 'Exclamation Circle',
                'category'=> array( 1 )
            ),
            'fa-exclamation-triangle' => array(
                'label' => 'Exclamation Triangle',
                'category'=> array( 1 )
            ),
            'fa-external-link' => array(
                'label' => 'External Link',
                'category'=> array( 1 )
            ),
            'fa-external-link-square' => array(
                'label' => 'External Link Square',
                'category'=> array( 1 )
            ),
            'fa-eye' => array(
                'label' => 'Eye',
                'category'=> array( 1 )
            ),
            'fa-eye-slash' => array(
                'label' => 'Eye Slash',
                'category'=> array( 1 )
            ),
            'fa-female' => array(
                'label' => 'Female',
                'category'=> array( 1 )
            ),
            'fa-fighter-jet' => array(
                'label' => 'Fighter Jet',
                'category'=> array( 1 )
            ),
            'fa-film' => array(
                'label' => 'Film',
                'category'=> array( 1 )
            ),
            'fa-filter' => array(
                'label' => 'Filter',
                'category'=> array( 1 )
            ),
            'fa-fire' => array(
                'label' => 'Fire',
                'category'=> array( 1 )
            ),
            'fa-fire-extinguisher' => array(
                'label' => 'Fire Extinguisher',
                'category'=> array( 1 )
            ),
            'fa-flag' => array(
                'label' => 'Flag',
                'category'=> array( 1 )
            ),
            'fa-flag-checkered' => array(
                'label' => 'Flag Checkered',
                'category'=> array( 1 )
            ),
            'fa-flag-o' => array(
                'label' => 'Flag <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-flash' => array(
                'label' => 'Flash',
                'category'=> array( 1 )
            ),
            'fa-flask' => array(
                'label' => 'Flask',
                'category'=> array( 1 )
            ),
            'fa-folder' => array(
                'label' => 'Folder',
                'category'=> array( 1 )
            ),
            'fa-folder-o' => array(
                'label' => 'Folder <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-folder-open' => array(
                'label' => 'Folder Open',
                'category'=> array( 1 )
            ),
            'fa-folder-open-o' => array(
                'label' => 'Folder Open <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-frown-o' => array(
                'label' => 'Frown <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-gamepad' => array(
                'label' => 'Gamepad',
                'category'=> array( 1 )
            ),
            'fa-futbol-o' => array(
                'label' => 'Football',
                'category'=> array( 1 )
            ),
            'fa-gavel' => array(
                'label' => 'Gavel',
                'category'=> array( 1 )
            ),
            'fa-gear' => array(
                'label' => 'Gear',
                'category'=> array( 1 )
            ),
            'fa-gears' => array(
                'label' => 'Gears',
                'category'=> array( 1 )
            ),
            'fa-gift' => array(
                'label' => 'Gift',
                'category'=> array( 1 )
            ),
            'fa-glass' => array(
                'label' => 'Glass',
                'category'=> array( 1 )
            ),
            'fa-globe' => array(
                'label' => 'Globe',
                'category'=> array( 1 )
            ),
            'fa-group' => array(
                'label' => 'Group',
                'category'=> array( 1 )
            ),
            'fa-hdd-o' => array(
                'label' => 'HDD <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-headphones' => array(
                'label' => 'Headphones',
                'category'=> array( 1 )
            ),
            'fa-heart' => array(
                'label' => 'Heart',
                'category'=> array( 1 )
            ),
            'fa-heart-o' => array(
                'label' => 'Heart <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-home' => array(
                'label' => 'Home',
                'category'=> array( 1 )
            ),
            'fa-inbox' => array(
                'label' => 'Inbox',
                'category'=> array( 1 )
            ),
            'fa-info' => array(
                'label' => 'Info',
                'category'=> array( 1 )
            ),
            'fa-info-circle' => array(
                'label' => 'Info Circle',
                'category'=> array( 1 )
            ),
            'fa-key' => array(
                'label' => 'Key',
                'category'=> array( 1 )
            ),
            'fa-keyboard-o' => array(
                'label' => 'Keyboard <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-laptop' => array(
                'label' => 'Laptop',
                'category'=> array( 1 )
            ),
            'fa-leaf' => array(
                'label' => 'Leaf',
                'category'=> array( 1 )
            ),
            'fa-legal' => array(
                'label' => 'Legal',
                'category'=> array( 1 )
            ),
            'fa-lemon-o' => array(
                'label' => 'Lemon <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-level-down' => array(
                'label' => 'Level Down',
                'category'=> array( 1 )
            ),
            'fa-level-up' => array(
                'label' => 'Level Up',
                'category'=> array( 1 )
            ),
            'fa-lightbulb-o' => array(
                'label' => 'Lightbulb <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-location-arrow' => array(
                'label' => 'Location Arrow',
                'category'=> array( 1 )
            ),
            'fa-lock' => array(
                'label' => 'Lock',
                'category'=> array( 1 )
            ),
            'fa-magic' => array(
                'label' => 'Magic',
                'category'=> array( 1 )
            ),
            'fa-magnet' => array(
                'label' => 'Magnet',
                'category'=> array( 1 )
            ),
            'fa-mail-forward' => array(
                'label' => 'Mail Forward',
                'category'=> array( 1 )
            ),
            'fa-mail-reply' => array(
                'label' => 'Mail Reply',
                'category'=> array( 1 )
            ),
            'fa-mail-reply-all' => array(
                'label' => 'Mail Reply All',
                'category'=> array( 1 )
            ),
            'fa-male' => array(
                'label' => 'Male',
                'category'=> array( 1 )
            ),
            'fa-map-marker' => array(
                'label' => 'Map Marker',
                'category'=> array( 1 )
            ),
            'fa-meh-o' => array(
                'label' => 'Meh <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-microphone' => array(
                'label' => 'Microphone',
                'category'=> array( 1 )
            ),
            'fa-microphone-slash' => array(
                'label' => 'Microphone Slash',
                'category'=> array( 1 )
            ),
            'fa-minus' => array(
                'label' => 'Minus',
                'category'=> array( 1 )
            ),
            'fa-minus-circle' => array(
                'label' => 'Minus Circle',
                'category'=> array( 1 )
            ),
            'fa-minus-square' => array(
                'label' => 'Minus Square',
                'category'=> array( 1 , 2 )
            ),
            'fa-minus-square-o' => array(
                'label' => 'Minus Square <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 2 )
            ),
            'fa-mobile' => array(
                'label' => 'Mobile',
                'category'=> array( 1 )
            ),
            'fa-mobile-phone' => array(
                'label' => 'Mobile Phone',
                'category'=> array( 1 )
            ),
            'fa-money' => array(
                'label' => 'Money',
                'category'=> array( 1 , 3 )
            ),
            'fa-moon-o' => array(
                'label' => 'Moon <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-music' => array(
                'label' => 'Music',
                'category'=> array( 1 )
            ),
            'fa-pencil' => array(
                'label' => 'Pencil',
                'category'=> array( 1 )
            ),
            'fa-pencil-square' => array(
                'label' => 'Pencil Square',
                'category'=> array( 1 )
            ),
            'fa-pencil-square-o' => array(
                'label' => 'Pencil Square <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-phone' => array(
                'label' => 'Phone',
                'category'=> array( 1 )
            ),
            'fa-phone-square' => array(
                'label' => 'Phone Square',
                'category'=> array( 1 )
            ),
            'fa-picture-o' => array(
                'label' => 'Picture <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-plane' => array(
                'label' => 'Plane',
                'category'=> array( 1 )
            ),
            'fa-plus' => array(
                'label' => 'Plus',
                'category'=> array( 1 )
            ),
            'fa-plus-circle' => array(
                'label' => 'Plus Circle',
                'category'=> array( 1 )
            ),
            'fa-plus-square' => array(
                'label' => 'Plus Square',
                'category'=> array( 1 , 2 , 8 )
            ),
            'fa-plus-square-o' => array(
                'label' => 'Plus Square <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 2 )
            ),
            'fa-power-off' => array(
                'label' => 'Power Off',
                'category'=> array( 1 )
            ),
            'fa-print' => array(
                'label' => 'Print',
                'category'=> array( 1 )
            ),
            'fa-puzzle-piece' => array(
                'label' => 'Puzzle Piece',
                'category'=> array( 1 )
            ),
            'fa-qrcode' => array(
                'label' => 'QR Code',
                'category'=> array( 1 )
            ),
            'fa-question' => array(
                'label' => 'Question',
                'category'=> array( 1 )
            ),
            'fa-question-circle' => array(
                'label' => 'Question Circle',
                'category'=> array( 1 )
            ),
            'fa-quote-left' => array(
                'label' => 'Quote Left',
                'category'=> array( 1 )
            ),
            'fa-quote-right' => array(
                'label' => 'Quote Right',
                'category'=> array( 1 )
            ),
            'fa-random' => array(
                'label' => 'Random',
                'category'=> array( 1 )
            ),
            'fa-refresh' => array(
                'label' => 'Refresh',
                'category'=> array( 1 )
            ),
            'fa-reply' => array(
                'label' => 'Reply',
                'category'=> array( 1 )
            ),
            'fa-reply-all' => array(
                'label' => 'Reply All',
                'category'=> array( 1 )
            ),
            'fa-retweet' => array(
                'label' => 'Retweet',
                'category'=> array( 1 )
            ),
            'fa-road' => array(
                'label' => 'Road',
                'category'=> array( 1 )
            ),
            'fa-rocket' => array(
                'label' => 'Rocket',
                'category'=> array( 1 )
            ),
            'fa-rss' => array(
                'label' => 'RSS',
                'category'=> array( 1 )
            ),
            'fa-rss-square' => array(
                'label' => 'RSS Square',
                'category'=> array( 1 )
            ),
            'fa-search' => array(
                'label' => 'Search',
                'category'=> array( 1 )
            ),
            'fa-search-minus' => array(
                'label' => 'Search Minus',
                'category'=> array( 1 )
            ),
            'fa-search-plus' => array(
                'label' => 'Search Plus',
                'category'=> array( 1 )
            ),
            'fa-share' => array(
                'label' => 'Share'
            ),
            'fa-share-square' => array(
                'label' => 'Share Square',
                'category'=> array( 1 )
            ),
            'fa-share-square-o' => array(
                'label' => 'Share Square <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-shield' => array(
                'label' => 'Shield',
                'category'=> array( 1 )
            ),
            'fa-shopping-cart' => array(
                'label' => 'Shopping Cart',
                'category'=> array( 1 )
            ),
            'fa-sign-in' => array(
                'label' => 'Sign In',
                'category'=> array( 1 )
            ),
            'fa-sign-out' => array(
                'label' => 'Sign Out',
                'category'=> array( 1 )
            ),
            'fa-signal' => array(
                'label' => 'Signal',
                'category'=> array( 1 )
            ),
            'fa-sitemap' => array(
                'label' => 'Sitemap',
                'category'=> array( 1 )
            ),
            'fa-smile-o' => array(
                'label' => 'Smile <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-sort' => array(
                'label' => 'Sort',
                'category'=> array( 1 )
            ),
            'fa-sort-alpha-asc' => array(
                'label' => 'Sort Alpha Asc',
                'category'=> array( 1 )
            ),
            'fa-sort-alpha-desc' => array(
                'label' => 'Sort Alpha Desc',
                'category'=> array( 1 )
            ),
            'fa-sort-amount-asc' => array(
                'label' => 'Sort Amount Asc',
                'category'=> array( 1 )
            ),
            'fa-sort-amount-desc' => array(
                'label' => 'Sort Amount Desc',
                'category'=> array( 1 )
            ),
            'fa-sort-asc' => array(
                'label' => 'Sort Asc',
                'category'=> array( 1 )
            ),
            'fa-sort-desc' => array(
                'label' => 'Sort Desc',
                'category'=> array( 1 )
            ),
            'fa-sort-down' => array(
                'label' => 'Sort Down',
                'category'=> array( 1 )
            ),
            'fa-sort-numeric-asc' => array(
                'label' => 'Sort Numeric Asc',
                'category'=> array( 1 )
            ),
            'fa-sort-numeric-desc' => array(
                'label' => 'Sort Numeric Desc',
                'category'=> array( 1 )
            ),
            'fa-sort-up' => array(
                'label' => 'Sort Up',
                'category'=> array( 1 )
            ),
            'fa-spinner' => array(
                'label' => 'Spinner',
                'category'=> array( 1 )
            ),
            'fa-square' => array(
                'label' => 'Square',
                'category'=> array( 1 , 2 )
            ),
            'fa-square-o' => array(
                'label' => 'Square <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 , 2 )
            ),
            'fa-star' => array(
                'label' => 'Star',
                'category'=> array( 1 )
            ),
            'fa-star-half' => array(
                'label' => 'Star Half',
                'category'=> array( 1 )
            ),
            'fa-star-half-empty' => array(
                'label' => 'Star Half Empty',
                'category'=> array( 1 )
            ),
            'fa-star-half-full' => array(
                'label' => 'Star Half Full',
                'category'=> array( 1 )
            ),
            'fa-star-half-o' => array(
                'label' => 'Star Half <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-star-o' => array(
                'label' => 'Star <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-subscript' => array(
                'label' => 'Subscript',
                'category'=> array( 1 )
            ),
            'fa-suitcase' => array(
                'label' => 'Suitcase',
                'category'=> array( 1 )
            ),
            'fa-sun-o' => array(
                'label' => 'Sun <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-superscript' => array(
                'label' => 'Superscript',
                'category'=> array( 1 )
            ),
            'fa-tablet' => array(
                'label' => 'Tablet',
                'category'=> array( 1 )
            ),
            'fa-tachometer' => array(
                'label' => 'Tachometer',
                'category'=> array( 1 )
            ),
            'fa-tag' => array(
                'label' => 'Tag',
                'category'=> array( 1 )
            ),
            'fa-tags' => array(
                'label' => 'Tags',
                'category'=> array( 1 )
            ),
            'fa-tasks' => array(
                'label' => 'Tasks',
                'category'=> array( 1 )
            ),
            'fa-terminal' => array(
                'label' => 'Terminal',
                'category'=> array( 1 )
            ),
            'fa-thumb-tack' => array(
                'label' => 'Thumb Tack',
                'category'=> array( 1 )
            ),
            'fa-thumbs-down' => array(
                'label' => 'Thumbs Down',
                'category'=> array( 1 )
            ),
            'fa-thumbs-o-down' => array(
                'label' => 'Thumbs Down <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-thumbs-o-up' => array(
                'label' => 'Thumbs Up <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-thumbs-up' => array(
                'label' => 'Thumbs Up',
                'category'=> array( 1 )
            ),
            'fa-ticket' => array(
                'label' => 'Ticket',
                'category'=> array( 1 )
            ),
            'fa-times' => array(
                'label' => 'Times',
                'category'=> array( 1 )
            ),
            'fa-times-circle' => array(
                'label' => 'Times Circle',
                'category'=> array( 1 )
            ),
            'fa-times-circle-o' => array(
                'label' => 'Times Circle <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-tint' => array(
                'label' => 'Tint',
                'category'=> array( 1 )
            ),
            'fa-toggle-down' => array(
                'label' => 'Toggle Down',
                'category'=> array( 1 , 5 )
            ),
            'fa-toggle-left' => array(
                'label' => 'Toggle Left',
                'category'=> array( 1 , 5 )
            ),
            'fa-toggle-right' => array(
                'label' => 'Toggle Right',
                'category'=> array( 1 , 5 )
            ),
            'fa-toggle-up' => array(
                'label' => 'Toggle Up',
                'category'=> array( 1 , 5 )
            ),
            'fa-trash' => array(
                'label' => 'Trash',
                'category'=> array( 1 )
            ),
            'fa-trash-o' => array(
                'label' => 'Trash <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-trophy' => array(
                'label' => 'Trophy',
                'category'=> array( 1 )
            ),
            'fa-truck' => array(
                'label' => 'Truck',
                'category'=> array( 1 )
            ),
            'fa-umbrella' => array(
                'label' => 'Umbrella',
                'category'=> array( 1 )
            ),
            'fa-unlock' => array(
                'label' => 'Unlock',
                'category'=> array( 1 )
            ),
            'fa-unlock-alt' => array(
                'label' => 'Unlock Alt',
                'category'=> array( 1 )
            ),
            'fa-unsorted' => array(
                'label' => 'Unsorted',
                'category'=> array( 1 )
            ),
            'fa-upload' => array(
                'label' => 'Upload',
                'category'=> array( 1 )
            ),
            'fa-user' => array(
                'label' => 'User',
                'category'=> array( 1 )
            ),
            'fa-users' => array(
                'label' => 'Users',
                'category'=> array( 1 )
            ),
            'fa-video-camera' => array(
                'label' => 'Video Camera',
                'category'=> array( 1 )
            ),
            'fa-volume-down' => array(
                'label' => 'Volume Down',
                'category'=> array( 1 )
            ),
            'fa-volume-off' => array(
                'label' => 'Volume Off',
                'category'=> array( 1 )
            ),
            'fa-volume-up' => array(
                'label' => 'Volume Up',
                'category'=> array( 1 )
            ),
            'fa-warning' => array(
                'label' => 'Warning',
                'category'=> array( 1 )
            ),
            'fa-wheelchair' => array(
                'label' => 'Wheelchair',
                'category'=> array( 1 , 8 )
            ),
            'fa-wrench' => array(
                'label' => 'Wrench',
                'category'=> array( 1 )
            ),
            'fa-automobile' => array(
                'label' => 'Automobile',
                'category'=> array( 1 )
            ),
            'fa-bank' => array(
                'label' => 'Bank',
                'category'=> array( 1 )
            ),
            'fa-bomb' => array(
                'label' => 'Bomb',
                'category'=> array( 1 )
            ),
            'fa-building' => array(
                'label' => 'Building',
                'category'=> array( 1 )
            ),
            'fa-cab' => array(
                'label' => 'Cab',
                'category'=> array( 1 )
            ),
            'fa-car' => array(
                'label' => 'Car',
                'category'=> array( 1 )
            ),
            'fa-bus' => array(
                'label' => 'Bus',
                'category'=> array( 1 )
            ),
            'fa-child' => array(
                'label' => 'Child',
                'category'=> array( 1 )
            ),
            'fa-circle-o-notch' => array(
                'label' => 'Circle Notch <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-circle-thin' => array(
                'label' => 'Circle Thin',
                'category'=> array( 1 )
            ),
            'fa-cube' => array(
                'label' => 'Cube',
                'category'=> array( 1 )
            ),
            'fa-cubes' => array(
                'label' => 'Cubes',
                'category'=> array( 1 )
            ),
            'fa-database' => array(
                'label' => 'Database',
                'category'=> array( 1 )
            ),
            'fa-envelope-square' => array(
                'label' => 'Envelope Square',
                'category'=> array( 1 )
            ),
            'fa-fax' => array(
                'label' => 'Fax',
                'category'=> array( 1 )
            ),
            'fa-file-archive-o' => array(
                'label' => 'File Archive <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-audio-o' => array(
                'label' => 'File Audio <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-code-o' => array(
                'label' => 'File Code <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-excel-o' => array(
                'label' => 'File Excel <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-image-o' => array(
                'label' => 'File Image <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-movie-o' => array(
                'label' => 'File Movie <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-pdf-o' => array(
                'label' => 'File PDF <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-photo-o' => array(
                'label' => 'File Photo <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-picture-o' => array(
                'label' => 'File Picture <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-powerpoint-o' => array(
                'label' => 'File Powerpoint <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-sound-o' => array(
                'label' => 'File Sound <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-video-o' => array(
                'label' => 'File Video <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-word-o' => array(
                'label' => 'File Word <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-file-zip-o' => array(
                'label' => 'File Zip <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-ge' => array(
                'label' => 'Ge',
                'category'=> array( 1 )
            ),
            'fa-graduation-cap' => array(
                'label' => 'Graduation Cap',
                'category'=> array( 1 )
            ),
            'fa-history' => array(
                'label' => 'History',
                'category'=> array( 1 )
            ),
            'fa-institution' => array(
                'label' => 'Institution',
                'category'=> array( 1 )
            ),
            'fa-language' => array(
                'label' => 'Language',
                'category'=> array( 1 )
            ),
            'fa-life-bouy' => array(
                'label' => 'Life Bouy',
                'category'=> array( 1 )
            ),
            'fa-life-ring' => array(
                'label' => 'Life Ring',
                'category'=> array( 1 )
            ),
            'fa-life-saver' => array(
                'label' => 'Life Saver',
                'category'=> array( 1 )
            ),
            'fa-mortar-board' => array(
                'label' => 'Mortar Board',
                'category'=> array( 1 )
            ),
            'fa-paper-plane' => array(
                'label' => 'Paper Plane',
                'category'=> array( 1 )
            ),
            'fa-paper-plane-o' => array(
                'label' => 'Paper Plane <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-paw' => array(
                'label' => 'Paw',
                'category'=> array( 1 )
            ),
            'fa-recycle' => array(
                'label' => 'Recycle',
                'category'=> array( 1 )
            ),
            'fa-send' => array(
                'label' => 'Send',
                'category'=> array( 1 )
            ),
            'fa-send-o' => array(
                'label' => 'Send <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-share-alt' => array(
                'label' => 'Share Alt',
                'category'=> array( 1 )
            ),
            'fa-share-alt-square' => array(
                'label' => 'Share Slt Square',
                'category'=> array( 1 )
            ),
            'fa-sliders' => array(
                'label' => 'Sliders',
                'category'=> array( 1 )
            ),
            'fa-space-shuttle' => array(
                'label' => 'Space Shuttle',
                'category'=> array( 1 )
            ),
            'fa-spoon' => array(
                'label' => 'Spoon',
                'category'=> array( 1 )
            ),
            'fa-support' => array(
                'label' => 'Support',
                'category'=> array( 1 )
            ),
            'fa-taxi' => array(
                'label' => 'Taxi',
                'category'=> array( 1 )
            ),
            'fa-tree' => array(
                'label' => 'Tree',
                'category'=> array( 1 )
            ),
            'fa-university' => array(
                'label' => 'University',
                'category'=> array( 1 )
            ),
            'fa-area-chart' => array(
                'label' => 'Area Chart',
                'category'=> array( 1, 9 )
            ),
            'fa-line-chart' => array(
                'label' => 'Line Chart',
                'category'=> array( 1, 9 )
            ),
            'fa-pie-chart' => array(
                'label' => 'Pie Chart',
                'category'=> array( 1, 9 )
            ),
            'fa-at' => array(
                'label' => 'At-sign',
                'category'=> array( 1 )
            ),
            'fa-bell-slash' => array(
                'label' => 'Bell Slash',
                'category'=> array( 1 )
            ),
            'fa-bell-slash-o' => array(
                'label' => 'Bell Slash <span class="text-muted">(Outline)</span>',
                'category'=> array( 1 )
            ),
            'fa-bicycle' => array(
                'label' => 'Bicycle',
                'category'=> array( 1 )
            ),
            'fa-binoculars' => array(
                'label' => 'Binoculars',
                'category'=> array( 1 )
            ),
            'fa-birthday-cake' => array(
                'label' => 'Birthday Cake',
                'category'=> array( 1 )
            ),
            'fa-cc' => array(
                'label' => 'CC',
                'category'=> array( 1 )
            ),
            'fa-copyright' => array(
                'label' => 'Copyright',
                'category'=> array( 1 )
            ),
            'fa-eyedropper' => array(
                'label' => 'Eyedropper',
                'category'=> array( 1 )
            ),
            'fa-newspaper-o' => array(
                'label' => 'Newspaper',
                'category'=> array( 1 )
            ),
            'fa-paint-brush' => array(
                'label' => 'Paint Brush',
                'category'=> array( 1 )
            ),
            'fa-plug' => array(
                'label' => 'Plug',
                'category'=> array( 1 )
            ),
            'fa-toggle-off' => array(
                'label' => 'Toggle Off',
                'category'=> array( 1 )
            ),
            'fa-toggle-on' => array(
                'label' => 'Toggle On',
                'category'=> array( 1 )
            ),
            'fa-tty' => array(
                'label' => 'Text Telephone',
                'category'=> array( 1 )
            ),
            'fa-wifi' => array(
                'label' => 'Wifi',
                'category'=> array( 1 )
            ),


            // Cat 3
            'fa-bitcoin' => array(
                'label' => 'Bitcoin',
                'category'=> array( 3 , 7 )
            ),
            'fa-btc' => array(
                'label' => 'BTC',
                'category'=> array( 3 , 7 )
            ),
            'fa-cny' => array(
                'label' => 'CNY',
                'category'=> array( 3 )
            ),
            'fa-dollar' => array(
                'label' => 'Dollar',
                'category'=> array( 3 )
            ),
            'fa-eur' => array(
                'label' => 'EUR',
                'category'=> array( 3 )
            ),
            'fa-euro' => array(
                'label' => 'Euro',
                'category'=> array( 3 )
            ),
            'fa-gbp' => array(
                'label' => 'GBP',
                'category'=> array( 3 )
            ),
            'fa-inr' => array(
                'label' => 'INR',
                'category'=> array( 3 )
            ),
            'fa-jpy' => array(
                'label' => 'JPY',
                'category'=> array( 3 )
            ),
            'fa-krw' => array(
                'label' => 'KRW',
                'category'=> array( 3 )
            ),
            'fa-rmb' => array(
                'label' => 'RMB',
                'category'=> array( 3 )
            ),
            'fa-rouble' => array(
                'label' => 'Rouble',
                'category'=> array( 3 )
            ),
            'fa-rub' => array(
                'label' => 'RUB',
                'category'=> array( 3 )
            ),
            'fa-ruble' => array(
                'label' => 'Ruble',
                'category'=> array( 3 )
            ),
            'fa-rupee' => array(
                'label' => 'Rupee',
                'category'=> array( 3 )
            ),
            'fa-try' => array(
                'label' => 'TRY',
                'category'=> array( 3 )
            ),
            'fa-turkish-lira' => array(
                'label' => 'Turkish Lira',
                'category'=> array( 3 )
            ),
            'fa-usd' => array(
                'label' => 'USD',
                'category'=> array( 3 )
            ),
            'fa-won' => array(
                'label' => 'WON',
                'category'=> array( 3 )
            ),
            'fa-yen' => array(
                'label' => 'Yen',
                'category'=> array( 3 )
            ),
            'fa-ils' => array(
                'label' => 'ILS ( Israel Shekel )',
                'category'=> array( 3 )
            ),


            // Cat 4
            'fa-align-center' => array(
                'label' => 'Align Center',
                'category'=> array( 4 )
            ),
            'fa-align-justify' => array(
                'label' => 'Align Justify',
                'category'=> array( 4 )
            ),
            'fa-align-left' => array(
                'label' => 'Align Left',
                'category'=> array( 4 )
            ),
            'fa-align-right' => array(
                'label' => 'Align Right',
                'category'=> array( 4 )
            ),
            'fa-bold' => array(
                'label' => 'Bold',
                'category'=> array( 4 )
            ),
            'fa-chain' => array(
                'label' => 'Chain',
                'category'=> array( 4 )
            ),
            'fa-chain-broken' => array(
                'label' => 'Chain Broken',
                'category'=> array( 4 )
            ),
            'fa-clipboard' => array(
                'label' => 'Clipboard',
                'category'=> array( 4 )
            ),
            'fa-columns' => array(
                'label' => 'Columns',
                'category'=> array( 4 )
            ),
            'fa-copy' => array(
                'label' => 'Copy',
                'category'=> array( 4 )
            ),
            'fa-cut' => array(
                'label' => 'Cut',
                'category'=> array( 4 )
            ),
            'fa-dedent' => array(
                'label' => 'Dedent',
                'category'=> array( 4 )
            ),
            'fa-file' => array(
                'label' => 'File',
                'category'=> array( 4 )
            ),
            'fa-file-o' => array(
                'label' => 'File <span class="text-muted">(Outline)</span>',
                'category'=> array( 4 )
            ),
            'fa-file-text' => array(
                'label' => 'File Text',
                'category'=> array( 4 )
            ),
            'fa-file-text-o' => array(
                'label' => 'File Text <span class="text-muted">(Outline)</span>',
                'category'=> array( 4 )
            ),
            'fa-files-o' => array(
                'label' => 'Files <span class="text-muted">(Outline)</span>',
                'category'=> array( 4 )
            ),
            'fa-floppy-o' => array(
                'label' => 'Floppy <span class="text-muted">(Outline)</span>',
                'category'=> array( 4 )
            ),
            'fa-font' => array(
                'label' => 'Font',
                'category'=> array( 4 )
            ),
            'fa-indent' => array(
                'label' => 'Indent',
                'category'=> array( 4 )
            ),
            'fa-italic' => array(
                'label' => 'Italic',
                'category'=> array( 4 )
            ),
            'fa-link' => array(
                'label' => 'Link',
                'category'=> array( 4 )
            ),
            'fa-list' => array(
                'label' => 'List',
                'category'=> array( 4 )
            ),
            'fa-list-alt' => array(
                'label' => 'List Alt',
                'category'=> array( 4 )
            ),
            'fa-list-ol' => array(
                'label' => 'List Ordered List',
                'category'=> array( 4 )
            ),
            'fa-list-ul' => array(
                'label' => 'List Unordered List',
                'category'=> array( 4 )
            ),
            'fa-outdent' => array(
                'label' => 'Outdent',
                'category'=> array( 4 )
            ),
            'fa-paperclip' => array(
                'label' => 'Paperclip',
                'category'=> array( 4 )
            ),
            'fa-paste' => array(
                'label' => 'Paste',
                'category'=> array( 4 )
            ),
            'fa-repeat' => array(
                'label' => 'Repeat',
                'category'=> array( 4 )
            ),
            'fa-rotate-left' => array(
                'label' => 'Rotate Left',
                'category'=> array( 4 )
            ),
            'fa-rotate-right' => array(
                'label' => 'Rotate Right',
                'category'=> array( 4 )
            ),
            'fa-save' => array(
                'label' => 'Save',
                'category'=> array( 4 )
            ),
            'fa-scissors' => array(
                'label' => 'Scissors',
                'category'=> array( 4 )
            ),
            'fa-strikethrough' => array(
                'label' => 'Strikethrough',
                'category'=> array( 4 )
            ),
            'fa-table' => array(
                'label' => 'Table',
                'category'=> array( 4 )
            ),
            'fa-text-height' => array(
                'label' => 'Text Height',
                'category'=> array( 4 )
            ),
            'fa-text-width' => array(
                'label' => 'Text Width',
                'category'=> array( 4 )
            ),
            'fa-th' => array(
                'label' => 'th',
                'category'=> array( 4 )
            ),
            'fa-th-large' => array(
                'label' => 'th Large',
                'category'=> array( 4 )
            ),
            'fa-th-list' => array(
                'label' => 'th List',
                'category'=> array( 4 )
            ),
            'fa-underline' => array(
                'label' => 'Underline',
                'category'=> array( 4 )
            ),
            'fa-undo' => array(
                'label' => 'Undo',
                'category'=> array( 4 )
            ),
            'fa-unlink' => array(
                'label' => 'Unlink',
                'category'=> array( 4 )
            ),
            'fa-header' => array(
                'label' => 'Header',
                'category'=> array( 4 )
            ),
            'fa-paragraph' => array(
                'label' => 'Paragraph',
                'category'=> array( 4 )
            ),


            // Cat 5
            'fa-angle-double-down' => array(
                'label' => 'Angle Double Down',
                'category'=> array( 5 )
            ),
            'fa-angle-double-left' => array(
                'label' => 'Angle Double Left',
                'category'=> array( 5 )
            ),
            'fa-angle-double-right' => array(
                'label' => 'Angle Double Right',
                'category'=> array( 5 )
            ),
            'fa-angle-double-up' => array(
                'label' => 'Angle Double Up',
                'category'=> array( 5 )
            ),
            'fa-angle-down' => array(
                'label' => 'Angle Down',
                'category'=> array( 5 )
            ),
            'fa-angle-left' => array(
                'label' => 'Angle Left',
                'category'=> array( 5 )
            ),
            'fa-angle-right' => array(
                'label' => 'Angle Right',
                'category'=> array( 5 )
            ),
            'fa-angle-up' => array(
                'label' => 'Angle Up',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-down' => array(
                'label' => 'Arrow Circle Down',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-left' => array(
                'label' => 'Arrow Circle Left',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-o-down' => array(
                'label' => 'Arrow Circle Down <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-o-left' => array(
                'label' => 'Arrow Circle Left <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-o-right' => array(
                'label' => 'Arrow Circle Right <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-o-up' => array(
                'label' => 'Arrow Circle Up <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-right' => array(
                'label' => 'Arrow Circle Right',
                'category'=> array( 5 )
            ),
            'fa-arrow-circle-up' => array(
                'label' => 'Arrow Circle Up',
                'category'=> array( 5 )
            ),
            'fa-arrow-down' => array(
                'label' => 'Arrow Down',
                'category'=> array( 5 )
            ),
            'fa-arrow-left' => array(
                'label' => 'Arrow Left',
                'category'=> array( 5 )
            ),
            'fa-arrow-right' => array(
                'label' => 'Arrow Right',
                'category'=> array( 5 )
            ),
            'fa-arrow-up' => array(
                'label' => 'Arrow Up',
                'category'=> array( 5 )
            ),
            'fa-arrows-alt' => array(
                'label' => 'Arrows Alt',
                'category'=> array( 5 , 6 )
            ),
            'fa-caret-down' => array(
                'label' => 'Caret Down',
                'category'=> array( 5 )
            ),
            'fa-caret-left' => array(
                'label' => 'Caret Left',
                'category'=> array( 5 )
            ),
            'fa-caret-right' => array(
                'label' => 'Caret Right',
                'category'=> array( 5 )
            ),
            'fa-caret-up' => array(
                'label' => 'Caret Up',
                'category'=> array( 5 )
            ),
            'fa-chevron-circle-down' => array(
                'label' => 'Chevron Circle Down',
                'category'=> array( 5 )
            ),
            'fa-chevron-circle-left' => array(
                'label' => 'Chevron Circle Left',
                'category'=> array( 5 )
            ),
            'fa-chevron-circle-right' => array(
                'label' => 'Chevron Circle Right',
                'category'=> array( 5 )
            ),
            'fa-chevron-circle-up' => array(
                'label' => 'Chevron Circle Up',
                'category'=> array( 5 )
            ),
            'fa-chevron-down' => array(
                'label' => 'Chevron Down',
                'category'=> array( 5 )
            ),
            'fa-chevron-left' => array(
                'label' => 'Chevron Left',
                'category'=> array( 5 )
            ),
            'fa-chevron-right' => array(
                'label' => 'Chevron Right',
                'category'=> array( 5 )
            ),
            'fa-chevron-up' => array(
                'label' => 'Chevron Up',
                'category'=> array( 5 )
            ),
            'fa-hand-o-down' => array(
                'label' => 'Hand Down <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-hand-o-left' => array(
                'label' => 'Hand Left <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-hand-o-right' => array(
                'label' => 'Hand Right <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-hand-o-up' => array(
                'label' => 'Hand Up <span class="text-muted">(Outline)</span>',
                'category'=> array( 5 )
            ),
            'fa-long-arrow-down' => array(
                'label' => 'Long Arrow Down',
                'category'=> array( 5 )
            ),
            'fa-long-arrow-left' => array(
                'label' => 'Long Arrow Left',
                'category'=> array( 5 )
            ),
            'fa-long-arrow-right' => array(
                'label' => 'Long Arrow Right',
                'category'=> array( 5 )
            ),
            'fa-long-arrow-up' => array(
                'label' => 'Long Arrow Up',
                'category'=> array( 5 )
            ),


            // Cat 6
            'fa-backward' => array(
                'label' => 'Backward',
                'category'=> array( 6 )
            ),
            'fa-compress' => array(
                'label' => 'Compress',
                'category'=> array( 6 )
            ),
            'fa-eject' => array(
                'label' => 'Eject',
                'category'=> array( 6 )
            ),
            'fa-expand' => array(
                'label' => 'Expand',
                'category'=> array( 6 )
            ),
            'fa-fast-backward' => array(
                'label' => 'Fast Backward',
                'category'=> array( 6 )
            ),
            'fa-fast-forward' => array(
                'label' => 'Fast Forward',
                'category'=> array( 6 )
            ),
            'fa-forward' => array(
                'label' => 'Forward',
                'category'=> array( 6 )
            ),
            'fa-pause' => array(
                'label' => 'Pause',
                'category'=> array( 6 )
            ),
            'fa-play' => array(
                'label' => 'Play',
                'category'=> array( 6 )
            ),
            'fa-play-circle' => array(
                'label' => 'Play Circle',
                'category'=> array( 6 )
            ),
            'fa-play-circle-o' => array(
                'label' => 'Play Circle <span class="text-muted">(Outline)</span>',
                'category'=> array( 6 )
            ),
            'fa-step-backward' => array(
                'label' => 'Step Backward',
                'category'=> array( 6 )
            ),
            'fa-step-forward' => array(
                'label' => 'Step Forward',
                'category'=> array( 6 )
            ),
            'fa-stop' => array(
                'label' => 'Stop',
                'category'=> array( 6 )
            ),
            'fa-youtube-play' => array(
                'label' => 'Youtube Play',
                'category'=> array( 6 , 7 )
            ),


            // Cat 7
            'fa-adn' => array(
                'label' => 'ADN',
                'category'=> array( 7 )
            ),
            'fa-android' => array(
                'label' => 'Android',
                'category'=> array( 7 )
            ),
            'fa-apple' => array(
                'label' => 'Apple',
                'category'=> array( 7 )
            ),
            'fa-bitbucket' => array(
                'label' => 'Bitbucket',
                'category'=> array( 7 )
            ),
            'fa-bitbucket-square' => array(
                'label' => 'Bitbucket Square',
                'category'=> array( 7 )
            ),
            'fa-css3' => array(
                'label' => 'CSS3',
                'category'=> array( 7 )
            ),
            'fa-dribbble' => array(
                'label' => 'Dribbble',
                'category'=> array( 7 )
            ),
            'fa-dropbox' => array(
                'label' => 'Dropbox',
                'category'=> array( 7 )
            ),
            'fa-facebook' => array(
                'label' => 'Facebook',
                'category'=> array( 7 )
            ),
            'fa-facebook-square' => array(
                'label' => 'Facebook Square',
                'category'=> array( 7 )
            ),
            'fa-flickr' => array(
                'label' => 'Flickr',
                'category'=> array( 7 )
            ),
            'fa-foursquare' => array(
                'label' => 'Foursquare',
                'category'=> array( 7 )
            ),
            'fa-github' => array(
                'label' => 'Github',
                'category'=> array( 7 )
            ),
            'fa-github-alt' => array(
                'label' => 'Github Alt',
                'category'=> array( 7 )
            ),
            'fa-github-square' => array(
                'label' => 'Github Square',
                'category'=> array( 7 )
            ),
            'fa-gittip' => array(
                'label' => 'Gittip',
                'category'=> array( 7 )
            ),
            'fa-google-plus' => array(
                'label' => 'Google Plus',
                'category'=> array( 7 )
            ),
            'fa-google-plus-square' => array(
                'label' => 'Google Plus Square',
                'category'=> array( 7 )
            ),
            'fa-html5' => array(
                'label' => 'HTML5',
                'category'=> array( 7 )
            ),
            'fa-instagram' => array(
                'label' => 'Instagram',
                'category'=> array( 7 )
            ),
            'fa-linkedin' => array(
                'label' => 'Linkedin',
                'category'=> array( 7 )
            ),
            'fa-linkedin-square' => array(
                'label' => 'Linkedin Square',
                'category'=> array( 7 )
            ),
            'fa-linux' => array(
                'label' => 'Linux',
                'category'=> array( 7 )
            ),
            'fa-maxcdn' => array(
                'label' => 'Max CDN',
                'category'=> array( 7 )
            ),
            'fa-pagelines' => array(
                'label' => 'Pagelines',
                'category'=> array( 7 )
            ),
            'fa-pinterest' => array(
                'label' => 'Pinterest',
                'category'=> array( 7 )
            ),
            'fa-pinterest-square' => array(
                'label' => 'Pinterest Square',
                'category'=> array( 7 )
            ),
            'fa-renren' => array(
                'label' => 'Renren',
                'category'=> array( 7 )
            ),
            'fa-skype' => array(
                'label' => 'Skype',
                'category'=> array( 7 )
            ),
            'fa-stack-exchange' => array(
                'label' => 'Stack Exchange',
                'category'=> array( 7 )
            ),
            'fa-stack-overflow' => array(
                'label' => 'Stack Overflow',
                'category'=> array( 7 )
            ),
            'fa-trello' => array(
                'label' => 'Trello',
                'category'=> array( 7 )
            ),
            'fa-tumblr' => array(
                'label' => 'Tumblr',
                'category'=> array( 7 )
            ),
            'fa-tumblr-square' => array(
                'label' => 'Tumblr Square',
                'category'=> array( 7 )
            ),
            'fa-twitter' => array(
                'label' => 'Twitter',
                'category'=> array( 7 )
            ),
            'fa-twitter-square' => array(
                'label' => 'Twitter Square',
                'category'=> array( 7 )
            ),
            'fa-vimeo-square' => array(
                'label' => 'Vimeo Square',
                'category'=> array( 7 )
            ),
            'fa-vk' => array(
                'label' => 'VK',
                'category'=> array( 7 )
            ),
            'fa-weibo' => array(
                'label' => 'Weibo',
                'category'=> array( 7 )
            ),
            'fa-windows' => array(
                'label' => 'Windows',
                'category'=> array( 7 )
            ),
            'fa-xing' => array(
                'label' => 'Xing',
                'category'=> array( 7 )
            ),
            'fa-xing-square' => array(
                'label' => 'Xing Square',
                'category'=> array( 7 )
            ),
            'fa-youtube' => array(
                'label' => 'Youtube',
                'category'=> array( 7 )
            ),
            'fa-youtube-square' => array(
                'label' => 'Youtube Square',
                'category'=> array( 7 )
            ),
            'fa-behance' => array(
                'label' => 'Behance',
                'category'=> array( 7 )
            ),
            'fa-behance-square' => array(
                'label' => 'Behance Square',
                'category'=> array( 7 )
            ),
            'fa-codepen' => array(
                'label' => 'Codepen',
                'category'=> array( 7 )
            ),
            'fa-delicious' => array(
                'label' => 'Delicious',
                'category'=> array( 7 )
            ),
            'fa-deviantart' => array(
                'label' => 'Deviantart',
                'category'=> array( 7 )
            ),
            'fa-digg' => array(
                'label' => 'digg',
                'category'=> array( 7 )
            ),
            'fa-drupal' => array(
                'label' => 'Drupal',
                'category'=> array( 7 )
            ),
            'fa-empire' => array(
                'label' => 'Empire',
                'category'=> array( 7 )
            ),
            'fa-git' => array(
                'label' => 'Git',
                'category'=> array( 7 )
            ),
            'fa-git-square' => array(
                'label' => 'Git Square',
                'category'=> array( 7 )
            ),
            'fa-google' => array(
                'label' => 'Google',
                'category'=> array( 7 )
            ),
            'fa-hacker-news' => array(
                'label' => 'Hacker News',
                'category'=> array( 7 )
            ),
            'fa-joomla' => array(
                'label' => 'Joomla',
                'category'=> array( 7 )
            ),
            'fa-jsfiddle' => array(
                'label' => 'JSFiddle',
                'category'=> array( 7 )
            ),
            'fa-openid' => array(
                'label' => 'OpenID',
                'category'=> array( 7 )
            ),
            'fa-pied-piper' => array(
                'label' => 'Pied Piper',
                'category'=> array( 7 )
            ),
            'fa-pied-piper-alt' => array(
                'label' => 'Pied Piper Alt',
                'category'=> array( 7 )
            ),
            'fa-pied-piper-square' => array(
                'label' => 'Pied Piper Square',
                'category'=> array( 7 )
            ),
            'fa-qq' => array(
                'label' => 'qq',
                'category'=> array( 7 )
            ),
            'fa-ra' => array(
                'label' => 'ra',
                'category'=> array( 7 )
            ),
            'fa-rebel' => array(
                'label' => 'Rebel',
                'category'=> array( 7 )
            ),
            'fa-reddit' => array(
                'label' => 'Reddit',
                'category'=> array( 7 )
            ),
            'fa-reddit-square' => array(
                'label' => 'Reddit Square',
                'category'=> array( 7 )
            ),
            'fa-slack' => array(
                'label' => 'Slack',
                'category'=> array( 7 )
            ),
            'fa-soundcloud' => array(
                'label' => 'Soundcloud',
                'category'=> array( 7 )
            ),
            'fa-spotify' => array(
                'label' => 'Spotify',
                'category'=> array( 7 )
            ),
            'fa-steam' => array(
                'label' => 'Steam',
                'category'=> array( 7 )
            ),
            'fa-steam-square' => array(
                'label' => 'Steam Square',
                'category'=> array( 7 )
            ),
            'fa-stumbleupon' => array(
                'label' => 'Stumbleupon',
                'category'=> array( 7 )
            ),
            'fa-stumbleupon-circle' => array(
                'label' => 'Stumbleupon Circle',
                'category'=> array( 7 )
            ),
            'fa-tencent-weibo' => array(
                'label' => 'Tencent Weibo',
                'category'=> array( 7 )
            ),
            'fa-vine' => array(
                'label' => 'Vine',
                'category'=> array( 7 )
            ),
            'fa-wechat' => array(
                'label' => 'Wechat',
                'category'=> array( 7 )
            ),
            'fa-weixin' => array(
                'label' => 'Weixin',
                'category'=> array( 7 )
            ),
            'fa-wordpress' => array(
                'label' => 'WordPress',
                'category'=> array( 7 )
            ),
            'fa-yahoo' => array(
                'label' => 'Yahoo',
                'category'=> array( 7 )
            ),
            'fa-angellist' => array(
                'label' => 'Angellist',
                'category'=> array( 7 )
            ),
            'fa-ioxhost' => array(
                'label' => 'IoxHost',
                'category'=> array( 7 )
            ),
            'fa-lastfm' => array(
                'label' => 'Lastfm',
                'category'=> array( 7 )
            ),
            'fa-lastfm-square' => array(
                'label' => 'Lastfm Square',
                'category'=> array( 7 )
            ),
            'fa-meanpath' => array(
                'label' => 'Meanpath',
                'category'=> array( 7 )
            ),
            'fa-slideshare' => array(
                'label' => 'Slideshare',
                'category'=> array( 7 )
            ),
            'fa-twitch' => array(
                'label' => 'Twitch',
                'category'=> array( 7 )
            ),
            'fa-yelp' => array(
                'label' => 'Yelp',
                'category'=> array( 7 )
            ),


            // Cat 8
            'fa-ambulance' => array(
                'label' => 'Ambulance',
                'category'=> array( 8 )
            ),
            'fa-h-square' => array(
                'label' => 'Hospital Square',
                'category'=> array( 8 )
            ),
            'fa-hospital-o' => array(
                'label' => 'Hospital <span class="text-muted">(Outline)</span>',
                'category'=> array( 8 )
            ),
            'fa-medkit' => array(
                'label' => 'Medical kit',
                'category'=> array( 8 )
            ),
            'fa-stethoscope' => array(
                'label' => 'Stethoscope',
                'category'=> array( 8 )
            ),
            'fa-user-md' => array(
                'label' => 'User Medical',
                'category'=> array( 8 )
            ),


            // Cat 10
            'fa-cc-amex' => array(
                'label' => 'CC Amex',
                'category'=> array( 7, 10 )
            ),
            'fa-cc-discover' => array(
                'label' => 'CC Discover',
                'category'=> array( 7, 10 )
            ),
            'fa-cc-mastercard' => array(
                'label' => 'CC Mastercard',
                'category'=> array( 7, 10 )
            ),
            'fa-cc-paypal' => array(
                'label' => 'CC Paypal',
                'category'=> array( 7, 10 )
            ),
            'fa-cc-stripe' => array(
                'label' => 'CC Stripe',
                'category'=> array( 7, 10 )
            ),
            'fa-cc-visa' => array(
                'label' => 'CC Visa',
                'category'=> array( 7, 10 )
            ),
            'fa-google-wallet' => array(
                'label' => 'Google Wallet',
                'category'=> array( 7, 10 )
            ),
            'fa-paypal' => array(
                'label' => 'Paypal',
                'category'=> array( 7, 10 )
            ),


        );

        // Count each category icons
        $this->countCategoriesIcons();

    }

    /**
     * Counts icons in each category
     */
    function countCategoriesIcons(){

        foreach( (array) $this->icons as $icon){

            if( isset( $icon['category'] ) && count( $icon['category'] ) ){

                foreach( $icon['category'] as $key => $category ){

                    if( ! isset( $this->categories[$category] ) )
                        continue;

                    if( isset( $this->categories[$category]['counts'] ) ){
                        $this->categories[$category]['counts'] = intval( $this->categories[$category]['counts'] ) + 1;
                    }else{
                        $this->categories[$category]['counts'] = 1;
                    }
                }
            }
        }

    }

    /**
     * Generate tag icon
     *
     * @param $icon_key
     * @param $classes
     * @return string
     */
    function getIconTag( $icon_key , $classes='' ){

        $classes = apply_filters( 'better_fontawesome_icons_classes' , $classes );

        if( ! isset( $this->icons[$icon_key] ) )
            return '';

        return '<i class="bf-icon fa '.$icon_key .' ' . $classes . '"></i>';

    }
}