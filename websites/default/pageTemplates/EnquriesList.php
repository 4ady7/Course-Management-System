<h2>Manage Enquiries</h2>

<!--//creating a table for the enquries -->
<table border="1">
    <thead>
        <tr>
            <!--creating the table headers for the enquiries list -->
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Message</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <!--looping through each enquiry -->
        <?php foreach ($enquiries as $enquiry) { ?>
        <tr>
            <!--//using the short echo tag to print and display the details of each enquiry on the enquiries list -->
            <td style="text-align: center;"><?= $enquiry['contactName'] ?></td>
            <td style="text-align: center;"><?= $enquiry['contactEmail'] ?></td>
            <td style="text-align: center;"><?= $enquiry['courseName'] ?></td>
            <!--aligning the text in the left center of the text box -->
            <td style="text-align: center;"><?= $enquiry['enquiryContext'] ?></td>
            
            <!--aligning the text to the left of the text box -->
            <td style="text-align: left;">
                <?php if ($enquiry['enquiryResponded'] == 1) { ?>
                    <!--for the enquires that have been marked as responsed to, displaying the following -->
                    Yes, the enquiry has had a response.
                    It has been Responded to
                    <br>(by Staff username: <?= $enquiry['enquiresRespondedBY'] ?>)
                <?php } 
                    else { 
                ?>
                    <!--for the enquires that have not been marked as responsed to, displaying the following pending text -->
                    Pending
                    <!--for the enquires that have not been marked as responsed to, addding a button to allow the staff member to mark the enquiry as an enquiry that had been responded to -->
                    <form action="index.php?destination=enquiry&action=complete" method="post">
                        <input type="hidden" name="id" value="<?= $enquiry['idenquires'] ?>">
                        <input type="submit" value="Mark as Checked">
                    </form>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>