<?php

use App\Shop\Customers\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        DB::unprepared("
INSERT INTO `states` VALUES ('Alaska', 'AK', 226);
INSERT INTO `states` VALUES ('Alabama', 'AL', 226);
INSERT INTO `states` VALUES ('Arkansas', 'AR', 226);
INSERT INTO `states` VALUES ('Arizona', 'AZ', 226);
INSERT INTO `states` VALUES ('California', 'CA', 226);
INSERT INTO `states` VALUES ('Colorado', 'CO', 226);
INSERT INTO `states` VALUES ('Connecticut', 'CT', 226);
INSERT INTO `states` VALUES ('District of Columbia', 'DC', 226);
INSERT INTO `states` VALUES ('Delaware', 'DE', 226);
INSERT INTO `states` VALUES ('Florida', 'FL', 226);
INSERT INTO `states` VALUES ('Georgia', 'GA', 226);
INSERT INTO `states` VALUES ('Hawaii', 'HI', 226);
INSERT INTO `states` VALUES ('Iowa', 'IA', 226);
INSERT INTO `states` VALUES ('Idaho', 'ID', 226);
INSERT INTO `states` VALUES ('Illinois', 'IL', 226);
INSERT INTO `states` VALUES ('Indiana', 'IN', 226);
INSERT INTO `states` VALUES ('Kansas', 'KS', 226);
INSERT INTO `states` VALUES ('Kentucky', 'KY', 226);
INSERT INTO `states` VALUES ('Louisiana', 'LA', 226);
INSERT INTO `states` VALUES ('Massachusetts', 'MA', 226);
INSERT INTO `states` VALUES ('Maryland', 'MD', 226);
INSERT INTO `states` VALUES ('Maine', 'ME', 226);
INSERT INTO `states` VALUES ('Michigan', 'MI', 226);
INSERT INTO `states` VALUES ('Minnesota', 'MN', 226);
INSERT INTO `states` VALUES ('Missouri', 'MO', 226);
INSERT INTO `states` VALUES ('Mississippi', 'MS', 226);
INSERT INTO `states` VALUES ('Montana', 'MT', 226);
INSERT INTO `states` VALUES ('North Carolina', 'NC', 226);
INSERT INTO `states` VALUES ('North Dakota', 'ND', 226);
INSERT INTO `states` VALUES ('Nebraska', 'NE', 226);
INSERT INTO `states` VALUES ('New Hampshire', 'NH', 226);
INSERT INTO `states` VALUES ('New Jersey', 'NJ', 226);
INSERT INTO `states` VALUES ('New Mexico', 'NM', 226);
INSERT INTO `states` VALUES ('Nevada', 'NV', 226);
INSERT INTO `states` VALUES ('New York', 'NY', 226);
INSERT INTO `states` VALUES ('Ohio', 'OH', 226);
INSERT INTO `states` VALUES ('Oklahoma', 'OK', 226);
INSERT INTO `states` VALUES ('Oregon', 'OR', 226);
INSERT INTO `states` VALUES ('Pennsylvania', 'PA', 226);
INSERT INTO `states` VALUES ('Rhode Island', 'RI', 226);
INSERT INTO `states` VALUES ('South Carolina', 'SC', 226);
INSERT INTO `states` VALUES ('South Dakota', 'SD', 226);
INSERT INTO `states` VALUES ('Tennessee', 'TN', 226);
INSERT INTO `states` VALUES ('Texas', 'TX', 226);
INSERT INTO `states` VALUES ('Utah', 'UT', 226);
INSERT INTO `states` VALUES ('Virginia', 'VA', 226);
INSERT INTO `states` VALUES ('Vermont', 'VT', 226);
INSERT INTO `states` VALUES ('Washington', 'WA', 226);
INSERT INTO `states` VALUES ('Wisconsin', 'WI', 226);
INSERT INTO `states` VALUES ('West Virginia', 'WV', 226);
INSERT INTO `states` VALUES ('Wyoming', 'WY', 226);
        ");
    }
}