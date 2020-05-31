<?php

/* Version v5.7.6 Privacy & Terms */

// MySQL Queries
$pt_data_que = mysql_query("SELECT * from clf_privacy_terms") or die ('Cannot Select Table');
$pt_data = mysql_fetch_array($pt_data_que) or die ("Cannot Fetch Data");

?>

<br /><h1>Privacy Policy</h1><p></p>

<?php echo $site_name; ?> has established this privacy policy to explain to you how your information is protected, collected and used, which may be updated by <?php echo $site_name; ?> from time to time. <?php echo $site_name; ?> will provide notice of materially significant changes to this privacy policy by posting notice on our site.
<p></p>
<h3>1. Protecting your privacy</h3>
<p style="overflow:auto"><ul>
<li>We <?php echo $pt_data[0]; ?> run banner ads, pop ups, pop unders, or any other kind of commercial ads.</li>
<li>We <?php echo $pt_data[1]; ?> share your information with third parties for marketing purposes.</li>
<li>We <?php echo $pt_data[2]; ?> engage in cross-marketing or link-referral programs with other sites.</li>
<li>We <?php echo $pt_data[3]; ?> employ tracking devices for marketing purposes ("cookies", "web beacons," single-pixel gifs).</li>
<li>We <?php echo $pt_data[4]; ?> send you unsolicited communications for marketing purposes. <?php if ($pt_data[8] == "yes") { echo 'Newsletters are sent if you subscribe to it only.'; } ?></li>
<?php if ($pt_data[7] == "yes") { echo '<li>Account information is password-protected. Keep your password safe.</li>'; } ?>
<?php if ($pt_data[5] == 'no'){ echo ''; } else { ?><li>Forums uses basic webserver authentication. Close your browser to log out.</li><?php } ?>
<li><?php echo $site_name; ?> <?php echo $pt_data[6]; ?> knowingly collect any information from persons under the age of 13. If we learns that a posting is by a person under the age of 13, <?php echo $site_name; ?> will <?php if ($pt_data[6] == 'do not') { echo 'remove'; } else { echo 'keep'; } ?> that post.</li>
<li><?php echo $site_name; ?>, or people who post on this website, may provide links to third party websites, which may have different privacy practices. We are not responsible for, nor have any control over, the privacy policies of those third party websites, and encourage all users to read the privacy policies of each and every website visited.
</li>                        </ul>
</p>
<h3>2. Data we collect</h3><p>
<ul>
  <li>We sometimes collect your email address, for purposes such as sending self-publishing and confirmation emails, <?php if ($pt_data[7] == "yes") { echo 'authenticating user accounts, '; } ?><?php if ($pt_data[8] == "yes") { echo 'providing subscription email services,';} ?><?php if ($pt_data[5] == 'no'){ echo ''; } else { echo 'registering for forums,'; } ?> etc.</li>
  <li>For paid postings, we collect contact information, such as name(s), phone/fax number(s), and address for billing purposes.</li>
  <li><?php echo $site_name; ?> does not store credit card information. Credit card transactions are transmitted to a financial gateway, and we endeavor to protect the security of your payment information during transmission by using Secure Sockets Layer (SSL) technology.</li>
  <li>We may collect personal information if you provide it in feedback or comments, post it on our classifieds <?php if ($pt_data[5] == 'no'){ echo ''; } else { echo 'or interactive forums, '; } ?>or if you contact us directly. Please do not post any personal information on <?php if ($pt_data[5] == 'no'){ echo ''; } else { echo 'our discussion forums or '; } ?>classifieds posts that you expect to keep private.</li>
  <li>Our web logs collect standard web log entries for each page served, including your IP address, page URL, and timestamp. Web logs help us to diagnose problems with our server, to administer our website, and to otherwise provide our service to you.</li>
</ul>
</p>

<h3>3. Data we store</h3>
    <p>
<ul>
  <li>All classified <?php if ($pt_data[5] == 'no'){ echo ''; } else { echo 'and forum '; } ?>postings are stored in our database, even after "deletion," and may be archived elsewhere.</li>
  <li>Our web logs and other records are stored indefinitely.</li>
  <?php if ($pt_data[7] == "yes") { echo '<li>Registered ad posters can access and update their account information through my account page (if applicable).</li>'; } ?>
  <li>Although we make good faith efforts to store the information in a secure operating environment that is not available to the public, we cannot guarantee complete security.</li>
</ul>
</p>

<h3>4. Archiving and display of <?php echo $site_name; ?> postings by search engines and other sites</h3>
<p>
<ul>
Search engines and other sites not affiliated with <?php echo $site_name; ?> - including archive.org, google.com, and groups.yahoo.com - archive or otherwise make available <?php echo $site_name; ?> ad postings, including resumes.
</ul>
</p>

<h3>5. Circumstances in which <?php echo $site_name; ?> may release information</h3>
 <p>
<ul>
  <li>We <?php echo $pt_data[9]; ?> disclose information about the users if required to do so by law or in the good faith belief that such disclosure is reasonably necessary to respond to subpoenas, court orders, or other legal process.</li>
  <li><?php echo $site_name; ?> <?php echo $pt_data[9]; ?> also disclose information about its users to law enforcement officers or others, in the good faith belief that such disclosure is reasonably necessary to: enforce our Terms of Use; respond to claims that any posting or other content violates the rights of third-parties; or protect the rights, property, or personal safety of craigslist, its users or the general public.</li>
</ul>
</p>
<?php if ($pt_data['10'] == 'yes') { ?>
<h3>6. International Users</h3>
<p><ul>
By visiting our web site and providing us with data, you acknowledge and agree that due to the international dimension of our website we may use the data collected in the course of our relationship for the purposes identified in this policy or in our other communications with you, including the transmission of information outside your resident jurisdiction. In addition, please understand that such data may be stored on servers located in the <?php echo $pt_data['p_server_country']; ?>. By providing us with your data, you consent to the transfer of such data.
</ul>
</p>
<?php } else ''; ?>

<h3><?php if ($pt_data['10'] == 'yes') { echo '7'; } else { echo'6'; } ?>. Feedback and comments</h3>
<p><ul>
We welcome your feedback on this document in our <a href="/contact-us">contact form</a>. We would be glad to explain you any terms for your better understanding.
</ul>
</p>