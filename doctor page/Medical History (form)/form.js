function generateReceipt() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const formData = new FormData(document.getElementById('medicalForm'));
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    doc.setFontSize(20);
    doc.setTextColor(0, 0, 255);
    doc.text('Medical Information Receipt', 14, 20);

    doc.setFontSize(16);
    doc.setTextColor(0, 0, 0);
    doc.text('Personal Information', 14, 30);

    // Create a table for personal information
    const personalInfo = [
        ['Name', `${data.fname} ${data.lname}`],
        ['Birth Date', data.birth_date],
        ['Phone Number', `${data.area_code} ${data.p_number}`],
        ['Address', `${data.str_address} ${data.str_address2 ? data.str_address2 + ', ' : ''}${data.city}, ${data.state}, ${data.postcode}, ${data.country}`],
        ['Weight', data.weight],
        ['Height', data.height]
    ];

    doc.autoTable({
        startY: 40,
        head: [['Field', 'Value']],
        body: personalInfo
    });

    doc.text('Emergency Contact', 14, doc.autoTable.previous.finalY + 10);
    const emergencyContact = [
        ['Name', `${data.e_fname} ${data.e_lname}`],
        ['Home Phone', data.home_number],
        ['Work Number', data.work_number]
    ];

    doc.autoTable({
        startY: doc.autoTable.previous.finalY + 20,
        head: [['Field', 'Value']],
        body: emergencyContact
    });

    doc.text('General Medical History', 14, doc.autoTable.previous.finalY + 10);
    const medicalHistory = [
        ['Hepatitis B Vaccination', data.hepatitis_b],
        ['Chicken Pox (Varicella)', data.varicella],
        ['Measles', data.measles],
        ['Significant Medical History', data.medical_history],
        ['Medical Problems', data.medical_problem],
        ['Medication Taken', data.medication_taken],
        ['Allergies', data.allergies]
    ];

    doc.autoTable({
        startY: doc.autoTable.previous.finalY + 20,
        head: [['Field', 'Value']],
        body: medicalHistory
    });

    doc.text('Medical Insurance Details', 14, doc.autoTable.previous.finalY + 10);
    const insuranceDetails = [
        ['Medical Insurance', data.medical_insurance],
        ['Insurance Company', data.insurance_comp],
        ['Insurance Company Address', `${data.ins_address} ${data.ins_address2 ? data.ins_address2 + ', ' : ''}${data.ins_city}, ${data.ins_state}, ${data.ins_poscode}, ${data.ins_country}`],
        ['Policy Number', data.policy_num],
        ['Expiry Date', data.expiry_date]
    ];

    doc.autoTable({
        startY: doc.autoTable.previous.finalY + 20,
        head: [['Field', 'Value']],
        body: insuranceDetails
    });

    // Create a URL for the PDF
    const pdfUrl = doc.output('bloburl');

    // Open the PDF in a new window or tab
    window.open(pdfUrl, '_blank');
}