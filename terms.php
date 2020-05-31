<?php

/* Version v5.7.6 Privacy & Terms */

// MySQL Queries
$pt_data_que = mysql_query("SELECT * from clf_privacy_terms") or die ('Cannot Select Table');
$pt_data = mysql_fetch_array($pt_data_que) or die ("Cannot Fetch Data");

?>

<br /><h1>Terms of Use</h1><br />


<h3>[-] ACCEPTANCE OF TERMS</h3>

<p><?php echo($site_name); ?> provides a collection of online resources, including classified
ads<?php if ($pt_data[5] == 'no'){ echo ''; } else { ?>, forums<?php } ?> and various email services, (referred to hereafter as "the
Service") subject to the following Terms of Use ("TOU"). By using the Service
in any way, you are agreeing to comply with the TOU. In addition, when using
particular our services, you agree to abide by any applicable posted
guidelines for all of our services, which may change from time to time.
Should you object to any term or condition of the TOU, any guidelines,
or any subsequent modifications thereto or become dissatisfied with <?php echo($site_name); ?>
in any way, your only recourse is to immediately discontinue use of our service.
<?php echo($site_name); ?> has the right, but is not obligated, to strictly enforce the TOU
through self-help, community moderation, active investigation, litigation and
prosecution.<br /><br /></p>


<?php if ($pt_data[12] == 'We do not reserve') { echo ''; } else { ?><h3>[-] MODIFICATIONS TO THIS AGREEMENT</h3>

<p>We reserve the right, at our sole discretion, to change, modify or otherwise
alter these terms and conditions at any time.  Such modifications shall become
effective immediately upon the posting thereof. You must review this agreement
on a regular basis to keep yourself apprised of any changes. You can find the
most recent version of the TOU at:<br /><br />
<a href="<?php echo($script_url); ?>/?view=page&pagename=terms" target="_top" title="Terms And Conditions"><?php echo($script_url); ?>/?view=page&pagename=terms</a>
<br /><br /></p>
<?php } ?>


<h3>[-] CONTENT</h3>
<p>
You understand that all ad postings, messages, text, files, images, photos,
video, sounds, or other materials ("Content") posted on, transmitted
through, or linked from the Service, are the sole responsibility of the
person from whom such Content originated. More specifically, you are
entirely responsible for each individual item ("Item") of Content that you
post, email or otherwise make available via the Service. You understand that
<?php echo($site_name); ?> does not control, and is not responsible for Content made available
through the Service, and that by using the Service, you may be exposed to
Content that is offensive, indecent, inaccurate, misleading, or otherwise
objectionable. Furthermore, our website contents available through
the Service may contain links to other websites, which are completely
independent of <?php echo($site_name); ?>.  We makes no representation or warranty as
to the accuracy, completeness or authenticity of the information contained
in any such site.  Your linking to any other webites is at your own risk.
You agree that you must evaluate, and bear all risks associated with, the
use of any Content, that you may not rely on said Content, and that under no
circumstances will <?php echo($site_name); ?> be liable in any way for any Content or for
any loss or damage of any kind incurred as a result of the use of any Content
posted, emailed or otherwise made available via the Service. You acknowledge
that we does not pre-screen or approve Content, but that we
shall have the right (but not the obligation) in its sole discretion to
refuse, delete or move any Content that is available via the Service, for
violating the letter or spirit of the TOU or for any other reason.<br /><br /></p>


<h3>[-] THIRD PARTY CONTENT, SITES, AND SERVICES</h3>
<p>
The <?php echo($site_name); ?> and Content available through the Service may contain
features and functionalities that may link you or provide you with access
to third party content which is completely independent of <?php echo($site_name); ?>,
including web sites, directories, servers, networks, systems, information
and databases, applications, software, programs, products or services,
and the Internet as a whole.<br /><br />

Your interactions with organizations and/or individuals found on or through
the Service, including payment and delivery of goods or services, and any
other terms, conditions, warranties or representations associated with such
dealings, are solely between you and such organizations and/or individuals.
You should make whatever investigation you feel necessary or appropriate
before proceeding with any online or offline transaction with any of these
third parties.<br /><br />

You agree that <?php echo($site_name); ?> shall not be responsible or liable for any loss or
damage of any sort incurred as the result of any such dealings. If there is
a dispute between participants on this site, or between users and any third
party, you understand and agree that <?php echo($site_name); ?> is under no obligation to
become involved. In the event that you have a dispute with one or more other
users, you hereby release , its officers, employees, agents and
successors in rights from claims, demands and damages (actual and
consequential) of every kind or nature, known or unknown, suspected and
unsuspected, disclosed and undisclosed, arising out of or in any way related
to such disputes and / or our service. <br /> <br />
</p>

<h3>[-]  NOTIFICATION OF CLAIMS OF INFRINGEMENT</h3>
<p>
If you believe that your work has been copied in a way that constitutes
copyright infringement, or your intellectual property rights have been
otherwise violated, please notify us for notice of claims of
copyright or other intellectual property infringement ("Agent"), at<br /><br />

<?php echo($site_email); ?><br /><br />

Please provide us with the following Notice:<br /><br />

a) Identify the material on the <?php echo($site_name); ?> website that you claim is
infringing, with enough detail so that we may locate it on the website;<br /><br />

