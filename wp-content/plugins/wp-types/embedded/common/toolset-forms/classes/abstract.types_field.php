<?php
/*
 * This is example of what Types need foomplex fields like Skype.
 * @see class.skype.php
 */

abstract class WPToolset_Types_Field
{

    // type of Types field e.g. 'skype', 'wysiwyg'
    protected $type;
    // Types needs to know kind of data e.g. 'postmeta', 'usermeta'
    // Needed for future implementations, like 'taxmeta'
    protected $metatype;
    // Part of Toolset or 3rd party e.g. 'cred', 'types', 'views'
    protected $client;

    // Use construct to register scripts and styles
    abstract public function __construct();

    // Auto-called from Loader on field demand
    abstract public function enqueueScripts();

    // Auto-called from Loader on field demand
    abstract public function enqueueStyles();

    // Types will use this to define display mode
    // e.g. CRED on frontend, Types on post edit screen
    abstract public function metaform( $config, &$form );

    // Types will use this to define edit field form
    // e.g. CRED edit form, Types group of fields edit screen
    abstract function editform( $config, &$form );

    // This is used in Types and Views to insert/add/read/modify shortcode
    // Called from post edit screen by Types, on Views Wizard, Views Layout...
    abstract public function mediaEditor();

}
