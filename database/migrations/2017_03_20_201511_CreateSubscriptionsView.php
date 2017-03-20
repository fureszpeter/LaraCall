<?php

use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'CREATE VIEW v_subscriptions AS 

SELECT 
p.`pin`, p.`blocked_date_blocked` AS `pin_blocked_date`, p.`blocked_reason` as `pin_blocked_reason`, p.`blocked_status` AS `pin_blocked_status`, p.`created_at` AS `pin_created_at`, p.`updated_at` as `pin_updated_at`,
s.*,
u.`email`, u.`blocked_date_blocked` AS `user_blocked_date`, u.`blocked_reason` AS `user_blocked_reason`, u.`blocked_status` AS `user_blocked_status`, u.`registration_date` AS `usesr_registration_date`,
c.`countryName`, 
st.`stateName`

FROM pins p LEFT JOIN subscriptions s ON (p.`subscription_id`=s.`id`)
LEFT JOIN `users` u ON (s.`user_id`=u.`id`)
LEFT JOIN `countries` c ON (s.`isoAlpha3`=c.`isoAlpha3`)
LEFT JOIN `states` st ON (s.`stateCode`=st.`stateCode`)
ORDER BY u.`id`' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW v_subscriptions' );
    }
}
