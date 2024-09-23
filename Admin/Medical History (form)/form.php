<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Information Form</title>
    <link rel="stylesheet" href="form.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>

    <script src="form.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="med-form">
            <h1 class="header">Medical Information Form
                <h4>Fill out the medical information carefully!</h4>
            </h1><br>
            
            <form id="medicalForm" action="" method="POST">
                <div>
                    <label>Name:</label>
                    <input type="text" name="fname" placeholder="First Name" required id="fname">
                    <input type="text" name="lname" placeholder="Last Name" required id="lname">
                </div><br>

                <div>
                    <label>Phone Number:</label>
                    <select name="area_code" required>
                        <option value="">--Select--</option>                            
                        <option value="93">Afghanistan (+93)</option>
                        <option value="973">Bahrain (+973)</option>
                        <option value="880">Bangladesh (+880)</option>
                        <option value="975">Bhutan (+975)</option>
                        <option value="673">Brunei (+673)</option>
                        <option value="855">Cambodia (+855)</option>
                        <option value="86">China (+86)</option>
                        <option value="357">Cyprus (+357)</option>
                        <option value="995">Georgia (+995)</option>
                        <option value="91">India (+91)</option>
                        <option value="62">Indonesia (+62)</option>
                        <option value="81">Japan (+81)</option>
                        <option value="962">Jordan (+962)</option>
                        <option value="7">Kazakhstan (+7)</option>
                        <option value="965">Kuwait (+965)</option>
                        <option value="996">Kyrgyzstan (+996)</option>
                        <option value="856">Laos (+856)</option>
                        <option value="961">Lebanon (+961)</option>
                        <option value="60">Malaysia (+60)</option>
                        <option value="960">Maldives (+960)</option>
                        <option value="976">Mongolia (+976)</option>
                        <option value="95">Myanmar (+95)</option>
                        <option value="977">Nepal (+977)</option>
                        <option value="850">North Korea (+850)</option>
                        <option value="968">Oman (+968)</option>
                        <option value="92">Pakistan (+92)</option>
                    </select>
                    <input type="text" name="p_number" placeholder="Phone Number" required>              
                </div><br>

                <div>
                    <label>Birth Date:</label>
                    <input type="date" name="birth_date" required>
                </div><br>

                <div>
                    <label>Address:</label>
                    <input type="text" name="str_address" placeholder="Street Address" required><br>
                    <input type="text" name="str_address2" placeholder="Street Address 2"><br>
                    <input type="text" name="city" placeholder="City" required>
                    <input type="text" name="state" placeholder="State" required><br>
                    <input type="text" name="postcode" placeholder="Postcode" required>
                    <select name="country" required>
                        <option value="">--Country--</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Labuan">Labuan</option>
                        <option value="Putrajaya">Putrajaya</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Malacca">Malacca</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Penang">Penang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                    </select><br>
                </div><br>

                <div>
                    <label>Weight:</label>
                    <input type="text" name="weight" required><br>
                </div><br>

                <div>
                    <label>Height:</label>
                    <input type="text" name="height" required>
                </div>
                <br>

                <!-- Emergency Contact -->
                <h2 style="text-align: center;">Emergency Contact</h2>

                <div>
                    <label>Name:</label>
                    <input type="text" name="e_fname" placeholder="First Name" required>
                    <input type="text" name="e_lname" placeholder="Last Name" required>
                </div><br>

                <div>
                    <label>Home Phone:</label>
                    <input type="text" name="home_number" placeholder="Home Phone" required><br>
                </div><br>  

                <div>
                    <label>Work Number:</label>
                    <input type="text" name="work_number" placeholder="Work Number" required>              
                </div><br>

                <!-- General Medical History -->
                <h2 style="text-align: center;">General Medical History</h2>
                <div>
                    <label>Have you had the Hepatitis B vaccination?</label>
                    <input type="radio" name="hepatitis_b" value="yes" required>Yes<br>
                    <input type="radio" name="hepatitis_b" value="no" required>No                        
                </div><br>

                <label style="color:white">*Immunity information (please note: this information must 
                    be provided prior to employment or you will not be allowed to work)*</label>
                
                <br>
                <div>
                    <label>Chicken Pox (Varicella):</label>
                    <input type="radio" name="varicella" value="immune" required>Immune<br>
                    <input type="radio" name="varicella" value="not immune" required>Not Immune                        
                </div><br>

                <div>
                    <label>Measles:</label>
                    <input type="radio" name="measles" value="immune" required>Immune<br>
                    <input type="radio" name="measles" value="not immune" required>Not Immune                        
                </div><br>

                <div>
                    <label>Significant Medical History (surgery, injuries, serious illness):</label>
                    <textarea name="medical_history" placeholder="Please describe..." required></textarea>
                </div><br>

                <div>
                    <label>List any Medical Problems (asthma, seizures, headaches):</label>
                    <textarea name="medical_problem" placeholder="Please describe..." required></textarea>
                </div><br>

                <div>
                    <label>List any medication taken regularly:</label>
                    <textarea name="medication_taken" placeholder="Please describe..." required></textarea>
                </div><br>

                <div>
                    <label>List any allergies:</label>
                    <textarea name="allergies" placeholder="Please describe..." required></textarea>
                </div><br>

                <!-- Medical Insurance Details -->
                <h2 style="text-align: center;">Medical Insurance Details</h2>
                <div>
                    <label>Do you have medical insurance?</label>
                    <input type="radio" name="medical_insurance" value="yes" required>Yes<br>
                    <input type="radio" name="medical_insurance" value="no" required>No    
                </div><br> 

                <div>
                    <label>Name of Insurance Company:</label>
                    <input type="text" name="insurance_comp" required>
                </div><br>
                
                <div>
                    <label>Insurance Company Address:</label>
                    <input type="text" name="ins_address" placeholder="Street Address" required><br>
                    <input type="text" name="ins_address2" placeholder="Street Address 2"><br>
                    <input type="text" name="ins_city" placeholder="City" required>
                    <input type="text" name="ins_state" placeholder="State" required><br>
                    <input type="text" name="ins_poscode" placeholder="Postcode" required>
                    <select name="ins_country" required>
                        <option value="">--Country--</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Labuan">Labuan</option>
                        <option value="Putrajaya">Putrajaya</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Malacca">Malacca</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Penang">Penang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                    </select><br>
                </div><br>

                <div>
                    <label>Policy Number:</label>
                    <input type="text" name="policy_num" required>
                </div><br>

                <div>
                    <label>Expiry Date:</label>
                    <input type="date" name="expiry_date" required>               
                </div><br>
                
                <div class="button-container">
                <button type="button" onclick="generateReceipt()">Generate Receipt</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>