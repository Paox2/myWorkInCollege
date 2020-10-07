<!-- update the account info, distribute reps to manger, distribute reps to region, update/re-grant quota
all in these page, it will according to the content pass to this page to show different thing. -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Update</title>
    <link rel="shortcut icon" href="images/logo1.ico" />
    <meta charset="utf-8">
    <link href="css/Woolin.css" type="text/css" rel="stylesheet"/>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="../published/UIkit.css" />
    <!-- UIkit JS -->
    <script src="../published/uikit_min.js"></script>
    <script src="../published/uikit_icons_min.js"></script>
</head>
<?php $change = $_GET['change']; $log = $_GET['log']?>
<body>
<div class="uk-card uk-card-default uk-card-body uk-width-1-2 update-canvas-position">
    <h1 class="uk-heading-line uk-text-center"><span>Woolin Auto</span></h1>

<?php if ($log == 'repsMan') {
    include("php/connect.php");
    $sql = "SELECT * FROM manager WHERE username not in ('admin')";
    $result1 = $conn->query($sql);
    $nrow = $result1->num_rows;
    $conn->close(); if ($nrow > 0){?>
    <div class="uk-navbar-item">
        <form class="uk-form-stacked"  method="post" action="<?php echo 'php/updateDB.php?change='.$change.'&log='.$log ?>">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">Manager:</label>
                <div class="uk-form-controls">
                    <select class="uk-select" name="MAN">
                        <?php while($man = $result1->fetch_assoc()){
                            $manName=$man['username'];?>
                        <option value="<?=$manName?>"><?=$manName?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="uk-margin">
                <button class="uk-button uk-button-default" type="submit">update</button>
            </div>
        </form>
    </div>
    <?php }else{ ?>
    <h2>No manager</h2>
    <?php } ?>
<?php }else if($log == 'update'){?>
    <div class="uk-navbar-item">
        <form class="uk-form-stacked"  method="post" action="<?php echo 'php/updateDB.php?change='.$change.'&log='.$log ?>">
            <div class="uk-margin">
                <?php if($_GET['N95']>=0){ ?>
                    <label class="uk-form-label" for="form-stacked-text">N95: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="N95" name="N95" value="<?=$_GET['N95']?>" min="0"/>
                        </div>
                    </div>
                <?php } else {?>
                    <div class="uk-form-controls">
                        <label class="uk-form-label" for="form-stacked-text">N95 Cannot Update</label>
                        <input class="uk-input" id="N95" name="N95" value="<?=$_GET['N95']?>" readonly="readonly"/>
                    </div>
                <?php } ?>
            </div>
            <div class="uk-margin">
                <?php if($_GET['Sm']>=0){ ?>
                    <label class="uk-form-label" for="form-stacked-text">Sm: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="Sm" name="Sm" value="<?=$_GET['Sm']?>" min="0"/>
                        </div>
                    </div>
                <?php } else {?>
                    <label class="uk-form-label" for="form-stacked-text">Sm Cannot Update</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="Sm" name="Sm" value="<?=$_GET['Sm']?>" readonly="readonly"/>
                    </div>
                <?php } ?>
            </div>

            <div class="uk-margin">
                <?php if($_GET['N95m']>=0){ ?>
                <label class="uk-form-label" for="form-stacked-text">N95m: </label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="number" id="N95m" name="N95m" value="<?=$_GET['N95m']?>" min="0"/>
                </div>
            </div>
            <?php } else {?>
                <label class="uk-form-label" for="form-stacked-text">N95m Cannot Update</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="N95m" name="N95m" value="<?=$_GET['N95m']?>" readonly="readonly"/>
                </div>
            </div>
            <?php } ?>

            <div class="uk-margin">
                <button class="uk-button uk-button-default" type="submit">update</button>
            </div>
        </form>
    </div>
<?php } else if($log == 'N95price' || $log == 'Smprice' || $log == 'N95mprice'){?>
    <div class="uk-navbar-item">
        <form class="uk-form-stacked"  method="post" action="<?php echo 'php/updateDB.php?change='.$change.'&log='.$log ?>">
            <div class="uk-margin">
                <?php if($log == 'N95price'){ ?>
                    <label class="uk-form-label" for="form-stacked-text">N95: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="N95" name="N95" value="<?=$_GET['price']?>" min="0.00" step="0.01"/>
                        </div>
                    </div>
                <?php } else if($log == 'Smprice'){?>
                    <label class="uk-form-label" for="form-stacked-text">N95: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="N95" name="N95" value="<?=$_GET['price']?>" min="0.00" step="0.01"/>
                        </div>
                    </div>
                <?php } else {?>
                <label class="uk-form-label" for="form-stacked-text">N95: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="N95" name="N95" value="<?=$_GET['price']?>" min="0.00" step="0.01"/>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="uk-margin">
                <button class="uk-button uk-button-default" type="submit">update</button>
            </div>
        </form>
    </div>
<?php } else if($log == 'regrant') { $quotaN95 = $_GET['N95'];$quotaN95m = $_GET['N95m'];$quotaSm = $_GET['Sm'];?>
    <div class="uk-navbar-item">
        <form class="uk-form-stacked"  method="post" action="<?php echo 'php/updateDB.php?change='.$change.'&log='.$log."&N95=".$quotaN95."&Sm=".$quotaSm."&N95m=".$quotaN95m ?>">
            <div class="uk-margin">
                <?php if($_GET['N95']<0){ ?>
                    <label class="uk-form-label" for="form-stacked-text">N95: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="N95" name="N95" value="<?=$_GET['N95']?>" min="0"/>
                        </div>
                    </div>
                <?php } else {?>
                    <div class="uk-form-controls">
                        <label class="uk-form-label" for="form-stacked-text">N95 Cannot Re-grant</label>
                        <input class="uk-input" id="N95" name="N95" value="<?=$_GET['N95']?>" readonly="readonly"/>
                    </div>
                <?php } ?>
            </div>
            <div class="uk-margin">
                <?php if($_GET['Sm']<0){ ?>
                    <label class="uk-form-label" for="form-stacked-text">Sm: </label>
                    <div class="uk-form-controls">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="number" id="Sm" name="Sm" value="<?=$_GET['Sm']?>" min="0"/>
                        </div>
                    </div>
                <?php } else {?>
                    <label class="uk-form-label" for="form-stacked-text">Sm Cannot Re-grant</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="Sm" name="Sm" value="<?=$_GET['Sm']?>" readonly="readonly"/>
                    </div>
                <?php } ?>
            </div>

            <div class="uk-margin">
                <?php if($_GET['N95m']<0){ ?>
                    <label class="uk-form-label" for="form-stacked-text">N95m: </label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="number" id="N95m" name="N95m" value="<?=$_GET['N95m']?>" min="0"/>
                    </div>
                </div>
                <?php } else {?>
                    <label class="uk-form-label" for="form-stacked-text">N95m Cannot Re-grant</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="N95m" name="N95m" value="<?=$_GET['N95m']?>" readonly="readonly"/>
                    </div>
            </div>
                <?php } ?>

            <div class="uk-margin">
                <button class="uk-button uk-button-default" type="submit">update</button>
            </div>
        </form>
    </div>
<?php } else {?>
    <div class="uk-navbar-item">
        <form class="uk-form-stacked"  method="post" action="<?php echo 'php/updateDB.php?change='.$change.'&log='.$log ?>" >
            <?php if($change == 'password') {?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">password(6-10, cannot contain space)</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-width-large" name="new-password" type="text" placeholder="password"  required pattern="^[^\s]{6,10}$">
                    </div>
                </div>
            <?php } else if($change == 'realname') {?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Real Name</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="realname" type="text" placeholder="Ming Li" required pattern="^[A-Za-z]{2,25}( [A-Za-z]{2,25})*$">
                    </div>
                </div>
            <?php } else if($change == 'passport') {?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">passport</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="passport" type="text" placeholder="passport"  required>
                    </div>
                </div>
            <?php } else if($change == 'tel') {?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">tel</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="tel" type="text" placeholder="123-4567-8910"  required pattern="^[0-9]{3}[-][0-9]{4}[-][0-9]{4}$">
                    </div>
                </div>
            <?php } else if($change == 'email') {?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">e-mail</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="email" type="text" placeholder="xxx@xxx.xx"  required pattern="^[a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+$">
                    </div>
                </div>
            <?php } else if($change == 'region' || $log == 'region') {?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Region</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="region">
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Bouvet Island">Bouvet Island</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote D'ivoire">Cote D'ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Territories">French Southern Territories</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guinea-bissau">Guinea-bissau</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                            <option value="Korea, Republic of">Korea, Republic of</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macao">Macao</option>
                            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Namibia">Namibia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau">Palau</option>
                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Pitcairn">Pitcairn</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russian Federation">Russian Federation</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="Saint Helena">Saint Helena</option>
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="Saint Lucia">Saint Lucia</option>
                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                            <option value="Samoa">Samoa</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Timor-leste">Timor-leste</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Viet Nam">Viet Nam</option>
                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                            <option value="Western Sahara">Western Sahara</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>

                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="uk-margin">
                <button class="uk-button uk-button-default" type="submit">update</button>
            </div>
        </form>
    </div>
<?php }?>

</div>
</body>
<?php } else {
    header("location:login.php");
} ?>
</html>