b) A statement by you that you have a good faith belief that the disputed
use is not authorized by the copyright owner, its agent, or the law;<br /><br />

c) A statement by you declaring under penalty of perjury that (1) the above
information in your Notice is accurate, and (2) that you are the owner of
the copyright interest involved or that you are authorized to act on behalf
of that owner;<br /><br />

d) Your address, telephone number, and email address; and<br /><br />

e) Your physical or electronic signature.<br /><br />

<?php echo($site_name); ?> will remove the infringing posting(s), subject to the the procedures
outlined in the Digital Millenium Copyright Act (DMCA).<br /><br />
</p>

<h3>[-] PRIVACY AND INFORMATION DISCLOSURE</h3>
<p>
<?php echo($site_name); ?> has established a Privacy Policy to explain to users how their
information is collected and used, which is located at the following web
address: <br /><br />

<a href="<?php echo($script_url); ?>/?view=page&pagename=terms" target="_top" title="Privacy Policy"><?php echo($script_url); ?>/?view=page&pagename=privacy</a>
<br /><br />
Your use of the <?php echo($site_name); ?> website or the Service signifies acknowledgement of
and agreement to our Privacy Policy. You further acknowledge and agree that
we <?php echo $pt_data[9]; ?>, in its sole discretion, preserve or disclose your Content,
as well as your information, such as email addresses, IP addresses, timestamps,
and other user information, if required to do so by law or in the good faith
belief that such preservation or disclosure is reasonably necessary to:
comply with legal process; enforce the TOU; respond to claims that any
Content violates the rights of third-parties; respond to claims that contact
information (e.g. phone number, street address) of a third-party has been
posted or transmitted without their consent or as a form of harassment;
protect the rights, property, or personal safety of craigslist, its users or
the general public.<br /><br />
                     </p>

<h3>[-] CONDUCT</h3>
<p>
You agree not to post, email, or otherwise make available Content:<br /><br />

x) that is unlawful, harmful, threatening, abusive, harassing, defamatory,
libelous, invasive of another's privacy, or is harmful to minors in any way;<br /><br />

<?php if ($pt_data[13] == 'allowed') { echo (''); } else { ?>x) that is pornographic or depicts a human being engaged in actual sexual conduct
including but not limited to :<br /><ul><li> sexual intercourse, including genital-genital,
oral-genital, anal-genital, or oral-anal, whether between persons of the same or
opposite sex, or </li><li> bestiality, or </li><li> masturbation, or </li><li> sadistic or
masochistic abuse, or </li><li> lascivious exhibition of the genitals or pubic area
of any person;</li></ul><br /><?php } ?>

x) that harasses, degrades, intimidates or is hateful toward an individual or
group of individuals on the basis of religion, gender,<?php if ($pt_data[13] == 'allowed') { echo (''); } else { ?> sexual orientation,<?php } ?>
race, ethnicity, age, or disability;<br /><br />

