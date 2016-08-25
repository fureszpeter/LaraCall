@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script type="text/javascript" async src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>

    <div class="row">
        <div class="span6">
            <div style="background-color: whitesmoke; padding: 20px;">
                <div class="row-fluid margin_bottom40 clearfix">
                    <div class="span5 font-size24 museo-500 line_height40">Rates for destination</div>
                    <div class="span7">
                        <div class="input_country flag32-bd"></div>
                        <select id="sel_destination" class="width100 margin0">
                            <option value="AF" data-value="AFG">Afghanistan</option>
                            <option value="AL" data-value="ALB">Albania</option>
                            <option value="DZ" data-value="DZA">Algeria</option>
                            <option value="AS" data-value="ASM">American Samoa</option>
                            <option value="AD" data-value="AND">Andorra</option>
                            <option value="AO" data-value="AGO">Angola</option>
                            <option value="AI" data-value="AIA">Anguilla</option>
                            <option value="AG" data-value="ATG">Antigua and Barbuda</option>
                            <option value="AR" data-value="ARG">Argentina</option>
                            <option value="AM" data-value="ARM">Armenia</option>
                            <option value="AW" data-value="ABW">Aruba</option>
                            <option value="AU" data-value="AUS">Australia</option>
                            <option value="AT" data-value="AUT">Austria</option>
                            <option value="AZ" data-value="AZE">Azerbaijan</option>
                            <option value="BS" data-value="BHS">Bahamas</option>
                            <option value="BH" data-value="BHR">Bahrain</option>
                            <option value="BD" data-value="BGD">Bangladesh</option>
                            <option value="BB" data-value="BRB">Barbados</option>
                            <option value="BY" data-value="BLR">Belarus</option>
                            <option value="BE" data-value="BEL">Belgium</option>
                            <option value="BZ" data-value="BLZ">Belize</option>
                            <option value="BJ" data-value="BEN">Benin</option>
                            <option value="BM" data-value="BMU">Bermuda</option>
                            <option value="BT" data-value="BTN">Bhutan</option>
                            <option value="BO" data-value="BOL">Bolivia</option>
                            <option value="BA" data-value="BIH">Bosnia and Herzegovina</option>
                            <option value="BW" data-value="BWA">Botswana</option>
                            <option value="BR" data-value="BRA">Brazil</option>
                            <option value="IO" data-value="">British Indian Ocean Territory</option>
                            <option value="BN" data-value="BRN">Brunei Darussalam</option>
                            <option value="BG" data-value="BGR">Bulgaria</option>
                            <option value="BF" data-value="BFA">Burkina Faso</option>
                            <option value="BI" data-value="BDI">Burundi</option>
                            <option value="KH" data-value="KHM">Cambodia</option>
                            <option value="CM" data-value="CMR">Cameroon</option>
                            <option value="CA" data-value="CAN">Canada</option>
                            <option value="CV" data-value="CPV">Cape Verde</option>
                            <option value="KY" data-value="CYM">Cayman Islands</option>
                            <option value="CF" data-value="CAF">Central African Republic</option>
                            <option value="TD" data-value="TCD">Chad</option>
                            <option value="CL" data-value="CHL">Chile</option>
                            <option value="CN" data-value="CHN">China</option>
                            <option value="CX" data-value="">Christmas Island</option>
                            <option value="CC" data-value="">Cocos (Keeling) Islands</option>
                            <option value="CO" data-value="COL">Colombia</option>
                            <option value="KM" data-value="COM">Comoros</option>
                            <option value="CG" data-value="COG">Congo</option>
                            <option value="CD" data-value="COD">Congo, the Democratic Republic of the</option>
                            <option value="CK" data-value="COK">Cook Islands</option>
                            <option value="CR" data-value="CRI">Costa Rica</option>
                            <option value="CI" data-value="CIV">Cote D'Ivoire</option>
                            <option value="HR" data-value="HRV">Croatia</option>
                            <option value="CU" data-value="CUB">Cuba</option>
                            <option value="CY" data-value="CYP">Cyprus</option>
                            <option value="CZ" data-value="CZE">Czech Republic</option>
                            <option value="DK" data-value="DNK">Denmark</option>
                            <option value="DJ" data-value="DJI">Djibouti</option>
                            <option value="DM" data-value="DMA">Dominica</option>
                            <option value="DO" data-value="DOM">Dominican Republic</option>
                            <option value="EC" data-value="ECU">Ecuador</option>
                            <option value="EG" data-value="EGY">Egypt</option>
                            <option value="SV" data-value="SLV">El Salvador</option>
                            <option value="GQ" data-value="GNQ">Equatorial Guinea</option>
                            <option value="ER" data-value="ERI">Eritrea</option>
                            <option value="EE" data-value="EST">Estonia</option>
                            <option value="ET" data-value="ETH">Ethiopia</option>
                            <option value="FK" data-value="FLK">Falkland Islands (Malvinas)</option>
                            <option value="FO" data-value="FRO">Faroe Islands</option>
                            <option value="FJ" data-value="FJI">Fiji</option>
                            <option value="FI" data-value="FIN">Finland</option>
                            <option value="FR" data-value="FRA">France</option>
                            <option value="GF" data-value="GUF">French Guiana</option>
                            <option value="PF" data-value="PYF">French Polynesia</option>
                            <option value="GA" data-value="GAB">Gabon</option>
                            <option value="GM" data-value="GMB">Gambia</option>
                            <option value="GE" data-value="GEO">Georgia</option>
                            <option value="DE" data-value="DEU">Germany</option>
                            <option value="GH" data-value="GHA">Ghana</option>
                            <option value="GI" data-value="GIB">Gibraltar</option>
                            <option value="GR" data-value="GRC">Greece</option>
                            <option value="GL" data-value="GRL">Greenland</option>
                            <option value="GD" data-value="GRD">Grenada</option>
                            <option value="GP" data-value="GLP">Guadeloupe</option>
                            <option value="GU" data-value="GUM">Guam</option>
                            <option value="GT" data-value="GTM">Guatemala</option>
                            <option value="GN" data-value="GIN">Guinea</option>
                            <option value="GW" data-value="GNB">Guinea-Bissau</option>
                            <option value="GY" data-value="GUY">Guyana</option>
                            <option value="HT" data-value="HTI">Haiti</option>
                            <option value="VA" data-value="VAT">Holy See (Vatican City State)</option>
                            <option value="HN" data-value="HND">Honduras</option>
                            <option value="HK" data-value="HKG">Hong Kong</option>
                            <option value="HU" data-value="HUN">Hungary</option>
                            <option value="IS" data-value="ISL">Iceland</option>
                            <option value="IN" data-value="IND">India</option>
                            <option value="ID" data-value="IDN">Indonesia</option>
                            <option value="IR" data-value="IRN">Iran, Islamic Republic of</option>
                            <option value="IQ" data-value="IRQ">Iraq</option>
                            <option value="IE" data-value="IRL">Ireland</option>
                            <option value="IL" data-value="ISR">Israel</option>
                            <option value="IT" data-value="ITA">Italy</option>
                            <option value="JM" data-value="JAM">Jamaica</option>
                            <option value="JP" data-value="JPN">Japan</option>
                            <option value="JO" data-value="JOR">Jordan</option>
                            <option value="KZ" data-value="KAZ">Kazakhstan</option>
                            <option value="KE" data-value="KEN">Kenya</option>
                            <option value="KI" data-value="KIR">Kiribati</option>
                            <option value="KP" data-value="PRK">Korea, Democratic People's Republic of</option>
                            <option value="KR" data-value="KOR">Korea, Republic of</option>
                            <option value="KW" data-value="KWT">Kuwait</option>
                            <option value="KG" data-value="KGZ">Kyrgyzstan</option>
                            <option value="LA" data-value="LAO">Lao People's Democratic Republic</option>
                            <option value="LV" data-value="LVA">Latvia</option>
                            <option value="LB" data-value="LBN">Lebanon</option>
                            <option value="LS" data-value="LSO">Lesotho</option>
                            <option value="LR" data-value="LBR">Liberia</option>
                            <option value="LY" data-value="LBY">Libyan Arab Jamahiriya</option>
                            <option value="LI" data-value="LIE">Liechtenstein</option>
                            <option value="LT" data-value="LTU">Lithuania</option>
                            <option value="LU" data-value="LUX">Luxembourg</option>
                            <option value="MO" data-value="MAC">Macao</option>
                            <option value="MK" data-value="MKD">Macedonia, the Former Yugoslav Republic of</option>
                            <option value="MG" data-value="MDG">Madagascar</option>
                            <option value="MW" data-value="MWI">Malawi</option>
                            <option value="MY" data-value="MYS">Malaysia</option>
                            <option value="MV" data-value="MDV">Maldives</option>
                            <option value="ML" data-value="MLI">Mali</option>
                            <option value="MT" data-value="MLT">Malta</option>
                            <option value="MH" data-value="MHL">Marshall Islands</option>
                            <option value="MQ" data-value="MTQ">Martinique</option>
                            <option value="MR" data-value="MRT">Mauritania</option>
                            <option value="MU" data-value="MUS">Mauritius</option>
                            <option value="YT" data-value="">Mayotte</option>
                            <option value="MX" data-value="MEX">Mexico</option>
                            <option value="FM" data-value="FSM">Micronesia, Federated States of</option>
                            <option value="MD" data-value="MDA">Moldova, Republic of</option>
                            <option value="MC" data-value="MCO">Monaco</option>
                            <option value="MN" data-value="MNG">Mongolia</option>
                            <option value="MS" data-value="MSR">Montserrat</option>
                            <option value="MA" data-value="MAR">Morocco</option>
                            <option value="MZ" data-value="MOZ">Mozambique</option>
                            <option value="MM" data-value="MMR">Myanmar</option>
                            <option value="NA" data-value="NAM">Namibia</option>
                            <option value="NR" data-value="NRU">Nauru</option>
                            <option value="NP" data-value="NPL">Nepal</option>
                            <option value="NL" data-value="NLD">Netherlands</option>
                            <option value="AN" data-value="ANT">Netherlands Antilles</option>
                            <option value="NC" data-value="NCL">New Caledonia</option>
                            <option value="NZ" data-value="NZL">New Zealand</option>
                            <option value="NI" data-value="NIC">Nicaragua</option>
                            <option value="NE" data-value="NER">Niger</option>
                            <option value="NG" data-value="NGA">Nigeria</option>
                            <option value="NU" data-value="NIU">Niue</option>
                            <option value="NF" data-value="NFK">Norfolk Island</option>
                            <option value="MP" data-value="MNP">Northern Mariana Islands</option>
                            <option value="NO" data-value="NOR">Norway</option>
                            <option value="OM" data-value="OMN">Oman</option>
                            <option value="PK" data-value="PAK">Pakistan</option>
                            <option value="PW" data-value="PLW">Palau</option>
                            <option value="PS" data-value="">Palestinian Territory, Occupied</option>
                            <option value="PA" data-value="PAN">Panama</option>
                            <option value="PG" data-value="PNG">Papua New Guinea</option>
                            <option value="PY" data-value="PRY">Paraguay</option>
                            <option value="PE" data-value="PER">Peru</option>
                            <option value="PH" data-value="PHL">Philippines</option>
                            <option value="PL" data-value="POL">Poland</option>
                            <option value="PT" data-value="PRT">Portugal</option>
                            <option value="PR" data-value="PRI">Puerto Rico</option>
                            <option value="QA" data-value="QAT">Qatar</option>
                            <option value="RE" data-value="REU">Reunion</option>
                            <option value="RO" data-value="ROM">Romania</option>
                            <option value="RU" data-value="RUS">Russian Federation</option>
                            <option value="RW" data-value="RWA">Rwanda</option>
                            <option value="SH" data-value="SHN">Saint Helena</option>
                            <option value="KN" data-value="KNA">Saint Kitts and Nevis</option>
                            <option value="LC" data-value="LCA">Saint Lucia</option>
                            <option value="PM" data-value="SPM">Saint Pierre and Miquelon</option>
                            <option value="VC" data-value="VCT">Saint Vincent and the Grenadines</option>
                            <option value="WS" data-value="WSM">Samoa</option>
                            <option value="SM" data-value="SMR">San Marino</option>
                            <option value="ST" data-value="STP">Sao Tome and Principe</option>
                            <option value="SA" data-value="SAU">Saudi Arabia</option>
                            <option value="SN" data-value="SEN">Senegal</option>
                            <option value="CS" data-value="">Serbia and Montenegro</option>
                            <option value="SC" data-value="SYC">Seychelles</option>
                            <option value="SL" data-value="SLE">Sierra Leone</option>
                            <option value="SG" data-value="SGP">Singapore</option>
                            <option value="SK" data-value="SVK">Slovakia</option>
                            <option value="SI" data-value="SVN">Slovenia</option>
                            <option value="SB" data-value="SLB">Solomon Islands</option>
                            <option value="SO" data-value="SOM">Somalia</option>
                            <option value="ZA" data-value="ZAF">South Africa</option>
                            <option value="ES" data-value="ESP">Spain</option>
                            <option value="LK" data-value="LKA">Sri Lanka</option>
                            <option value="SD" data-value="SDN">Sudan</option>
                            <option value="SR" data-value="SUR">Suriname</option>
                            <option value="SJ" data-value="SJM">Svalbard and Jan Mayen</option>
                            <option value="SZ" data-value="SWZ">Swaziland</option>
                            <option value="SE" data-value="SWE">Sweden</option>
                            <option value="CH" data-value="CHE">Switzerland</option>
                            <option value="SY" data-value="SYR">Syrian Arab Republic</option>
                            <option value="TW" data-value="TWN">Taiwan, Province of China</option>
                            <option value="TJ" data-value="TJK">Tajikistan</option>
                            <option value="TZ" data-value="TZA">Tanzania, United Republic of</option>
                            <option value="TH" data-value="THA">Thailand</option>
                            <option value="TL" data-value="">Timor-Leste</option>
                            <option value="TG" data-value="TGO">Togo</option>
                            <option value="TK" data-value="TKL">Tokelau</option>
                            <option value="TO" data-value="TON">Tonga</option>
                            <option value="TT" data-value="TTO">Trinidad and Tobago</option>
                            <option value="TN" data-value="TUN">Tunisia</option>
                            <option value="TR" data-value="TUR">Turkey</option>
                            <option value="TM" data-value="TKM">Turkmenistan</option>
                            <option value="TC" data-value="TCA">Turks and Caicos Islands</option>
                            <option value="TV" data-value="TUV">Tuvalu</option>
                            <option value="UG" data-value="UGA">Uganda</option>
                            <option value="UA" data-value="UKR">Ukraine</option>
                            <option value="AE" data-value="ARE">United Arab Emirates</option>
                            <option value="GB" data-value="GBR">United Kingdom</option>
                            <option value="US" data-value="USA">United States</option>
                            <option value="UM" data-value="">United States Minor Outlying Islands</option>
                            <option value="UY" data-value="URY">Uruguay</option>
                            <option value="UZ" data-value="UZB">Uzbekistan</option>
                            <option value="VU" data-value="VUT">Vanuatu</option>
                            <option value="VE" data-value="VEN">Venezuela</option>
                            <option value="VN" data-value="VNM">Viet Nam</option>
                            <option value="VG" data-value="VGB">Virgin Islands, British</option>
                            <option value="VI" data-value="VIR">Virgin Islands, U.s.</option>
                            <option value="WF" data-value="WLF">Wallis and Futuna</option>
                            <option value="EH" data-value="ESH">Western Sahara</option>
                            <option value="YE" data-value="YEM">Yemen</option>
                            <option value="ZM" data-value="ZMB">Zambia</option>
                            <option value="ZW" data-value="ZWE">Zimbabwe</option>
                        </select>
                    </div>
                </div>
                <div class="predefined_rates row-fluid">
                    <div class="span5 museo-500 font-size18 line_height40">Select amount</div>
                    <div class="span7 margin_bottom10 clearfix">
                        <div class="row-fluid">
                            <ul id="amount_selector" class="select amount selections list-group" data-formv="amount">
                                <li id="sel_amount_5" data-value="5" class="selected">$5</li>
                                <li id="sel_amount_10" data-value="10">$10</li>
                                <li id="sel_amount_20" data-value="20">$20</li>
                                <li id="sel_amount_50" data-value="50">$50</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Country - Area</th>
                            <th>Price / min</th>
                            <th>Duration</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Country - Area</th>
                            <th>Price / min</th>
                            <th>Duration</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="submit_holder pagination-centered">
                    <button id="form_buy_submit" type="submit" class="btn btn-primary btn-large">Continue »</button>
                </div>
                <a href="http://4call.app/hu/credit/full.html" style="float: right">view the full rate table</a>

            </div>
        </div>
        <div class="span6">
            <div style="background-color: whitesmoke; padding: 20px;">
                <div class="row">
                    <div class="span4">
                        <h1>Why us?</h1>
                        <ul style="list-style: none; padding: 5px; margin: 5px; font-size: 2em;">
                            <li style="min-height: 40px; border-bottom: 1px solid grey; padding: 5px; margin: 5px;">No hidden fees</li>
                            <li style="min-height: 40px; border-bottom: 1px solid grey; padding: 5px; margin: 5px;">1 min rounding</li>
                            <li style="min-height: 40px; border-bottom: 1px solid grey; padding: 5px; margin: 5px;">Quality calls</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="span4">
                        <h1>How to use?</h1>
                        <p>
                        </p><h5>As a Calling Card:</h5>
                        You can use your account as a Prepaid Calling Card. We send you our access numbers and the details.
                        <h5>As a Voip Service:</h5>
                        You can use your account with any Voip client. See our help section.
                        <p></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
