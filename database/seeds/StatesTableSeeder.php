<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'stateCode' => 'AA',
            'stateName' => 'Armed Forces Americas (except Canada)',
                'countryIsoAlpha3' => 'USA',
            ),
            1 => 
            array (
                'stateCode' => 'AE',
                'stateName' => 'Armed Forces Africa',
                'countryIsoAlpha3' => 'USA',
            ),
            2 => 
            array (
                'stateCode' => 'AK',
                'stateName' => 'Alaska',
                'countryIsoAlpha3' => 'USA',
            ),
            3 => 
            array (
                'stateCode' => 'AL',
                'stateName' => 'Alabama',
                'countryIsoAlpha3' => 'USA',
            ),
            4 => 
            array (
                'stateCode' => 'AP',
                'stateName' => 'Armed Forces Pacific',
                'countryIsoAlpha3' => 'USA',
            ),
            5 => 
            array (
                'stateCode' => 'AR',
                'stateName' => 'Arkansas',
                'countryIsoAlpha3' => 'USA',
            ),
            6 => 
            array (
                'stateCode' => 'AS',
                'stateName' => 'American Samoa',
                'countryIsoAlpha3' => 'USA',
            ),
            7 => 
            array (
                'stateCode' => 'AZ',
                'stateName' => 'Arizona',
                'countryIsoAlpha3' => 'USA',
            ),
            8 => 
            array (
                'stateCode' => 'CA',
                'stateName' => 'California',
                'countryIsoAlpha3' => 'USA',
            ),
            9 => 
            array (
                'stateCode' => 'CO',
                'stateName' => 'Colorado',
                'countryIsoAlpha3' => 'USA',
            ),
            10 => 
            array (
                'stateCode' => 'CT',
                'stateName' => 'Connecticut',
                'countryIsoAlpha3' => 'USA',
            ),
            11 => 
            array (
                'stateCode' => 'DC',
                'stateName' => 'District of Columbia',
                'countryIsoAlpha3' => 'USA',
            ),
            12 => 
            array (
                'stateCode' => 'DE',
                'stateName' => 'Delaware',
                'countryIsoAlpha3' => 'USA',
            ),
            13 => 
            array (
                'stateCode' => 'FL',
                'stateName' => 'Florida',
                'countryIsoAlpha3' => 'USA',
            ),
            14 => 
            array (
                'stateCode' => 'FM',
                'stateName' => 'Federated States of Micronesia',
                'countryIsoAlpha3' => 'USA',
            ),
            15 => 
            array (
                'stateCode' => 'GA',
                'stateName' => 'Georgia',
                'countryIsoAlpha3' => 'USA',
            ),
            16 => 
            array (
                'stateCode' => 'GU',
                'stateName' => 'Guam',
                'countryIsoAlpha3' => 'USA',
            ),
            17 => 
            array (
                'stateCode' => 'HI',
                'stateName' => 'Hawaii',
                'countryIsoAlpha3' => 'USA',
            ),
            18 => 
            array (
                'stateCode' => 'IA',
                'stateName' => 'Iowa',
                'countryIsoAlpha3' => 'USA',
            ),
            19 => 
            array (
                'stateCode' => 'ID',
                'stateName' => 'Idaho',
                'countryIsoAlpha3' => 'USA',
            ),
            20 => 
            array (
                'stateCode' => 'IL',
                'stateName' => 'Illinois',
                'countryIsoAlpha3' => 'USA',
            ),
            21 => 
            array (
                'stateCode' => 'IN',
                'stateName' => 'Indiana',
                'countryIsoAlpha3' => 'USA',
            ),
            22 => 
            array (
                'stateCode' => 'KS',
                'stateName' => 'Kansas',
                'countryIsoAlpha3' => 'USA',
            ),
            23 => 
            array (
                'stateCode' => 'KY',
                'stateName' => 'Kentucky',
                'countryIsoAlpha3' => 'USA',
            ),
            24 => 
            array (
                'stateCode' => 'LA',
                'stateName' => 'Louisiana',
                'countryIsoAlpha3' => 'USA',
            ),
            25 => 
            array (
                'stateCode' => 'MA',
                'stateName' => 'Massachusetts',
                'countryIsoAlpha3' => 'USA',
            ),
            26 => 
            array (
                'stateCode' => 'MD',
                'stateName' => 'Maryland',
                'countryIsoAlpha3' => 'USA',
            ),
            27 => 
            array (
                'stateCode' => 'ME',
                'stateName' => 'Maine',
                'countryIsoAlpha3' => 'USA',
            ),
            28 => 
            array (
                'stateCode' => 'MH',
                'stateName' => 'Marshall Islands',
                'countryIsoAlpha3' => 'USA',
            ),
            29 => 
            array (
                'stateCode' => 'MI',
                'stateName' => 'Michigan',
                'countryIsoAlpha3' => 'USA',
            ),
            30 => 
            array (
                'stateCode' => 'MN',
                'stateName' => 'Minnesota',
                'countryIsoAlpha3' => 'USA',
            ),
            31 => 
            array (
                'stateCode' => 'MO',
                'stateName' => 'Missouri',
                'countryIsoAlpha3' => 'USA',
            ),
            32 => 
            array (
                'stateCode' => 'MP',
                'stateName' => 'Northern Mariana Islands',
                'countryIsoAlpha3' => 'USA',
            ),
            33 => 
            array (
                'stateCode' => 'MS',
                'stateName' => 'Mississippi',
                'countryIsoAlpha3' => 'USA',
            ),
            34 => 
            array (
                'stateCode' => 'MT',
                'stateName' => 'Montana',
                'countryIsoAlpha3' => 'USA',
            ),
            35 => 
            array (
                'stateCode' => 'NC',
                'stateName' => 'North Carolina',
                'countryIsoAlpha3' => 'USA',
            ),
            36 => 
            array (
                'stateCode' => 'ND',
                'stateName' => 'North Dakota',
                'countryIsoAlpha3' => 'USA',
            ),
            37 => 
            array (
                'stateCode' => 'NE',
                'stateName' => 'Nebraska',
                'countryIsoAlpha3' => 'USA',
            ),
            38 => 
            array (
                'stateCode' => 'NH',
                'stateName' => 'New Hampshire',
                'countryIsoAlpha3' => 'USA',
            ),
            39 => 
            array (
                'stateCode' => 'NJ',
                'stateName' => 'New Jersey',
                'countryIsoAlpha3' => 'USA',
            ),
            40 => 
            array (
                'stateCode' => 'NM',
                'stateName' => 'New Mexico',
                'countryIsoAlpha3' => 'USA',
            ),
            41 => 
            array (
                'stateCode' => 'NV',
                'stateName' => 'Nevada',
                'countryIsoAlpha3' => 'USA',
            ),
            42 => 
            array (
                'stateCode' => 'NY',
                'stateName' => 'New York',
                'countryIsoAlpha3' => 'USA',
            ),
            43 => 
            array (
                'stateCode' => 'OH',
                'stateName' => 'Ohio',
                'countryIsoAlpha3' => 'USA',
            ),
            44 => 
            array (
                'stateCode' => 'OK',
                'stateName' => 'Oklahoma',
                'countryIsoAlpha3' => 'USA',
            ),
            45 => 
            array (
                'stateCode' => 'OR',
                'stateName' => 'Oregon',
                'countryIsoAlpha3' => 'USA',
            ),
            46 => 
            array (
                'stateCode' => 'PA',
                'stateName' => 'Pennsylvania',
                'countryIsoAlpha3' => 'USA',
            ),
            47 => 
            array (
                'stateCode' => 'PR',
                'stateName' => 'Puerto Rico',
                'countryIsoAlpha3' => 'USA',
            ),
            48 => 
            array (
                'stateCode' => 'PW',
                'stateName' => 'Palau',
                'countryIsoAlpha3' => 'USA',
            ),
            49 => 
            array (
                'stateCode' => 'RI',
                'stateName' => 'Rhode Island',
                'countryIsoAlpha3' => 'USA',
            ),
            50 => 
            array (
                'stateCode' => 'SC',
                'stateName' => 'South Carolina',
                'countryIsoAlpha3' => 'USA',
            ),
            51 => 
            array (
                'stateCode' => 'SD',
                'stateName' => 'South Dakota',
                'countryIsoAlpha3' => 'USA',
            ),
            52 => 
            array (
                'stateCode' => 'TN',
                'stateName' => 'Tennessee',
                'countryIsoAlpha3' => 'USA',
            ),
            53 => 
            array (
                'stateCode' => 'TX',
                'stateName' => 'Texas',
                'countryIsoAlpha3' => 'USA',
            ),
            54 => 
            array (
                'stateCode' => 'UT',
                'stateName' => 'Utah',
                'countryIsoAlpha3' => 'USA',
            ),
            55 => 
            array (
                'stateCode' => 'VA',
                'stateName' => 'Virginia',
                'countryIsoAlpha3' => 'USA',
            ),
            56 => 
            array (
                'stateCode' => 'VI',
                'stateName' => 'Virgin Islands',
                'countryIsoAlpha3' => 'USA',
            ),
            57 => 
            array (
                'stateCode' => 'VT',
                'stateName' => 'Vermont',
                'countryIsoAlpha3' => 'USA',
            ),
            58 => 
            array (
                'stateCode' => 'WA',
                'stateName' => 'Washington',
                'countryIsoAlpha3' => 'USA',
            ),
            59 => 
            array (
                'stateCode' => 'WI',
                'stateName' => 'Wisconsin',
                'countryIsoAlpha3' => 'USA',
            ),
            60 => 
            array (
                'stateCode' => 'WV',
                'stateName' => 'West Virginia',
                'countryIsoAlpha3' => 'USA',
            ),
            61 => 
            array (
                'stateCode' => 'WY',
                'stateName' => 'Wyoming',
                'countryIsoAlpha3' => 'USA',
            ),
        ));
        
        
    }
}