x) that violates the Fair Housing Act by stating, in any notice or ad for
the sale or rental of any dwelling, a discriminatory preference based on
race, color, national origin, religion, <?php if ($pt_data[13] == 'allowed') { echo (''); } else { ?>sex, <?php } ?>familial status or handicap
(or violates any state or local law prohibiting discrimination on the
basis of these or other characteristics);<br /><br />

x) that violates federal, state, or local equal employment opportunity
laws, including but not limited to, stating in any advertisement for
employment a preference or requirement based on race, color, religion,
<?php if ($pt_data[13] == 'allowed') { echo (''); } else { ?>sex,<?php } ?> national origin, age, or disability.<br /><br />

x) that impersonates any person or entity, including, but not limited to, a
<?php echo($site_name); ?> employee, or falsely states or otherwise misrepresents your
affiliation with a person or entity (this provision does not apply to Content
that constitutes lawful non-deceptive parody of public figures.);<br /><br />

x) that includes personal or identifying information about another person
without that person's explicit consent;<br /><br />

x) that is false, deceptive, misleading, deceitful, misinformative, or
constitutes "bait and switch";<br /><br />

x) that infringes any patent, trademark, trade secret, copyright or other
proprietary rights of any party, or Content that you do not have a right to
make available under any law or under contractual or fiduciary relationships;<br /><br />

<?php if ($pt_data[1] == 'do') { echo (''); } else { ?>x) that constitutes or contains  "affiliate marketing," "link referral code,"
"junk mail," "spam," "chain letters," "pyramid schemes," or unsolicited
commercial advertisement;<br /><br /><?php } ?>

x) that constitutes or contains any form of advertising or solicitation if:
posted in areas of the <?php echo($site_name); ?> websites which are not designated for such
purposes; or emailed to <?php echo($site_name); ?> users who have not indicated in writing that
it is ok to contact them about other services, products or commercial interests.<br /><br />

x) that includes links to commercial services or web sites, except as allowed
in "services";<br /><br />

x) that advertises any illegal service or the sale of any items the sale of
which is prohibited or restricted by any applicable law, including without
limitation items the sale of which is prohibited or regulated by
law.<br /><br />

x) that contains software viruses or any other computer code, files or
programs designed to interrupt, destroy or limit the functionality of any
computer software or hardware or telecommunications equipment;<br /><br />

x) that disrupts the normal flow of dialogue with an excessive amount of
Content (flooding attack) to the Service, or that otherwise negatively
affects other users' ability to use the Service; or<br /><br />

x) that employs misleading email addresses, or forged headers or otherwise
manipulated identifiers in order to disguise the origin of Content
transmitted through the Service.<br /><br />

Additionally, you agree not to:<br /><br />

x) contact anyone who has asked not to be contacted, or make unsolicited
contact with anyone for any commercial purpose;<br /><br />

x) "stalk" or otherwise harass anyone;<br /><br />

x) collect personal data about other users for commercial or unlawful
purposes;<br /><br />

x) use automated means, including spiders, robots, crawlers, data mining
tools, or the like to download data from the Service - unless expressly
permitted by <?php echo($site_name); ?>;<br /><br />

x) post non-local or otherwise irrelevant Content, repeatedly post the
same or similar Content or otherwise impose an unreasonable or
disproportionately large load on our infrastructure;<br /><br />

x) post the same item or service in more than one classified category <?php if ($pt_data[5] == 'no'){ echo ''; } else { ?>or
forum,<?php } ?> or in more than one metropolitan area;<br /><br />

x) attempt to gain unauthorized access to <?php echo($site_name); ?>'s servers or
engage in any activity that disrupts, diminishes the quality of, interferes
with the performance of, or impairs the functionality of, the Service or
the our website; or<br /><br />

x) use any form of automated device or computer program that enables the
submission of ad postings on our website without each posting being manually
entered by the author thereof (an "automated posting device"), including
without limitation, the use of any such automated posting device to submit
postings in bulk, or for automatic submission of postings at regular intervals.<br /><br />

