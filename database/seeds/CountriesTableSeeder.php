<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'isoAlpha3' => 'ABW',
                'countryCode' => 'AW',
                'countryName' => 'Aruba',
                'currencyCode' => 'AWG',
            ),
            1 => 
            array (
                'isoAlpha3' => 'AFG',
                'countryCode' => 'AF',
                'countryName' => 'Afghanistan',
                'currencyCode' => 'AFN',
            ),
            2 => 
            array (
                'isoAlpha3' => 'AGO',
                'countryCode' => 'AO',
                'countryName' => 'Angola',
                'currencyCode' => 'AOA',
            ),
            3 => 
            array (
                'isoAlpha3' => 'AIA',
                'countryCode' => 'AI',
                'countryName' => 'Anguilla',
                'currencyCode' => 'XCD',
            ),
            4 => 
            array (
                'isoAlpha3' => 'ALA',
                'countryCode' => 'AX',
                'countryName' => 'ÌÉland',
                'currencyCode' => 'EUR',
            ),
            5 => 
            array (
                'isoAlpha3' => 'ALB',
                'countryCode' => 'AL',
                'countryName' => 'Albania',
                'currencyCode' => 'ALL',
            ),
            6 => 
            array (
                'isoAlpha3' => 'AND',
                'countryCode' => 'AD',
                'countryName' => 'Andorra',
                'currencyCode' => 'EUR',
            ),
            7 => 
            array (
                'isoAlpha3' => 'ARE',
                'countryCode' => 'AE',
                'countryName' => 'United Arab Emirates',
                'currencyCode' => 'AED',
            ),
            8 => 
            array (
                'isoAlpha3' => 'ARG',
                'countryCode' => 'AR',
                'countryName' => 'Argentina',
                'currencyCode' => 'ARS',
            ),
            9 => 
            array (
                'isoAlpha3' => 'ARM',
                'countryCode' => 'AM',
                'countryName' => 'Armenia',
                'currencyCode' => 'AMD',
            ),
            10 => 
            array (
                'isoAlpha3' => 'ASM',
                'countryCode' => 'AS',
                'countryName' => 'American Samoa',
                'currencyCode' => 'USD',
            ),
            11 => 
            array (
                'isoAlpha3' => 'ATA',
                'countryCode' => 'AQ',
                'countryName' => 'Antarctica',
                'currencyCode' => '',
            ),
            12 => 
            array (
                'isoAlpha3' => 'ATF',
                'countryCode' => 'TF',
                'countryName' => 'French Southern Territories',
                'currencyCode' => 'EUR',
            ),
            13 => 
            array (
                'isoAlpha3' => 'ATG',
                'countryCode' => 'AG',
                'countryName' => 'Antigua and Barbuda',
                'currencyCode' => 'XCD',
            ),
            14 => 
            array (
                'isoAlpha3' => 'AUS',
                'countryCode' => 'AU',
                'countryName' => 'Australia',
                'currencyCode' => 'AUD',
            ),
            15 => 
            array (
                'isoAlpha3' => 'AUT',
                'countryCode' => 'AT',
                'countryName' => 'Austria',
                'currencyCode' => 'EUR',
            ),
            16 => 
            array (
                'isoAlpha3' => 'AZE',
                'countryCode' => 'AZ',
                'countryName' => 'Azerbaijan',
                'currencyCode' => 'AZN',
            ),
            17 => 
            array (
                'isoAlpha3' => 'BDI',
                'countryCode' => 'BI',
                'countryName' => 'Burundi',
                'currencyCode' => 'BIF',
            ),
            18 => 
            array (
                'isoAlpha3' => 'BEL',
                'countryCode' => 'BE',
                'countryName' => 'Belgium',
                'currencyCode' => 'EUR',
            ),
            19 => 
            array (
                'isoAlpha3' => 'BEN',
                'countryCode' => 'BJ',
                'countryName' => 'Benin',
                'currencyCode' => 'XOF',
            ),
            20 => 
            array (
                'isoAlpha3' => 'BES',
                'countryCode' => 'BQ',
                'countryName' => 'Bonaire',
                'currencyCode' => 'USD',
            ),
            21 => 
            array (
                'isoAlpha3' => 'BFA',
                'countryCode' => 'BF',
                'countryName' => 'Burkina Faso',
                'currencyCode' => 'XOF',
            ),
            22 => 
            array (
                'isoAlpha3' => 'BGD',
                'countryCode' => 'BD',
                'countryName' => 'Bangladesh',
                'currencyCode' => 'BDT',
            ),
            23 => 
            array (
                'isoAlpha3' => 'BGR',
                'countryCode' => 'BG',
                'countryName' => 'Bulgaria',
                'currencyCode' => 'BGN',
            ),
            24 => 
            array (
                'isoAlpha3' => 'BHR',
                'countryCode' => 'BH',
                'countryName' => 'Bahrain',
                'currencyCode' => 'BHD',
            ),
            25 => 
            array (
                'isoAlpha3' => 'BHS',
                'countryCode' => 'BS',
                'countryName' => 'Bahamas',
                'currencyCode' => 'BSD',
            ),
            26 => 
            array (
                'isoAlpha3' => 'BIH',
                'countryCode' => 'BA',
                'countryName' => 'Bosnia and Herzegovina',
                'currencyCode' => 'BAM',
            ),
            27 => 
            array (
                'isoAlpha3' => 'BLM',
                'countryCode' => 'BL',
                'countryName' => 'Saint BarthÌ©lemy',
                'currencyCode' => 'EUR',
            ),
            28 => 
            array (
                'isoAlpha3' => 'BLR',
                'countryCode' => 'BY',
                'countryName' => 'Belarus',
                'currencyCode' => 'BYR',
            ),
            29 => 
            array (
                'isoAlpha3' => 'BLZ',
                'countryCode' => 'BZ',
                'countryName' => 'Belize',
                'currencyCode' => 'BZD',
            ),
            30 => 
            array (
                'isoAlpha3' => 'BMU',
                'countryCode' => 'BM',
                'countryName' => 'Bermuda',
                'currencyCode' => 'BMD',
            ),
            31 => 
            array (
                'isoAlpha3' => 'BOL',
                'countryCode' => 'BO',
                'countryName' => 'Bolivia',
                'currencyCode' => 'BOB',
            ),
            32 => 
            array (
                'isoAlpha3' => 'BRA',
                'countryCode' => 'BR',
                'countryName' => 'Brazil',
                'currencyCode' => 'BRL',
            ),
            33 => 
            array (
                'isoAlpha3' => 'BRB',
                'countryCode' => 'BB',
                'countryName' => 'Barbados',
                'currencyCode' => 'BBD',
            ),
            34 => 
            array (
                'isoAlpha3' => 'BRN',
                'countryCode' => 'BN',
                'countryName' => 'Brunei',
                'currencyCode' => 'BND',
            ),
            35 => 
            array (
                'isoAlpha3' => 'BTN',
                'countryCode' => 'BT',
                'countryName' => 'Bhutan',
                'currencyCode' => 'BTN',
            ),
            36 => 
            array (
                'isoAlpha3' => 'BVT',
                'countryCode' => 'BV',
                'countryName' => 'Bouvet Island',
                'currencyCode' => 'NOK',
            ),
            37 => 
            array (
                'isoAlpha3' => 'BWA',
                'countryCode' => 'BW',
                'countryName' => 'Botswana',
                'currencyCode' => 'BWP',
            ),
            38 => 
            array (
                'isoAlpha3' => 'CAF',
                'countryCode' => 'CF',
                'countryName' => 'Central African Republic',
                'currencyCode' => 'XAF',
            ),
            39 => 
            array (
                'isoAlpha3' => 'CAN',
                'countryCode' => 'CA',
                'countryName' => 'Canada',
                'currencyCode' => 'CAD',
            ),
            40 => 
            array (
                'isoAlpha3' => 'CCK',
                'countryCode' => 'CC',
                'countryName' => 'Cocos [Keeling] Islands',
                'currencyCode' => 'AUD',
            ),
            41 => 
            array (
                'isoAlpha3' => 'CHE',
                'countryCode' => 'CH',
                'countryName' => 'Switzerland',
                'currencyCode' => 'CHF',
            ),
            42 => 
            array (
                'isoAlpha3' => 'CHL',
                'countryCode' => 'CL',
                'countryName' => 'Chile',
                'currencyCode' => 'CLP',
            ),
            43 => 
            array (
                'isoAlpha3' => 'CHN',
                'countryCode' => 'CN',
                'countryName' => 'China',
                'currencyCode' => 'CNY',
            ),
            44 => 
            array (
                'isoAlpha3' => 'CIV',
                'countryCode' => 'CI',
                'countryName' => 'Ivory Coast',
                'currencyCode' => 'XOF',
            ),
            45 => 
            array (
                'isoAlpha3' => 'CMR',
                'countryCode' => 'CM',
                'countryName' => 'Cameroon',
                'currencyCode' => 'XAF',
            ),
            46 => 
            array (
                'isoAlpha3' => 'COD',
                'countryCode' => 'CD',
                'countryName' => 'Democratic Republic of the Congo',
                'currencyCode' => 'CDF',
            ),
            47 => 
            array (
                'isoAlpha3' => 'COG',
                'countryCode' => 'CG',
                'countryName' => 'Republic of the Congo',
                'currencyCode' => 'XAF',
            ),
            48 => 
            array (
                'isoAlpha3' => 'COK',
                'countryCode' => 'CK',
                'countryName' => 'Cook Islands',
                'currencyCode' => 'NZD',
            ),
            49 => 
            array (
                'isoAlpha3' => 'COL',
                'countryCode' => 'CO',
                'countryName' => 'Colombia',
                'currencyCode' => 'COP',
            ),
            50 => 
            array (
                'isoAlpha3' => 'COM',
                'countryCode' => 'KM',
                'countryName' => 'Comoros',
                'currencyCode' => 'KMF',
            ),
            51 => 
            array (
                'isoAlpha3' => 'CPV',
                'countryCode' => 'CV',
                'countryName' => 'Cape Verde',
                'currencyCode' => 'CVE',
            ),
            52 => 
            array (
                'isoAlpha3' => 'CRI',
                'countryCode' => 'CR',
                'countryName' => 'Costa Rica',
                'currencyCode' => 'CRC',
            ),
            53 => 
            array (
                'isoAlpha3' => 'CUB',
                'countryCode' => 'CU',
                'countryName' => 'Cuba',
                'currencyCode' => 'CUP',
            ),
            54 => 
            array (
                'isoAlpha3' => 'CUW',
                'countryCode' => 'CW',
                'countryName' => 'Curacao',
                'currencyCode' => 'ANG',
            ),
            55 => 
            array (
                'isoAlpha3' => 'CXR',
                'countryCode' => 'CX',
                'countryName' => 'Christmas Island',
                'currencyCode' => 'AUD',
            ),
            56 => 
            array (
                'isoAlpha3' => 'CYM',
                'countryCode' => 'KY',
                'countryName' => 'Cayman Islands',
                'currencyCode' => 'KYD',
            ),
            57 => 
            array (
                'isoAlpha3' => 'CYP',
                'countryCode' => 'CY',
                'countryName' => 'Cyprus',
                'currencyCode' => 'EUR',
            ),
            58 => 
            array (
                'isoAlpha3' => 'CZE',
                'countryCode' => 'CZ',
                'countryName' => 'Czech Republic',
                'currencyCode' => 'CZK',
            ),
            59 => 
            array (
                'isoAlpha3' => 'DEU',
                'countryCode' => 'DE',
                'countryName' => 'Germany',
                'currencyCode' => 'EUR',
            ),
            60 => 
            array (
                'isoAlpha3' => 'DJI',
                'countryCode' => 'DJ',
                'countryName' => 'Djibouti',
                'currencyCode' => 'DJF',
            ),
            61 => 
            array (
                'isoAlpha3' => 'DMA',
                'countryCode' => 'DM',
                'countryName' => 'Dominica',
                'currencyCode' => 'XCD',
            ),
            62 => 
            array (
                'isoAlpha3' => 'DNK',
                'countryCode' => 'DK',
                'countryName' => 'Denmark',
                'currencyCode' => 'DKK',
            ),
            63 => 
            array (
                'isoAlpha3' => 'DOM',
                'countryCode' => 'DO',
                'countryName' => 'Dominican Republic',
                'currencyCode' => 'DOP',
            ),
            64 => 
            array (
                'isoAlpha3' => 'DZA',
                'countryCode' => 'DZ',
                'countryName' => 'Algeria',
                'currencyCode' => 'DZD',
            ),
            65 => 
            array (
                'isoAlpha3' => 'ECU',
                'countryCode' => 'EC',
                'countryName' => 'Ecuador',
                'currencyCode' => 'USD',
            ),
            66 => 
            array (
                'isoAlpha3' => 'EGY',
                'countryCode' => 'EG',
                'countryName' => 'Egypt',
                'currencyCode' => 'EGP',
            ),
            67 => 
            array (
                'isoAlpha3' => 'ERI',
                'countryCode' => 'ER',
                'countryName' => 'Eritrea',
                'currencyCode' => 'ERN',
            ),
            68 => 
            array (
                'isoAlpha3' => 'ESH',
                'countryCode' => 'EH',
                'countryName' => 'Western Sahara',
                'currencyCode' => 'MAD',
            ),
            69 => 
            array (
                'isoAlpha3' => 'ESP',
                'countryCode' => 'ES',
                'countryName' => 'Spain',
                'currencyCode' => 'EUR',
            ),
            70 => 
            array (
                'isoAlpha3' => 'EST',
                'countryCode' => 'EE',
                'countryName' => 'Estonia',
                'currencyCode' => 'EUR',
            ),
            71 => 
            array (
                'isoAlpha3' => 'ETH',
                'countryCode' => 'ET',
                'countryName' => 'Ethiopia',
                'currencyCode' => 'ETB',
            ),
            72 => 
            array (
                'isoAlpha3' => 'FIN',
                'countryCode' => 'FI',
                'countryName' => 'Finland',
                'currencyCode' => 'EUR',
            ),
            73 => 
            array (
                'isoAlpha3' => 'FJI',
                'countryCode' => 'FJ',
                'countryName' => 'Fiji',
                'currencyCode' => 'FJD',
            ),
            74 => 
            array (
                'isoAlpha3' => 'FLK',
                'countryCode' => 'FK',
                'countryName' => 'Falkland Islands',
                'currencyCode' => 'FKP',
            ),
            75 => 
            array (
                'isoAlpha3' => 'FRA',
                'countryCode' => 'FR',
                'countryName' => 'France',
                'currencyCode' => 'EUR',
            ),
            76 => 
            array (
                'isoAlpha3' => 'FRO',
                'countryCode' => 'FO',
                'countryName' => 'Faroe Islands',
                'currencyCode' => 'DKK',
            ),
            77 => 
            array (
                'isoAlpha3' => 'FSM',
                'countryCode' => 'FM',
                'countryName' => 'Micronesia',
                'currencyCode' => 'USD',
            ),
            78 => 
            array (
                'isoAlpha3' => 'GAB',
                'countryCode' => 'GA',
                'countryName' => 'Gabon',
                'currencyCode' => 'XAF',
            ),
            79 => 
            array (
                'isoAlpha3' => 'GBR',
                'countryCode' => 'GB',
                'countryName' => 'United Kingdom',
                'currencyCode' => 'GBP',
            ),
            80 => 
            array (
                'isoAlpha3' => 'GEO',
                'countryCode' => 'GE',
                'countryName' => 'Georgia',
                'currencyCode' => 'GEL',
            ),
            81 => 
            array (
                'isoAlpha3' => 'GGY',
                'countryCode' => 'GG',
                'countryName' => 'Guernsey',
                'currencyCode' => 'GBP',
            ),
            82 => 
            array (
                'isoAlpha3' => 'GHA',
                'countryCode' => 'GH',
                'countryName' => 'Ghana',
                'currencyCode' => 'GHS',
            ),
            83 => 
            array (
                'isoAlpha3' => 'GIB',
                'countryCode' => 'GI',
                'countryName' => 'Gibraltar',
                'currencyCode' => 'GIP',
            ),
            84 => 
            array (
                'isoAlpha3' => 'GIN',
                'countryCode' => 'GN',
                'countryName' => 'Guinea',
                'currencyCode' => 'GNF',
            ),
            85 => 
            array (
                'isoAlpha3' => 'GLP',
                'countryCode' => 'GP',
                'countryName' => 'Guadeloupe',
                'currencyCode' => 'EUR',
            ),
            86 => 
            array (
                'isoAlpha3' => 'GMB',
                'countryCode' => 'GM',
                'countryName' => 'Gambia',
                'currencyCode' => 'GMD',
            ),
            87 => 
            array (
                'isoAlpha3' => 'GNB',
                'countryCode' => 'GW',
                'countryName' => 'Guinea-Bissau',
                'currencyCode' => 'XOF',
            ),
            88 => 
            array (
                'isoAlpha3' => 'GNQ',
                'countryCode' => 'GQ',
                'countryName' => 'Equatorial Guinea',
                'currencyCode' => 'XAF',
            ),
            89 => 
            array (
                'isoAlpha3' => 'GRC',
                'countryCode' => 'GR',
                'countryName' => 'Greece',
                'currencyCode' => 'EUR',
            ),
            90 => 
            array (
                'isoAlpha3' => 'GRD',
                'countryCode' => 'GD',
                'countryName' => 'Grenada',
                'currencyCode' => 'XCD',
            ),
            91 => 
            array (
                'isoAlpha3' => 'GRL',
                'countryCode' => 'GL',
                'countryName' => 'Greenland',
                'currencyCode' => 'DKK',
            ),
            92 => 
            array (
                'isoAlpha3' => 'GTM',
                'countryCode' => 'GT',
                'countryName' => 'Guatemala',
                'currencyCode' => 'GTQ',
            ),
            93 => 
            array (
                'isoAlpha3' => 'GUF',
                'countryCode' => 'GF',
                'countryName' => 'French Guiana',
                'currencyCode' => 'EUR',
            ),
            94 => 
            array (
                'isoAlpha3' => 'GUM',
                'countryCode' => 'GU',
                'countryName' => 'Guam',
                'currencyCode' => 'USD',
            ),
            95 => 
            array (
                'isoAlpha3' => 'GUY',
                'countryCode' => 'GY',
                'countryName' => 'Guyana',
                'currencyCode' => 'GYD',
            ),
            96 => 
            array (
                'isoAlpha3' => 'HKG',
                'countryCode' => 'HK',
                'countryName' => 'Hong Kong',
                'currencyCode' => 'HKD',
            ),
            97 => 
            array (
                'isoAlpha3' => 'HMD',
                'countryCode' => 'HM',
                'countryName' => 'Heard Island and McDonald Islands',
                'currencyCode' => 'AUD',
            ),
            98 => 
            array (
                'isoAlpha3' => 'HND',
                'countryCode' => 'HN',
                'countryName' => 'Honduras',
                'currencyCode' => 'HNL',
            ),
            99 => 
            array (
                'isoAlpha3' => 'HRV',
                'countryCode' => 'HR',
                'countryName' => 'Croatia',
                'currencyCode' => 'HRK',
            ),
            100 => 
            array (
                'isoAlpha3' => 'HTI',
                'countryCode' => 'HT',
                'countryName' => 'Haiti',
                'currencyCode' => 'HTG',
            ),
            101 => 
            array (
                'isoAlpha3' => 'HUN',
                'countryCode' => 'HU',
                'countryName' => 'Hungary',
                'currencyCode' => 'HUF',
            ),
            102 => 
            array (
                'isoAlpha3' => 'IDN',
                'countryCode' => 'ID',
                'countryName' => 'Indonesia',
                'currencyCode' => 'IDR',
            ),
            103 => 
            array (
                'isoAlpha3' => 'IMN',
                'countryCode' => 'IM',
                'countryName' => 'Isle of Man',
                'currencyCode' => 'GBP',
            ),
            104 => 
            array (
                'isoAlpha3' => 'IND',
                'countryCode' => 'IN',
                'countryName' => 'India',
                'currencyCode' => 'INR',
            ),
            105 => 
            array (
                'isoAlpha3' => 'IOT',
                'countryCode' => 'IO',
                'countryName' => 'British Indian Ocean Territory',
                'currencyCode' => 'USD',
            ),
            106 => 
            array (
                'isoAlpha3' => 'IRL',
                'countryCode' => 'IE',
                'countryName' => 'Ireland',
                'currencyCode' => 'EUR',
            ),
            107 => 
            array (
                'isoAlpha3' => 'IRN',
                'countryCode' => 'IR',
                'countryName' => 'Iran',
                'currencyCode' => 'IRR',
            ),
            108 => 
            array (
                'isoAlpha3' => 'IRQ',
                'countryCode' => 'IQ',
                'countryName' => 'Iraq',
                'currencyCode' => 'IQD',
            ),
            109 => 
            array (
                'isoAlpha3' => 'ISL',
                'countryCode' => 'IS',
                'countryName' => 'Iceland',
                'currencyCode' => 'ISK',
            ),
            110 => 
            array (
                'isoAlpha3' => 'ISR',
                'countryCode' => 'IL',
                'countryName' => 'Israel',
                'currencyCode' => 'ILS',
            ),
            111 => 
            array (
                'isoAlpha3' => 'ITA',
                'countryCode' => 'IT',
                'countryName' => 'Italy',
                'currencyCode' => 'EUR',
            ),
            112 => 
            array (
                'isoAlpha3' => 'JAM',
                'countryCode' => 'JM',
                'countryName' => 'Jamaica',
                'currencyCode' => 'JMD',
            ),
            113 => 
            array (
                'isoAlpha3' => 'JEY',
                'countryCode' => 'JE',
                'countryName' => 'Jersey',
                'currencyCode' => 'GBP',
            ),
            114 => 
            array (
                'isoAlpha3' => 'JOR',
                'countryCode' => 'JO',
                'countryName' => 'Jordan',
                'currencyCode' => 'JOD',
            ),
            115 => 
            array (
                'isoAlpha3' => 'JPN',
                'countryCode' => 'JP',
                'countryName' => 'Japan',
                'currencyCode' => 'JPY',
            ),
            116 => 
            array (
                'isoAlpha3' => 'KAZ',
                'countryCode' => 'KZ',
                'countryName' => 'Kazakhstan',
                'currencyCode' => 'KZT',
            ),
            117 => 
            array (
                'isoAlpha3' => 'KEN',
                'countryCode' => 'KE',
                'countryName' => 'Kenya',
                'currencyCode' => 'KES',
            ),
            118 => 
            array (
                'isoAlpha3' => 'KGZ',
                'countryCode' => 'KG',
                'countryName' => 'Kyrgyzstan',
                'currencyCode' => 'KGS',
            ),
            119 => 
            array (
                'isoAlpha3' => 'KHM',
                'countryCode' => 'KH',
                'countryName' => 'Cambodia',
                'currencyCode' => 'KHR',
            ),
            120 => 
            array (
                'isoAlpha3' => 'KIR',
                'countryCode' => 'KI',
                'countryName' => 'Kiribati',
                'currencyCode' => 'AUD',
            ),
            121 => 
            array (
                'isoAlpha3' => 'KNA',
                'countryCode' => 'KN',
                'countryName' => 'Saint Kitts and Nevis',
                'currencyCode' => 'XCD',
            ),
            122 => 
            array (
                'isoAlpha3' => 'KOR',
                'countryCode' => 'KR',
                'countryName' => 'South Korea',
                'currencyCode' => 'KRW',
            ),
            123 => 
            array (
                'isoAlpha3' => 'KWT',
                'countryCode' => 'KW',
                'countryName' => 'Kuwait',
                'currencyCode' => 'KWD',
            ),
            124 => 
            array (
                'isoAlpha3' => 'LAO',
                'countryCode' => 'LA',
                'countryName' => 'Laos',
                'currencyCode' => 'LAK',
            ),
            125 => 
            array (
                'isoAlpha3' => 'LBN',
                'countryCode' => 'LB',
                'countryName' => 'Lebanon',
                'currencyCode' => 'LBP',
            ),
            126 => 
            array (
                'isoAlpha3' => 'LBR',
                'countryCode' => 'LR',
                'countryName' => 'Liberia',
                'currencyCode' => 'LRD',
            ),
            127 => 
            array (
                'isoAlpha3' => 'LBY',
                'countryCode' => 'LY',
                'countryName' => 'Libya',
                'currencyCode' => 'LYD',
            ),
            128 => 
            array (
                'isoAlpha3' => 'LCA',
                'countryCode' => 'LC',
                'countryName' => 'Saint Lucia',
                'currencyCode' => 'XCD',
            ),
            129 => 
            array (
                'isoAlpha3' => 'LIE',
                'countryCode' => 'LI',
                'countryName' => 'Liechtenstein',
                'currencyCode' => 'CHF',
            ),
            130 => 
            array (
                'isoAlpha3' => 'LKA',
                'countryCode' => 'LK',
                'countryName' => 'Sri Lanka',
                'currencyCode' => 'LKR',
            ),
            131 => 
            array (
                'isoAlpha3' => 'LSO',
                'countryCode' => 'LS',
                'countryName' => 'Lesotho',
                'currencyCode' => 'LSL',
            ),
            132 => 
            array (
                'isoAlpha3' => 'LTU',
                'countryCode' => 'LT',
                'countryName' => 'Lithuania',
                'currencyCode' => 'EUR',
            ),
            133 => 
            array (
                'isoAlpha3' => 'LUX',
                'countryCode' => 'LU',
                'countryName' => 'Luxembourg',
                'currencyCode' => 'EUR',
            ),
            134 => 
            array (
                'isoAlpha3' => 'LVA',
                'countryCode' => 'LV',
                'countryName' => 'Latvia',
                'currencyCode' => 'EUR',
            ),
            135 => 
            array (
                'isoAlpha3' => 'MAC',
                'countryCode' => 'MO',
                'countryName' => 'Macao',
                'currencyCode' => 'MOP',
            ),
            136 => 
            array (
                'isoAlpha3' => 'MAF',
                'countryCode' => 'MF',
                'countryName' => 'Saint Martin',
                'currencyCode' => 'EUR',
            ),
            137 => 
            array (
                'isoAlpha3' => 'MAR',
                'countryCode' => 'MA',
                'countryName' => 'Morocco',
                'currencyCode' => 'MAD',
            ),
            138 => 
            array (
                'isoAlpha3' => 'MCO',
                'countryCode' => 'MC',
                'countryName' => 'Monaco',
                'currencyCode' => 'EUR',
            ),
            139 => 
            array (
                'isoAlpha3' => 'MDA',
                'countryCode' => 'MD',
                'countryName' => 'Moldova',
                'currencyCode' => 'MDL',
            ),
            140 => 
            array (
                'isoAlpha3' => 'MDG',
                'countryCode' => 'MG',
                'countryName' => 'Madagascar',
                'currencyCode' => 'MGA',
            ),
            141 => 
            array (
                'isoAlpha3' => 'MDV',
                'countryCode' => 'MV',
                'countryName' => 'Maldives',
                'currencyCode' => 'MVR',
            ),
            142 => 
            array (
                'isoAlpha3' => 'MEX',
                'countryCode' => 'MX',
                'countryName' => 'Mexico',
                'currencyCode' => 'MXN',
            ),
            143 => 
            array (
                'isoAlpha3' => 'MHL',
                'countryCode' => 'MH',
                'countryName' => 'Marshall Islands',
                'currencyCode' => 'USD',
            ),
            144 => 
            array (
                'isoAlpha3' => 'MKD',
                'countryCode' => 'MK',
                'countryName' => 'Macedonia',
                'currencyCode' => 'MKD',
            ),
            145 => 
            array (
                'isoAlpha3' => 'MLI',
                'countryCode' => 'ML',
                'countryName' => 'Mali',
                'currencyCode' => 'XOF',
            ),
            146 => 
            array (
                'isoAlpha3' => 'MLT',
                'countryCode' => 'MT',
                'countryName' => 'Malta',
                'currencyCode' => 'EUR',
            ),
            147 => 
            array (
                'isoAlpha3' => 'MMR',
                'countryCode' => 'MM',
                'countryName' => 'Myanmar [Burma]',
                'currencyCode' => 'MMK',
            ),
            148 => 
            array (
                'isoAlpha3' => 'MNE',
                'countryCode' => 'ME',
                'countryName' => 'Montenegro',
                'currencyCode' => 'EUR',
            ),
            149 => 
            array (
                'isoAlpha3' => 'MNG',
                'countryCode' => 'MN',
                'countryName' => 'Mongolia',
                'currencyCode' => 'MNT',
            ),
            150 => 
            array (
                'isoAlpha3' => 'MNP',
                'countryCode' => 'MP',
                'countryName' => 'Northern Mariana Islands',
                'currencyCode' => 'USD',
            ),
            151 => 
            array (
                'isoAlpha3' => 'MOZ',
                'countryCode' => 'MZ',
                'countryName' => 'Mozambique',
                'currencyCode' => 'MZN',
            ),
            152 => 
            array (
                'isoAlpha3' => 'MRT',
                'countryCode' => 'MR',
                'countryName' => 'Mauritania',
                'currencyCode' => 'MRO',
            ),
            153 => 
            array (
                'isoAlpha3' => 'MSR',
                'countryCode' => 'MS',
                'countryName' => 'Montserrat',
                'currencyCode' => 'XCD',
            ),
            154 => 
            array (
                'isoAlpha3' => 'MTQ',
                'countryCode' => 'MQ',
                'countryName' => 'Martinique',
                'currencyCode' => 'EUR',
            ),
            155 => 
            array (
                'isoAlpha3' => 'MUS',
                'countryCode' => 'MU',
                'countryName' => 'Mauritius',
                'currencyCode' => 'MUR',
            ),
            156 => 
            array (
                'isoAlpha3' => 'MWI',
                'countryCode' => 'MW',
                'countryName' => 'Malawi',
                'currencyCode' => 'MWK',
            ),
            157 => 
            array (
                'isoAlpha3' => 'MYS',
                'countryCode' => 'MY',
                'countryName' => 'Malaysia',
                'currencyCode' => 'MYR',
            ),
            158 => 
            array (
                'isoAlpha3' => 'MYT',
                'countryCode' => 'YT',
                'countryName' => 'Mayotte',
                'currencyCode' => 'EUR',
            ),
            159 => 
            array (
                'isoAlpha3' => 'NAM',
                'countryCode' => 'NA',
                'countryName' => 'Namibia',
                'currencyCode' => 'NAD',
            ),
            160 => 
            array (
                'isoAlpha3' => 'NCL',
                'countryCode' => 'NC',
                'countryName' => 'New Caledonia',
                'currencyCode' => 'XPF',
            ),
            161 => 
            array (
                'isoAlpha3' => 'NER',
                'countryCode' => 'NE',
                'countryName' => 'Niger',
                'currencyCode' => 'XOF',
            ),
            162 => 
            array (
                'isoAlpha3' => 'NFK',
                'countryCode' => 'NF',
                'countryName' => 'Norfolk Island',
                'currencyCode' => 'AUD',
            ),
            163 => 
            array (
                'isoAlpha3' => 'NGA',
                'countryCode' => 'NG',
                'countryName' => 'Nigeria',
                'currencyCode' => 'NGN',
            ),
            164 => 
            array (
                'isoAlpha3' => 'NIC',
                'countryCode' => 'NI',
                'countryName' => 'Nicaragua',
                'currencyCode' => 'NIO',
            ),
            165 => 
            array (
                'isoAlpha3' => 'NIU',
                'countryCode' => 'NU',
                'countryName' => 'Niue',
                'currencyCode' => 'NZD',
            ),
            166 => 
            array (
                'isoAlpha3' => 'NLD',
                'countryCode' => 'NL',
                'countryName' => 'Netherlands',
                'currencyCode' => 'EUR',
            ),
            167 => 
            array (
                'isoAlpha3' => 'NOR',
                'countryCode' => 'NO',
                'countryName' => 'Norway',
                'currencyCode' => 'NOK',
            ),
            168 => 
            array (
                'isoAlpha3' => 'NPL',
                'countryCode' => 'NP',
                'countryName' => 'Nepal',
                'currencyCode' => 'NPR',
            ),
            169 => 
            array (
                'isoAlpha3' => 'NRU',
                'countryCode' => 'NR',
                'countryName' => 'Nauru',
                'currencyCode' => 'AUD',
            ),
            170 => 
            array (
                'isoAlpha3' => 'NZL',
                'countryCode' => 'NZ',
                'countryName' => 'New Zealand',
                'currencyCode' => 'NZD',
            ),
            171 => 
            array (
                'isoAlpha3' => 'OMN',
                'countryCode' => 'OM',
                'countryName' => 'Oman',
                'currencyCode' => 'OMR',
            ),
            172 => 
            array (
                'isoAlpha3' => 'PAK',
                'countryCode' => 'PK',
                'countryName' => 'Pakistan',
                'currencyCode' => 'PKR',
            ),
            173 => 
            array (
                'isoAlpha3' => 'PAN',
                'countryCode' => 'PA',
                'countryName' => 'Panama',
                'currencyCode' => 'PAB',
            ),
            174 => 
            array (
                'isoAlpha3' => 'PCN',
                'countryCode' => 'PN',
                'countryName' => 'Pitcairn Islands',
                'currencyCode' => 'NZD',
            ),
            175 => 
            array (
                'isoAlpha3' => 'PER',
                'countryCode' => 'PE',
                'countryName' => 'Peru',
                'currencyCode' => 'PEN',
            ),
            176 => 
            array (
                'isoAlpha3' => 'PHL',
                'countryCode' => 'PH',
                'countryName' => 'Philippines',
                'currencyCode' => 'PHP',
            ),
            177 => 
            array (
                'isoAlpha3' => 'PLW',
                'countryCode' => 'PW',
                'countryName' => 'Palau',
                'currencyCode' => 'USD',
            ),
            178 => 
            array (
                'isoAlpha3' => 'PNG',
                'countryCode' => 'PG',
                'countryName' => 'Papua New Guinea',
                'currencyCode' => 'PGK',
            ),
            179 => 
            array (
                'isoAlpha3' => 'POL',
                'countryCode' => 'PL',
                'countryName' => 'Poland',
                'currencyCode' => 'PLN',
            ),
            180 => 
            array (
                'isoAlpha3' => 'PRI',
                'countryCode' => 'PR',
                'countryName' => 'Puerto Rico',
                'currencyCode' => 'USD',
            ),
            181 => 
            array (
                'isoAlpha3' => 'PRK',
                'countryCode' => 'KP',
                'countryName' => 'North Korea',
                'currencyCode' => 'KPW',
            ),
            182 => 
            array (
                'isoAlpha3' => 'PRT',
                'countryCode' => 'PT',
                'countryName' => 'Portugal',
                'currencyCode' => 'EUR',
            ),
            183 => 
            array (
                'isoAlpha3' => 'PRY',
                'countryCode' => 'PY',
                'countryName' => 'Paraguay',
                'currencyCode' => 'PYG',
            ),
            184 => 
            array (
                'isoAlpha3' => 'PSE',
                'countryCode' => 'PS',
                'countryName' => 'Palestine',
                'currencyCode' => 'ILS',
            ),
            185 => 
            array (
                'isoAlpha3' => 'PYF',
                'countryCode' => 'PF',
                'countryName' => 'French Polynesia',
                'currencyCode' => 'XPF',
            ),
            186 => 
            array (
                'isoAlpha3' => 'QAT',
                'countryCode' => 'QA',
                'countryName' => 'Qatar',
                'currencyCode' => 'QAR',
            ),
            187 => 
            array (
                'isoAlpha3' => 'REU',
                'countryCode' => 'RE',
                'countryName' => 'RÌ©union',
                'currencyCode' => 'EUR',
            ),
            188 => 
            array (
                'isoAlpha3' => 'ROU',
                'countryCode' => 'RO',
                'countryName' => 'Romania',
                'currencyCode' => 'RON',
            ),
            189 => 
            array (
                'isoAlpha3' => 'RUS',
                'countryCode' => 'RU',
                'countryName' => 'Russia',
                'currencyCode' => 'RUB',
            ),
            190 => 
            array (
                'isoAlpha3' => 'RWA',
                'countryCode' => 'RW',
                'countryName' => 'Rwanda',
                'currencyCode' => 'RWF',
            ),
            191 => 
            array (
                'isoAlpha3' => 'SAU',
                'countryCode' => 'SA',
                'countryName' => 'Saudi Arabia',
                'currencyCode' => 'SAR',
            ),
            192 => 
            array (
                'isoAlpha3' => 'SDN',
                'countryCode' => 'SD',
                'countryName' => 'Sudan',
                'currencyCode' => 'SDG',
            ),
            193 => 
            array (
                'isoAlpha3' => 'SEN',
                'countryCode' => 'SN',
                'countryName' => 'Senegal',
                'currencyCode' => 'XOF',
            ),
            194 => 
            array (
                'isoAlpha3' => 'SGP',
                'countryCode' => 'SG',
                'countryName' => 'Singapore',
                'currencyCode' => 'SGD',
            ),
            195 => 
            array (
                'isoAlpha3' => 'SGS',
                'countryCode' => 'GS',
                'countryName' => 'South Georgia and the South Sandwich Islands',
                'currencyCode' => 'GBP',
            ),
            196 => 
            array (
                'isoAlpha3' => 'SHN',
                'countryCode' => 'SH',
                'countryName' => 'Saint Helena',
                'currencyCode' => 'SHP',
            ),
            197 => 
            array (
                'isoAlpha3' => 'SJM',
                'countryCode' => 'SJ',
                'countryName' => 'Svalbard and Jan Mayen',
                'currencyCode' => 'NOK',
            ),
            198 => 
            array (
                'isoAlpha3' => 'SLB',
                'countryCode' => 'SB',
                'countryName' => 'Solomon Islands',
                'currencyCode' => 'SBD',
            ),
            199 => 
            array (
                'isoAlpha3' => 'SLE',
                'countryCode' => 'SL',
                'countryName' => 'Sierra Leone',
                'currencyCode' => 'SLL',
            ),
            200 => 
            array (
                'isoAlpha3' => 'SLV',
                'countryCode' => 'SV',
                'countryName' => 'El Salvador',
                'currencyCode' => 'USD',
            ),
            201 => 
            array (
                'isoAlpha3' => 'SMR',
                'countryCode' => 'SM',
                'countryName' => 'San Marino',
                'currencyCode' => 'EUR',
            ),
            202 => 
            array (
                'isoAlpha3' => 'SOM',
                'countryCode' => 'SO',
                'countryName' => 'Somalia',
                'currencyCode' => 'SOS',
            ),
            203 => 
            array (
                'isoAlpha3' => 'SPM',
                'countryCode' => 'PM',
                'countryName' => 'Saint Pierre and Miquelon',
                'currencyCode' => 'EUR',
            ),
            204 => 
            array (
                'isoAlpha3' => 'SRB',
                'countryCode' => 'RS',
                'countryName' => 'Serbia',
                'currencyCode' => 'RSD',
            ),
            205 => 
            array (
                'isoAlpha3' => 'SSD',
                'countryCode' => 'SS',
                'countryName' => 'South Sudan',
                'currencyCode' => 'SSP',
            ),
            206 => 
            array (
                'isoAlpha3' => 'STP',
                'countryCode' => 'ST',
                'countryName' => 'SÌ£o TomÌ© and PrÌ_ncipe',
                'currencyCode' => 'STD',
            ),
            207 => 
            array (
                'isoAlpha3' => 'SUR',
                'countryCode' => 'SR',
                'countryName' => 'Suriname',
                'currencyCode' => 'SRD',
            ),
            208 => 
            array (
                'isoAlpha3' => 'SVK',
                'countryCode' => 'SK',
                'countryName' => 'Slovakia',
                'currencyCode' => 'EUR',
            ),
            209 => 
            array (
                'isoAlpha3' => 'SVN',
                'countryCode' => 'SI',
                'countryName' => 'Slovenia',
                'currencyCode' => 'EUR',
            ),
            210 => 
            array (
                'isoAlpha3' => 'SWE',
                'countryCode' => 'SE',
                'countryName' => 'Sweden',
                'currencyCode' => 'SEK',
            ),
            211 => 
            array (
                'isoAlpha3' => 'SWZ',
                'countryCode' => 'SZ',
                'countryName' => 'Swaziland',
                'currencyCode' => 'SZL',
            ),
            212 => 
            array (
                'isoAlpha3' => 'SXM',
                'countryCode' => 'SX',
                'countryName' => 'Sint Maarten',
                'currencyCode' => 'ANG',
            ),
            213 => 
            array (
                'isoAlpha3' => 'SYC',
                'countryCode' => 'SC',
                'countryName' => 'Seychelles',
                'currencyCode' => 'SCR',
            ),
            214 => 
            array (
                'isoAlpha3' => 'SYR',
                'countryCode' => 'SY',
                'countryName' => 'Syria',
                'currencyCode' => 'SYP',
            ),
            215 => 
            array (
                'isoAlpha3' => 'TCA',
                'countryCode' => 'TC',
                'countryName' => 'Turks and Caicos Islands',
                'currencyCode' => 'USD',
            ),
            216 => 
            array (
                'isoAlpha3' => 'TCD',
                'countryCode' => 'TD',
                'countryName' => 'Chad',
                'currencyCode' => 'XAF',
            ),
            217 => 
            array (
                'isoAlpha3' => 'TGO',
                'countryCode' => 'TG',
                'countryName' => 'Togo',
                'currencyCode' => 'XOF',
            ),
            218 => 
            array (
                'isoAlpha3' => 'THA',
                'countryCode' => 'TH',
                'countryName' => 'Thailand',
                'currencyCode' => 'THB',
            ),
            219 => 
            array (
                'isoAlpha3' => 'TJK',
                'countryCode' => 'TJ',
                'countryName' => 'Tajikistan',
                'currencyCode' => 'TJS',
            ),
            220 => 
            array (
                'isoAlpha3' => 'TKL',
                'countryCode' => 'TK',
                'countryName' => 'Tokelau',
                'currencyCode' => 'NZD',
            ),
            221 => 
            array (
                'isoAlpha3' => 'TKM',
                'countryCode' => 'TM',
                'countryName' => 'Turkmenistan',
                'currencyCode' => 'TMT',
            ),
            222 => 
            array (
                'isoAlpha3' => 'TLS',
                'countryCode' => 'TL',
                'countryName' => 'East Timor',
                'currencyCode' => 'USD',
            ),
            223 => 
            array (
                'isoAlpha3' => 'TON',
                'countryCode' => 'TO',
                'countryName' => 'Tonga',
                'currencyCode' => 'TOP',
            ),
            224 => 
            array (
                'isoAlpha3' => 'TTO',
                'countryCode' => 'TT',
                'countryName' => 'Trinidad and Tobago',
                'currencyCode' => 'TTD',
            ),
            225 => 
            array (
                'isoAlpha3' => 'TUN',
                'countryCode' => 'TN',
                'countryName' => 'Tunisia',
                'currencyCode' => 'TND',
            ),
            226 => 
            array (
                'isoAlpha3' => 'TUR',
                'countryCode' => 'TR',
                'countryName' => 'Turkey',
                'currencyCode' => 'TRY',
            ),
            227 => 
            array (
                'isoAlpha3' => 'TUV',
                'countryCode' => 'TV',
                'countryName' => 'Tuvalu',
                'currencyCode' => 'AUD',
            ),
            228 => 
            array (
                'isoAlpha3' => 'TWN',
                'countryCode' => 'TW',
                'countryName' => 'Taiwan',
                'currencyCode' => 'TWD',
            ),
            229 => 
            array (
                'isoAlpha3' => 'TZA',
                'countryCode' => 'TZ',
                'countryName' => 'Tanzania',
                'currencyCode' => 'TZS',
            ),
            230 => 
            array (
                'isoAlpha3' => 'UGA',
                'countryCode' => 'UG',
                'countryName' => 'Uganda',
                'currencyCode' => 'UGX',
            ),
            231 => 
            array (
                'isoAlpha3' => 'UKR',
                'countryCode' => 'UA',
                'countryName' => 'Ukraine',
                'currencyCode' => 'UAH',
            ),
            232 => 
            array (
                'isoAlpha3' => 'UMI',
                'countryCode' => 'UM',
                'countryName' => 'U.S. Minor Outlying Islands',
                'currencyCode' => 'USD',
            ),
            233 => 
            array (
                'isoAlpha3' => 'URY',
                'countryCode' => 'UY',
                'countryName' => 'Uruguay',
                'currencyCode' => 'UYU',
            ),
            234 => 
            array (
                'isoAlpha3' => 'USA',
                'countryCode' => 'US',
                'countryName' => 'United States',
                'currencyCode' => 'USD',
            ),
            235 => 
            array (
                'isoAlpha3' => 'UZB',
                'countryCode' => 'UZ',
                'countryName' => 'Uzbekistan',
                'currencyCode' => 'UZS',
            ),
            236 => 
            array (
                'isoAlpha3' => 'VAT',
                'countryCode' => 'VA',
                'countryName' => 'Vatican City',
                'currencyCode' => 'EUR',
            ),
            237 => 
            array (
                'isoAlpha3' => 'VCT',
                'countryCode' => 'VC',
                'countryName' => 'Saint Vincent and the Grenadines',
                'currencyCode' => 'XCD',
            ),
            238 => 
            array (
                'isoAlpha3' => 'VEN',
                'countryCode' => 'VE',
                'countryName' => 'Venezuela',
                'currencyCode' => 'VEF',
            ),
            239 => 
            array (
                'isoAlpha3' => 'VGB',
                'countryCode' => 'VG',
                'countryName' => 'British Virgin Islands',
                'currencyCode' => 'USD',
            ),
            240 => 
            array (
                'isoAlpha3' => 'VIR',
                'countryCode' => 'VI',
                'countryName' => 'U.S. Virgin Islands',
                'currencyCode' => 'USD',
            ),
            241 => 
            array (
                'isoAlpha3' => 'VNM',
                'countryCode' => 'VN',
                'countryName' => 'Vietnam',
                'currencyCode' => 'VND',
            ),
            242 => 
            array (
                'isoAlpha3' => 'VUT',
                'countryCode' => 'VU',
                'countryName' => 'Vanuatu',
                'currencyCode' => 'VUV',
            ),
            243 => 
            array (
                'isoAlpha3' => 'WLF',
                'countryCode' => 'WF',
                'countryName' => 'Wallis and Futuna',
                'currencyCode' => 'XPF',
            ),
            244 => 
            array (
                'isoAlpha3' => 'WSM',
                'countryCode' => 'WS',
                'countryName' => 'Samoa',
                'currencyCode' => 'WST',
            ),
            245 => 
            array (
                'isoAlpha3' => 'XKX',
                'countryCode' => 'XK',
                'countryName' => 'Kosovo',
                'currencyCode' => 'EUR',
            ),
            246 => 
            array (
                'isoAlpha3' => 'YEM',
                'countryCode' => 'YE',
                'countryName' => 'Yemen',
                'currencyCode' => 'YER',
            ),
            247 => 
            array (
                'isoAlpha3' => 'ZAF',
                'countryCode' => 'ZA',
                'countryName' => 'South Africa',
                'currencyCode' => 'ZAR',
            ),
            248 => 
            array (
                'isoAlpha3' => 'ZMB',
                'countryCode' => 'ZM',
                'countryName' => 'Zambia',
                'currencyCode' => 'ZMW',
            ),
            249 => 
            array (
                'isoAlpha3' => 'ZWE',
                'countryCode' => 'ZW',
                'countryName' => 'Zimbabwe',
                'currencyCode' => 'ZWL',
            ),
        ));
        
        
    }
}