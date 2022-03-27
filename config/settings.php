<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Default Settings Store
	|--------------------------------------------------------------------------
	|
	| This option controls the default settings store that gets used while
	| using this settings library.
	|
	| Supported: "json", "database"
	|
	*/
	'store' => 'database',

	/*
	|--------------------------------------------------------------------------
	| JSON Store
	|--------------------------------------------------------------------------
	|
	| If the store is set to "json", settings are stored in the defined
	| file path in JSON format. Use full path to file.
	|
	*/
	'path' => storage_path().'/settings.json',

	/*
	|--------------------------------------------------------------------------
	| Database Store
	|--------------------------------------------------------------------------
	|
	| The settings are stored in the defined file path in JSON format.
	| Use full path to JSON file.
	|
	*/
	// If set to null, the default connection will be used.
	'connection' => null,
	// Name of the table used.
	'table' => 'settings',
	// If you want to use custom column names in database store you could
	// set them in this configuration
	'keyColumn' => 'key',
	'valueColumn' => 'value',

    /*
    |--------------------------------------------------------------------------
    | Cache settings
    |--------------------------------------------------------------------------
    |
    | If you want all setting calls to go through Laravel's cache system.
    |
    */
	'enableCache' => false,
	// Whether to reset the cache when changing a setting.
	'forgetCacheByWrite' => true,
	// TTL in seconds.
	'cacheTtl' => 15,
    
    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    |
    | Define all default settings that will be used before any settings are set,
    | this avoids all settings being set to false to begin with and avoids
    | hardcoding the same defaults in all 'Settings::get()' calls
    |
    */
    'defaults' => [
        "organization_name"=>"Zapbytes",
"footer_text"=>"CopyRights 2021 Zapbytes All rights Reserved",
"accept_rejected_customers"=> 0,
"blocked_new_customers_plan"=> 1,
 "add_user_to_blocked_plan_after"=> 100,
 "auto_daily_backup_time"=> "00:00",
 "get_backup_frequency"=> "Daily",
 "keep_daily_backups_for_days"=> 30,
 "currency"=> "INR",
 "tax_value"=> 0,
 "grace_times_monthly"=> 10,
 "grace_period"=> 10,
 "revert_period"=> 10,
 "invoice_should_paid_in"=> 10,
 "disable_account_due_unpaid_invoice"=> 0,
 "disable_account_due_exoired_contract"=> 0,
 "generate_invoice_at"=> "00:00",
 "add_revenue_balance"=> 0,
 "send_release_request"=>1,
 "min_revenue_release"=> 1000,
 "revenue_share_type_reseller"=> "fixed"
    ]
];