x) use any form of automated device or computer program ("flagging tool")
that enables the use of <?php echo($site_name); ?>'s "flagging system" or other community
moderation systems without each flag being manually entered by the person
that initiates the flag (an "automated flagging device"), or use the
flagging tool to remove posts of competitors, or to remove posts without a
good faith belief that the post being flagged violates these TOU;<br /><br />
</p>

<?php if ($pt_data[14] == 'no') { echo (''); } else { ?>
<h3>[-] POSTING AGENTS</h3>
<p>
A "Posting Agent" is a third-party agent, service, or intermediary
that offers to post Content to the Service on behalf of others. To
moderate demands on <?php echo($site_name); ?>'s resources, you may not use a Posting
Agent to post Content to the Service without express permission or
license from us. Correspondingly, Posting Agents are not
permitted to post Content on behalf of others, to cause Content to
be so posted, or otherwise access the Service to facilitate posting
Content on behalf of others, except with express permission or
license from <?php echo($site_name); ?>.
</p><br /><br /><?php } ?>

<h3>[-] NO SPAM POLICY</h3>
<p>
You understand and agree that sending unsolicited email advertisements to
<?php echo($site_name); ?> email addresses or through <?php echo($site_name); ?> computer systems, which is
expressly prohibited by these Terms, will use or cause to be used servers
located in <?php echo $pt_data['p_server_country']; ?>.  Any unauthorized use of our computer systems
is a violation of these Terms and certain federal and state laws, including
without limitation the Computer Fraud and Abuse Act. Such violations may subject the
sender and his or her agents to civil and criminal penalties.<br /><br /></p>


<?php if ($pt_data[15] == "yes") { ?><h3>[-] PAID POSTINGS</h3>
<p>
We may charge a fee to post Content in some areas of the Service. The fee
is an access fee permitting Content to be posted in a designated area.
Each party posting Content to the Service is responsible for said Content
and compliance with the TOU. All fees paid will be non-refundable in the
event that Content is removed from the Service for violating the TOU.<br /><br />
</p><?php } else { echo(''); } ?>


<h3>[-] LIMITATIONS ON SERVICE</h3>
<p>
You acknowledge that <?php echo($site_name); ?> may establish limits concerning use of the
Service, including the maximum number of days that Content will be retained
by the Service, the maximum number and size of postings, email messages, or
other Content that may be transmitted or stored by the Service, and the
frequency with which you may access the Service. You agree that <?php echo($site_name); ?>
has no responsibility or liability for the deletion or failure to store any
Content maintained or transmitted by the Service. You acknowledge that
we reserves the right at any time to modify or discontinue the
Service (or any part thereof) with or without notice, and that we
shall not be liable to you or to any third party for any modification,
suspension or discontinuance of the Service.<br /><br /></p>


<h3>[-] ACCESS TO THE SERVICE</h3>
<p>
<?php echo($site_name); ?> grants you a limited, revocable, nonexclusive license to access
the Service for your own personal use.  This license does not include:
<?php if ($pt_data[14] == 'no') { echo (''); } else { ?>(+) access to the Service by Posting Agents; or<?php } ?> (=>) any collection,
aggregation, copying, duplication, display or derivative use of the Service
nor any use of data mining, robots, spiders, or similar data gathering and
extraction tools for any purpose unless expressly permitted by <?php echo($site_name); ?>.
A limited exception to (=>) is provided to general purpose internet search
engines and non-commercial public archives that use such tools to gather
information for the sole purpose of displaying hyperlinks to the Service,
provided they each do so from a stable IP address or range of IP addresses
using an easily identifiable agent and comply with our robots.txt file.
"General purpose internet search engine" does not include a website or
search engine or other service that specializes in classified listings
or in any subset of classifieds listings which is in the business of providing classified
ad listing services.       <br /><br /></p>

<p><?php echo($site_name); ?> permits you to display on your website, or create a hyperlink
on your website to, individual postings on the Service so long as such use
is for noncommercial and/or news reporting purposes only (e.g., for use in
personal web blogs or personal online media).  If the total number of such
postings displayed or linked to on your website exceeds one hundred (100)
postings, your use will be presumed to be in violation of the TOU,
absent express permission granted by <?php echo($site_name); ?> to do so.  You may also
create a hyperlink to the home page of <?php echo($site_name); ?> websites so long as the
link does not portray our site, its employees, or its affiliates in a
false, misleading, derogatory, or otherwise offensive matter.<br /><br />       </p>

