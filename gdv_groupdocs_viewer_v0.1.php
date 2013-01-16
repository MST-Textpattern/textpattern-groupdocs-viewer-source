<?php

// This is a PLUGIN TEMPLATE.

// Copy this file to a new name like abc_myplugin.php.  Edit the code, then
// run this file at the command line to produce a plugin for distribution:
// $ php abc_myplugin.php > abc_myplugin-0.1.txt

// Plugin name is optional.  If unset, it will be extracted from the current
// file name. Plugin names should start with a three letter prefix which is
// unique and reserved for each plugin author ("abc" is just an example).
// Uncomment and edit this line to override:
$plugin['name'] = 'gdv_groupdocs_viewer';

// Allow raw HTML help, as opposed to Textile.
// 0 = Plugin help is in Textile format, no raw HTML allowed (default).
// 1 = Plugin help is in raw HTML.  Not recommended.
# $plugin['allow_html_help'] = 1;

$plugin['version'] = '0.1';
$plugin['author'] = ' GroupDocs Marketplace Team';
$plugin['author_uri'] = 'groupdocs.com';
$plugin['description'] = 'GroupDocs is a next generation Document Management solution that makes it easier for businesses to collaborate, share and work with documents online. So, organise, view, annotate, compare, assemble and share all your documents with Textpattern';

// Plugin load order:
// The default value of 5 would fit most plugins, while for instance comment
// spam evaluators or URL redirectors would probably want to run earlier
// (1...4) to prepare the environment for everything else that follows.
// Values 6...9 should be considered for plugins which would work late.
// This order is user-overrideable.
$plugin['order'] = '5';

// Plugin 'type' defines where the plugin is loaded
// 0 = public       : only on the public side of the website (default)
// 1 = public+admin : on both the public and admin side
// 2 = library      : only when include_plugin() or require_plugin() is called
// 3 = admin        : only on the admin side
$plugin['type'] = '3';

// Plugin "flags" signal the presence of optional capabilities to the core plugin loader.
// Use an appropriately OR-ed combination of these flags.
// The four high-order bits 0xf000 are available for this plugin's private use
if (!defined('PLUGIN_HAS_PREFS')) define('PLUGIN_HAS_PREFS', 0x0001); // This plugin wants to receive "plugin_prefs.{$plugin['name']}" events
if (!defined('PLUGIN_LIFECYCLE_NOTIFY')) define('PLUGIN_LIFECYCLE_NOTIFY', 0x0002); // This plugin wants to receive "plugin_lifecycle.{$plugin['name']}" events

$plugin['flags'] = '0';

if (!defined('txpinterface'))
        @include_once('zem_tpl.php');

# --- BEGIN PLUGIN CODE ---
/**
 * GroupDocs Viewer Plugin v0.1.0
 * Author: Orest Loginsky
 * Date: 26.10.2012
 * 
 * By default: Textpattern doesn't have WYSIWYG Editor (ex.: TinyMCE), means that you will be seeing 
 * only <iframe> tag while editing page. See results in "Article preview" or your site.
 */

// admin user only
if (@txpinterface == 'admin') {
    add_privs('article', '1'); // Publishers only
    register_callback('gdv_append_button', 'article_ui', 'title');
}

// add GroupDocs button
function gdv_append_button($event, $step, $data, $rs) {
    
    $js= gdv_javascript();
    $button = '<input type="button" value="Insert GroupDocs Viewer File ID" onclick="gdv_insert_fileid()">';
    $output_result = isset($rs['url_title']) ? '<br/>' . $js.$button : '';
    return $data.$output_result;
}

// add javascript
function gdv_javascript(){
    // jquery is working here
    $r= '<script>';
    $r.= 'function gdv_insert_fileid(){
        
            // Enter GroupDocs File ID
            var ans=prompt("Enter GroupDocs File ID:","");
            if(ans.length<50) { alert("Sorry, but this File ID is too short"); return false; }
            if(ans.length>70) { alert("Sorry, but this File ID is too big"); return false; }
            var cmsName = "Textpattern"
            var cmsVersion = "4.5.2"
            var gdv_iframe = \'<iframe src="https://apps.groupdocs.com/document-viewer/embed/\'+ans+\'?&referer=\'+cmsName+\'/\'+cmsVersion+\'" frameborder="0" width="600" height="400"></iframe>\';
            
            // insert in the end of <textarea id="body">
            var gdv_body = $("textarea#body").html()+gdv_iframe;
            $("textarea#body").html(gdv_body);
    }';
    $r.= '</script>';
    return $r;
}

# --- END PLUGIN CODE ---
if (0) {
?>
<!--
# --- BEGIN PLUGIN HELP ---

# --- END PLUGIN HELP ---
-->
<?php
}
?>