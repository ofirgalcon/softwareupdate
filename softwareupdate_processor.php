<?php

use CFPropertyList\CFPropertyList;
use munkireport\processors\Processor;

class Softwareupdate_processor extends Processor
{
    public function run($data)
    {
        // Check if data has been passed to model
        if (! $data) {
            throw new Exception("Error Processing Request: No data found", 1);
        }

        $modelData = [];

        // Process incoming softwareupdate.plist
        $parser = new CFPropertyList();
        $parser->parse($data, CFPropertyList::FORMAT_XML);
        $plist = array_change_key_case($parser->toArray(), CASE_LOWER);

        // Process each of the items
        foreach (array('automaticcheckenabled', 'automaticdownload', 'configdatainstall', 'criticalupdateinstall', 'lastattemptsystemversion', 'lastbackgroundccdsuccessfuldate', 'lastbackgroundsuccessfuldate', 'lastfullsuccessfuldate', 'lastrecommendedupdatesavailable', 'lastresultcode', 'lastsessionsuccessful', 'lastsuccessfuldate', 'lastupdatesavailable', 'skiplocalcdn', 'recommendedupdates', 'mrxprotect', 'catalogurl', 'inactiveupdates', 'skip_download_lack_space', 'eval_critical_if_unchanged', 'one_time_force_scan_enabled', 'auto_update', 'auto_update_restart_required', 'xprotect_version', 'gatekeeper_version', 'gatekeeper_last_modified', 'gatekeeper_disk_version', 'gatekeeper_disk_last_modified', 'kext_exclude_version', 'kext_exclude_last_modified', 'mrt_version', 'mrt_last_modified', 'enrolled_seed', 'program_seed', 'build_is_seed', 'show_feedback_menu', 'disable_seed_opt_out', 'catalog_url_seed','softwareupdate_history', 'xprotect_payloads_version','xprotect_payloads_last_modified', 'allow_prerelease_installation', 'managed_do_it_later_deferral_count', 'managed_product_keys', 'maximum_managed_do_it_later_deferral_count', 'ddm_info', 'deferred_updates', 'force_delayed_minor_updates', 'force_delayed_major_updates', 'minor_deferred_delay', 'major_deferred_delay', 'allow_rapid_security_response_installation', 'allow_rapid_security_response_removal') as $item) {
            // If key exists and is zero, set it to zero
            if ( array_key_exists($item, $plist) && $plist[$item] === 0 && $item != 'recommendedupdates' && $item != 'inactiveupdates') {
                $modelData[$item] = 0;

            // Else if key does not exist in $plist, null it
            } else if (! array_key_exists($item, $plist) || $plist[$item] == '') {
                $modelData[$item] = null;

            // Else if recommendedupdates, process for viewing
            } else if (array_key_exists($item, $plist) && $item == 'recommendedupdates' && $plist[$item] != 0) {
                $recommendedupdateslist = array_column($plist["recommendedupdates"], 'Display Name');
                sort($recommendedupdateslist);
                $recommendedupdateslistproper = implode(", ",$recommendedupdateslist);
                $modelData[$item] = $recommendedupdateslistproper;

            // Else if inactiveupdates, process for viewing
            } else if (array_key_exists($item, $plist) && $item == 'inactiveupdates' && $plist[$item] != 0) {
                $inactiveupdateslist = $plist["inactiveupdates"];
                sort($inactiveupdateslist);
                $inactiveupdateslistproper = implode(", ",$inactiveupdateslist);
                $modelData[$item] = $inactiveupdateslistproper;

            } else if (array_key_exists($item, $plist) && $item == 'managed_product_keys' && $plist[$item] != 0) {
                $managed_product_keys_list = $plist["managed_product_keys"];

                // Sort the array, preserving keys
                asort($managed_product_keys_list);
                $formatted_keys = [];

                foreach ($managed_product_keys_list as $key => $value) {
                    // Handle scalar values (including ["LAST_POSSIBLE"])
                    $formatted_value = $value;

                    // Combine the key and formatted value
                    $formatted_keys[] = "$formatted_value";
                }

                // Combine all formatted keys into a single string
                $modelData[$item] = implode(", ", $formatted_keys);

            // Else if softwareupdate_history, turn it into a JSON string
            } else if (array_key_exists($item, $plist) && $item == 'softwareupdate_history'){
                $modelData[$item] = json_encode($plist[$item]);

            // Set the db fields to be the same as those in the preference file
            } else {
                $modelData[$item] = $plist[$item];
            }
        }

        Softwareupdate_model::updateOrCreate(
            ['serial_number' => $this->serial_number], $modelData
        );

        return $this;
    }
}