<p><?php echo($site_name); ?> offers various parts of the Service in RSS format so that users
can embed individual feeds into a personal website or blog, or view postings
through third party software news aggregators.  <?php echo($site_name); ?> permits you to
display, excerpt from, and link to the RSS feeds on your personal website
or personal web blog, provided that (a) your use of the RSS feed is for
personal, non-commercial purposes only, (b) each title is correctly linked
back to the original post on the Service and redirects the user to the
post when the user clicks on it, (c) you provide, adjacent to the RSS
feed, proper attribution to '<?php echo($script_url); ?>' as the source, (d) your use or
display does not suggest that <?php echo($site_name); ?> promotes or endorses any third
party causes, ideas, web sites, products or services, (e) you do not
redistribute the RSS feed, and (f) your use does not overburden
<?php echo($site_name); ?>'s systems.  We reserves all rights in the content of
the RSS feeds and may terminate any RSS feed at any time.<br /><br />      </p>

<p>Use of the Service beyond the scope of authorized access granted to you by
<?php echo($site_name); ?> immediately terminates said permission or license.  In order to
collect, aggregate, copy, duplicate, display or make derivative use of the
the Service or any Content made available via the Service for other
purposes (including commercial purposes) not stated herein, you must first
obtain a license from <?php echo($site_name); ?>.<br /><br /></p>


<h3>[-] TERMINATION OF SERVICE</h3>
<p>
You agree that <?php echo($site_name); ?>, in its sole discretion, has the right (but not
the obligation) to <?php if ($pt_data[7] == "no") { echo ''; } else { ?>delete or deactivate your account, <?php } ?>block your email or IP
address, or otherwise terminate your access to or use of the Service (or any
part thereof), immediately and without notice, and remove and discard any
Content within the Service, for any reason, including, without limitation,
if we believes that you have acted inconsistently with the letter or
spirit of the TOU. Further, you agree that <?php echo($site_name); ?> shall not be liable
to you or any third-party for any termination of your access to the Service.
Further, you agree not to attempt to use the Service after said termination.<br /><br /></p>


<h3>[-] PROPRIETARY RIGHTS</h3>
<p>
The Service is protected to the maximum extent permitted by copyright laws
and international treaties. Content displayed on or through the Service is
protected by copyright as a collective work and/or compilation, pursuant to
copyrights laws, and international conventions. Any reproduction,
modification, creation of derivative works from or redistribution of the
site or the collective work, and/or copying or reproducing the sites
or any portion thereof to any other server or location for further
reproduction or redistribution is prohibited without the express
written consent of <?php echo($site_name); ?>. You further agree not to reproduce,
duplicate or copy Content from the Service without the express written
consent of <?php echo($site_name); ?>, and agree to abide by any and all copyright notices
displayed on the Service. You may not decompile or disassemble, reverse
engineer or otherwise attempt to discover any source code contained in the
Service. Without limiting the foregoing, you agree not to reproduce,
duplicate, copy, sell, resell or exploit for any commercial purposes, any
aspect of the Service. <?php if ($pt_data['t_registeredtrademark'] == 'yes') { ?><span style="text-transform:uppercase"><?php echo($site_name); ?></span> is a registered mark in the U.S. Patent
and Trademark Office.<?php } else { echo ''; } ?><br /><br /></p>

<p>Although <?php echo($site_name); ?> does not claim ownership of content that its users post,
by posting Content to any public area of the Service, you automatically
grant, and you represent and warrant that you have the right to grant, to
<?php echo($site_name); ?> an irrevocable, perpetual, non-exclusive, fully paid, worldwide
license to use, copy, perform, display, and distribute said Content and to
prepare derivative works of, or incorporate into other works, said Content,
and to grant and authorize sublicenses (through multiple tiers) of the
foregoing. Furthermore, by posting Content to any public area of the Service,
you automatically grant us all rights necessary to prohibit any
subsequent aggregation, display, copying, duplication, reproduction, or
exploitation of the Content on the Service by any party for any purpose.<br /><br /></p>


<h3>[-] DISCLAIMER OF WARRANTIES</h3>
<p style="text-transform:uppercase">
YOU AGREE THAT USE OF THE <?php echo($site_name); ?> SITE AND THE SERVICE IS ENTIRELY AT
YOUR OWN RISK. OUR WEBSITE AND THE SERVICE ARE PROVIDED ON AN "AS
IS" OR "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND.  ALL
EXPRESS AND IMPLIED WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND
NON-INFRINGEMENT OF PROPRIETARY RIGHTS ARE EXPRESSLY DISCLAIMED TO THE
FULLEST EXTENT PERMITTED BY LAW.  TO THE FULLEST EXTENT PERMITTED BY LAW,
<?php echo($site_name); ?> DISCLAIMS ANY WARRANTIES FOR THE SECURITY, RELIABILITY,
TIMELINESS, ACCURACY, AND PERFORMANCE OF OUR WEBSITE AND THE
SERVICE. TO THE FULLEST EXTENT PERMITTED BY LAW, WE DISCLAIMS ANY
WARRANTIES FOR OTHER SERVICES OR GOODS RECEIVED THROUGH OR ADVERTISED ON OUR SITE
OR THE SITES OR SERVICE, OR ACCESSED THROUGH ANY LINKS ON
<?php echo($site_name); ?> SITE.  TO THE FULLEST EXTENT PERMITTED BY LAW, <?php echo($site_name); ?>
DISCLAIMS ANY WARRANTIES FOR VIRUSES OR OTHER HARMFUL COMPONENTS IN
CONNECTION WITH OUR SITE OR THE SERVICE.</p><p>Some jurisdictions do
not allow the disclaimer of implied warranties.  In such jurisdictions, some
of the foregoing disclaimers may not apply to you insofar as they relate to
implied warranties.<br /><br />
</p>

<h3>[-] LIMITATIONS OF LIABILITY</h3>
<p style="text-transform:uppercase">
UNDER NO CIRCUMSTANCES SHALL <?php echo($site_name); ?> BE LIABLE FOR DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES (EVEN IF <?php echo($site_name); ?>
HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES), RESULTING FROM ANY
ASPECT OF YOUR USE OF OUR SITE OR THE SERVICE, WHETHER THE
DAMAGES ARISE FROM USE OR MISUSE OF THE <?php echo($site_name); ?> OR THE SERVICE, FROM
INABILITY TO USE OUR SITE OR THE SERVICE, OR THE INTERRUPTION,
SUSPENSION, MODIFICATION, ALTERATION, OR TERMINATION OF OUR WEBSITE
OR THE SERVICE.  SUCH LIMITATION SHALL ALSO APPLY WITH RESPECT TO DAMAGES
INCURRED BY REASON OF OTHER SERVICES OR PRODUCTS RECEIVED THROUGH OR
ADVERTISED IN CONNECTION WITH <?php echo($site_name); ?> OR THE SERVICE OR ANY
LINKS ON THE OUR WEBSITE, AS WELL AS BY REASON OF ANY INFORMATION OR
ADVICE RECEIVED THROUGH OR ADVERTISED IN CONNECTION WITH <?php echo($site_name); ?>
OR THE SERVICE OR ANY LINKS ON OUR WEBSITE.  THESE LIMITATIONS SHALL
APPLY TO THE FULLEST EXTENT PERMITTED BY LAW.</p><p>In some jurisdictions,
limitations of liability are not permitted.  In such jurisdictions, some of
the foregoing limitation may not apply to you.
</p>

<h3>[-] INDEMNITY</h3>
<p>
You agree to indemnify and hold <?php echo($site_name); ?>, its officers, subsidiaries,
affiliates, successors, assigns, directors, officers, agents, service
providers, suppliers and employees, harmless from any claim or demand,
including reasonable attorney fees and court costs, made by any third party
due to or arising out of Content you submit, post or make available through
the Service, your use of the Service, your violation of the TOU, your
breach of any of the representations and warranties herein, or your
violation of any rights of another.<br /><br />
                                               </p>

<h3>[-] GENERAL INFORMATION</h3>

<p>The TOU constitute the entire agreement between you and <?php echo($site_name); ?> and
govern your use of the Service, superceding any prior agreements between you
and <?php echo($site_name); ?>. The TOU and the relationship between you and <?php echo($site_name); ?>
shall be governed by the laws without regard to
its conflict of law provisions. You agree that regardless of any statute or law to
the contrary, any claim or cause of action arising out of or related to use
of the Service or the TOU must be filed within one (1) year after such
claim or cause of action arose or be forever barred.<br /><br /></p>


<h3>[-] VIOLATION OF TERMS AND LIQUIDATED DAMAGES</h3>
<p>
Please report any violations of the TOU, by flagging the posting(s) for
review, or by emailing to:<br /><br />

<a href="mailto:<?php echo($site_email); ?>" target="_blank"><?php echo($site_email); ?></a><br /></p>

<p>Our failure to act with respect to a breach by you or others does not waive our
right to act with respect to subsequent or similar breaches.<br /></p>

<p>You understand and agree that, because damages are often difficult to quantify,
if it becomes necessary for <?php echo($site_name); ?> to pursue legal action to enforce these
Terms, you will be liable to pay us the following amounts as liquidated
damages, which you accept as reasonable estimates of <?php echo($site_name); ?>' damages for
the specified breaches of these Terms:<br /></p>

<p>a. If you post a message that (1) impersonates any person or entity; (2)
falsely states or otherwise misrepresents your affiliation with a person or
entity; or (3) that includes personal or identifying information about
another person without that person's explicit consent, you agree to pay
fine according to <?php echo($site_name); ?>'s representatives for each such message.
This provision does not apply to Content that constitutes lawful non-deceptive
parody of public figures.<br /><br />

b. If <?php echo($site_name); ?> establishes limits on the frequency with which you may
access the Service, or terminates your access to or use of the Service, you
agree to pay <?php echo($site_name); ?> the appropriate fine for each message posted
in excess of such limits or for each day on which you access the classifieds site in
excess of such limits, whichever is higher.<br /><br />

c. If you send unsolicited email advertisements to <?php echo($site_name); ?> email
addresses or through <?php echo($site_name); ?> computer systems, you agree to pay
the required fine set by <?php echo($site_name); ?> for each such email.<br /><br />

d. If you post Content in violation of the TOU, other than as described
above, you agree to pay <?php echo($site_name); ?> the amount asked to immediately for each
Item of Content posted.  In its sole discretion, we may elect
to issue a warning before assessing damages.<br /><br />

e.<?php if ($pt_data[14] == 'no') { echo (''); } else { ?> If you are a Posting Agent that uses the Service in violation of the
TOU, in addition to any liquidated damages under clause (d), you agree to
pay <?php echo($site_name); ?> fine for each and every Item you post
in violation of the TOU.  A Posting Agent will also be deemed an agent of
the party engaging the Posting Agent to access the Service (the
"Principal"), and the Principal (by engaging the Posting Agent in
violation of the TOU) agrees to pay <?php echo($site_name); ?> an additional
penalty for each Item posted by the Posting Agent on behalf of
the Principal in violation of the TOU.<br /><br />

f.<?php } ?> If you aggregate, display, copy, duplicate, reproduce, or otherwise
exploit for any purpose any Content (except for your own Content) in
violation of these Terms without <?php echo($site_name); ?>'s express written permission,
you agree to pay asked penalty fine for each day
on which you engage in such conduct.<br />
</p><p>
Otherwise, you agree to pay <?php echo($site_name); ?>'s actual damages, to the extent such
actual damages can be reasonably calculated. Notwithstanding any other
provision of these Terms, <?php echo($site_name); ?> retains the right to seek the remedy
of specific performance of any term contained in these Terms, or a preliminary
or permanent injunction against the breach of any such term or in aid of the
exercise of any power granted in these Terms, or any combination thereof.</p>