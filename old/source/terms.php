<?php
include("includes/connection.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
</head>

<body <?php if(!isset($_SESSION['user'])) {?>style="background:#fff url(images/bg.jpg) left top repeat-x;"<?php } ?>>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="205" align="left" valign="top">
	<? include("page_includes/header.php")?>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  align="left" valign="top"><? include("page_includes/slide.php")?></td>
      </tr>
       <?php if(!isset($_SESSION['user'])) {?>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
	  <?php }?>
      <tr>
        <td align="left" valign="top">
		<? include("page_includes/banners.php") ?>
		</td>
      </tr>
       <?php if(!isset($_SESSION['user'])) {?>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
	  <?php }?>
      <tr>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Terms</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
					<?=$obj->putContent(3)?>
					<!--<div class="package-content">
					  <p><strong>TWINKLE  STAR DANCE&trade; TERMS AND CONDITIONS</strong> <br />
                          <br />
					    Effective January 1, 2012 <br />
					    Updated February 7, 2012<br />
					    This document (the &quot;Agreement&quot;) is a legal contract between you and  Twinkle Star Dance&trade; (&quot;Twinkle Star Dance&trade;&quot;) that governs your use of  Twinkle Star Dance&trade;'s online services available at  http://www.twinklestardance.com (the &quot;Service&quot;) whereby you will be  granted the ability to view and download various compositions (the  &quot;(Legacy) Audio Performance Downloads&quot;) as performed by specific  artists.<br />
  <br />
					    <strong>NOTICE </strong><br />
					    Twinkle Star Dance&trade; may from time to time modify these terms and will post a  copy of the amended Agreement at <a href="http://www.twinklestardance.com/terms/">http://www.twinklestardance.com/terms/</a>. If you  do not agree to (or cannot comply with) the Agreement as amended, your only  remedy is to stop using the Service. You will be deemed to have accepted the  Agreement as amended if you continue to use the Service after any amendments  are posted. <br />
  <br />
  <br />
					    <strong>AGE REQUIREMENT</strong> <br />
					    You must be at least 18 years of age to agree to and enter into this Agreement  on your own behalf and to register for use of the Service. If you are under 18  but at least 13 years of age, you must present this Agreement to your parent or  legal guardian, and he or she must check the box below to enter into this  Agreement on your behalf. Children under the age of 13 may not register for  this Service, and parents or legal guardians may not register on their behalf.  By checking the box indicating your acceptance to this Agreement, you represent  that (i) you have read, understood and agree to be bound by this Agreement and  (ii) you are at least 18 years old, either entering into this Agreement for  yourself or entering on behalf of your child or a child in your legal care. If  you are a parent or guardian entering this Agreement for the benefit of your  child, please be aware that you are fully responsible for his or her use of the  Service, including all financial charges and legal liability that he or she may  incur. If you do not agree to (or cannot comply with) any of these terms and  conditions, do not check the acceptance box and do not attempt to access the  Service. <br />
  <br />
					    <strong>REGISTRATION </strong><br />
					    To use the Service, you must register and provide certain information,  including a member (user) name, a password and a valid email address  (&quot;Registration Data&quot;). You agree to provide accurate Registration  Data and to update your Registration Data as necessary to keep it accurate. <br />
					    You agree that you will not allow others to use your member name, password  and/or account and you are solely responsible for maintaining the  confidentiality and security of your account. You agree to notify Twinkle Star  Dance&trade; immediately of any unauthorized use of your account. Twinkle Star Dance&trade;  shall not be responsible for any losses arising out of the unauthorized use of  your member name, password and/or account and you agree to indemnify and hold  harmless Twinkle Star Dance&trade;, its partners, parents, subsidiaries, agents,  affiliates and/or licensors, as applicable, for any improper, unauthorized or  illegal uses of the same. <br />
  <br />
					    <strong>USE OF WEBCAST VIDEO STREAM</strong><br />
					    The recordings of the streaming video contained on this site are owned by  Twinkle Star Dance&trade;, its business partners, affiliates and/or licensors, as  applicable, and are protected by intellectual property laws. You agree that the  content rights holders that license the stream or other content to Twinkle Star  Dance&trade; for use in the Service are intended third-party beneficiaries under this  Agreement with the right to enforce the provisions that directly concern their  content. You understand that your use of the stream is subject to the Usage  Rules discussed below. You may not authorize, encourage or allow any stream  used or obtained by you to be reproduced, modified, displayed, performed,  transferred, distributed or otherwise used by anyone else. You agree to advise  Twinkle Star Dance&trade; promptly of any such unauthorized use(s). <br />
					    Usage Rules. Your access to and/or use of the video stream will be limited by  the rules described in this section. You may not attempt (or support others'  attempts) to circumvent, reverse engineer, decrypt, or otherwise alter or  interfere with any Usage Rules or the stream. Twinkle Star Dance&trade; reserves the  rights to modify the Usage Rules at any time. <br />
  <br />
  <br />
					    <strong>USE OF AUDIO/VIDEO PEFORMANCE DOWNLOADS</strong> <br />
					    The recordings of the Audio Performance Downloads (APDs) and Video Performance  Downloads (VPDs) contained on this site are owned by Twinkle Star Dance&trade;, its  business partners, affiliates and/or licensors, as applicable, and are  protected by intellectual property laws. You agree that the content rights  holders that license these downloads or other content to Twinkle Star Dance&trade;  for use in the Service are intended third-party beneficiaries under this  Agreement with the right to enforce the provisions that directly concern their  content. You understand that your use of the downloads is subject to the Usage  Rules discussed below. You may not authorize, encourage or allow any downloads  used or obtained by you to be reproduced, modified, displayed, performed,  transferred, distributed or otherwise used by anyone else. You agree to advise  Twinkle Star Dance&trade; promptly of any such unauthorized use(s). <br />
					    Usage Rules. Your access to and/or use of any downloads will be limited by the  rules assigned to the downloads by Twinkle Star Dance&trade; (&quot;Usage  Rules&quot;) and described in this section. You may not attempt (or support  others' attempts) to circumvent, reverse engineer, decrypt, or otherwise alter  or interfere with any Usage Rules or downloads. Twinkle Star Dance&trade; reserves  the rights to modify the Usage Rules at any time. <br />
					    A &quot;Purchased Download&quot; is an Download that you may (1) download as  many times within a 48 hour period from your purchase date (2) save to the hard  drives of up to three of your personal computers and play back at any time, (3)  burn to a CD five times and/or (4) transfer to a compatible portable device  unlimited times and (5) will not be able to re-download any download six months  after the date of purchase. Any security technology that is provided with a  download is an inseparable part of it. If you have Purchased downloads, it is  your responsibility not to lose, destroy or damage them. Twinkle Star Dance&trade;  shall have no liability to you in the event of any such loss, destruction, or  damage. You may purchase downloads on an individual basis.<br />
					    You may transfer a Purchased download an unlimited number of times to portable  devices that are compatible with the Service's Usage Rules and security  requirements. Once you have transferred a Purchased download to a compatible  portable device, you agree not to copy, distribute, or transfer it from that  device to any other media or device.<br />
  <br />
  <br />
					    A &quot;Stream&quot; is a performance that you play directly from and while you  are logged on to the Service. You may play as many Streams as you like while  your subscription is current. You may not attempt (or encourage others) to  capture, copy, or download a streamed Song or Video. Twinkle Star Dance&trade; will  count the number of times that you stream each Song for royalty accounting and  analysis purposes. <br />
					    The burning or transfer capabilities provided for herein shall not operate to  waive or limit any rights of the copyright owners in downloads or any works  embodied in them. <br />
					    All rights not expressly granted to you in this Agreement are reserved to  Twinkle Star Dance&trade; and/or its licensors. <br />
					    Loss of Rights by Twinkle Star Dance&trade;. Twinkle Star Dance&trade; may at any time lose  the right to make certain downloads available. In such event, you will no  longer be able to obtain these downloads.<br />
					    Delivery of Products. On occasion, technical problems may delay or prevent  delivery of Purchased downloads to you. Your sole remedy with respect to  Purchased downloads that are not delivered will be either replacement of such  products or refund of the price paid for such content, at Twinkle Star Dance&trade;'s  discretion. <br />
					    Customer Support. Please direct any questions concerning the Client, the  Service, billing and/or Usage Rules to <a href="mailto:support@twinklestardance.com">support@twinklestardance.com</a>. <br />
  <br />
  <br />
					    <strong>CHARGES / BILLING </strong><br />
					    Agreement to Pay. You agree to pay for all downloads or Subscriptions that you  purchase through the Service and Twinkle Star Dance&trade; may charge your credit  card for any such payment(s). Twinkle Star Dance&trade; may, in its discretion, post  charges to your credit card individually or may aggregate your charges with  other purchases you make on the Service. You are responsible for keeping your  account secure and confidential and you will be responsible for any charges  that are incurred by any person through your account. All charges will be  billed to the credit card you designate when you first make a purchase or incur  a charge. If any of your billing information changes, you must update that  information by emailing <a href="mailto:support@twinklestardance.com">support@twinklestardance.com</a>. All sales are final. <br />
  <br />
					    Right to  Change Prices. All prices for products within the Service are subject to change  by Twinkle Star Dance&trade; at any time. <br />
  <br />
					    Taxes.  Prices quoted are generally inclusive of any applicable taxes, including sales  taxes. Twinkle Star Dance&trade; reserves the right to change this policy at any  time. <br />
  <br />
					    Electronic  Contracts. You agree that any submissions you make for electronic purchases  constitute your intent and agreement to be bound by the terms of and to pay for  such purchases. To the extent that such electronic purchases are offered to you  by a third party, you acknowledge that Twinkle Star Dance&trade; shall not be  responsible or liable to you for the products or services purchased. <br />
  <br />
					    <strong>PRIVACY</strong> <br />
  <strong>This is the Privacy Policy for Twinkle Star Dance&trade;.</strong> <br />
  <strong>Our Contact Information is:</strong><br />
					    Twinkle Star Dance <br />
					    4046 East Avenue<br />
					    Livermore,  CA 94550<br />
					    (925)  447-5299<br />
  <a href="mailto:support@twinklestardance.com">support@twinklestardance.com</a> <br />
					    We  collect no information about our visitor's domain, but we do collect  information about our visitor's email address when available.<br />
  <strong>For visitors on our website we collect:</strong> </p>
					  <ul type="disc">
                        <li>The email address and personal information from the       visitors who communicate with us via email.</li>
					    <li>Aggregate (General Tracking) information about pages       that users visit on our site.</li>
					    <li>User specific information about pages that users       visit on our site.</li>
					    <li>Any information given to us by users that contact us       via inquiry form, survey, etc.</li>
					    </ul>
					  <p><strong>The information that we collect is used  for:</strong> </p>
					  <ul type="disc">
                        <li>Delivering custom content to our website visitors.</li>
					    <li>Improving the quality of our website content and user       friendliness for a better user experience.</li>
					    <li>Contact information for marketing purposes, including       newsletters, emails or periodic advertisements from our company.</li>
					    </ul>
					  <p><strong>We may use a standard technology called a  cookie for the following purposes.</strong> </p>
					  <ul type="disc">
                        <li>Recording Session information for shopping cart or       other purposes.</li>
					    <li>Store visitor preferences for return visits to our       website.</li>
					    <li>Helping to manage subscription or private areas on       our website.</li>
					    <li>Record user specific tracking or aggregate tracking       information of visitors on our website.</li>
					    <li>Delivering user customized content based on user       specific information, such as browser type, screen type or resolution,       etc.</li>
					    <li>Alert visitors to our live help console, or offering       live help to website visitors.</li>
					    </ul>
					  <p>If  you are currently receiving a newsletter or emails from us and would like to  stop receiving them, please notify us by contacting us by email, phone, mail,  at the above address.<br />
					    We  do not partner or use any 3rd party ad services or content delivering services.<br />
					    With  respect to security, we use industry standard encryption technologies, when  transferring and receiving data from visitors on our website.<br />
					    With  respect to sensitive information, we will redirect the user to a secure page  either on our site, or to a trusted 3rd party site before transferring or  receiving sensitive data. This information may include credit card or banking  information, medical information, or other sensitive information.<br />
					    For  questions regarding our privacy policy or website in general, please contact  by; phone, mail, email, listed above.</p>
					  <br />
                      <br />
                      <strong>COPYRIGHT INFORMATION</strong><br />
General. As noted above the Service and the Songs contain and/or comprise  copyrighted or other proprietary subject matter, and your use of them is  governed by this Agreement, certain end-user license agreements, and applicable  law. <br />
Notices. Twinkle Star Dance&trade; respects the intellectual property rights of  others, and it expects you to do the same. If you know of or suspect that any  use of the Service and/or downloads constitutes copyright infringement, please  send a notice by email to <a href="mailto:support@twinklestardance.com">support@twinklestardance.com</a>. <br />
<br />
<strong>PATENT AND TRADEMARK</strong> <br />
All trademarks, service marks, trade names, slogans, logos, and other indicia  of origin that appear on or in connection with the Service are the property of  Twinkle Star Dance&trade; and/or its affiliates, licensors and/or licensees. You may  not copy, display or use any of these marks without prior written permission of  the mark owner. The Service and the Client (and portions of them) may be  protected under patent law and may be the subject of issued patents and/or  pending patent applications. <br />
<br />
<strong>VIOLATION OF INTELLECTUAL PROPERTY RIGHTS</strong> <br />
If Twinkle Star Dance&trade; receives a notice alleging that you have engaged in  behavior that infringes Twinkle Star Dance&trade;'s or other's intellectual property  rights or reasonably suspects the same, Twinkle Star Dance&trade; may suspend or  terminate your account without notice to you. If Twinkle Star Dance&trade; suspends  or terminates your account under this paragraph, it shall have no liability or  responsibility to you, including for any amounts that you have previously paid. <br />
<br />
<strong>REMEDIES </strong><br />
You agree that any unauthorized use of the Service, the Songs, or any related  software or materials would result in irreparable injury to Twinkle Star Dance&trade;  and/or its affiliates or licensors for which money damages would be inadequate,  and in such event Twinkle Star Dance&trade;, its affiliates and/or licensors, as  applicable, shall have the right, in addition to other remedies available at  law and in equity, to immediate injunctive relief against you. Nothing  contained in this Agreement shall be construed to limit remedies available  pursuant to statutory or other claims that Twinkle Star Dance&trade;, its affiliates  and/or licensors may have under separate legal authority. <br />
<br />
<strong>INDEMNITY</strong> <br />
You agree to indemnify and hold harmless Twinkle Star Dance&trade; and its agents,  employees, representatives, licensors, affiliates, parents and subsidiaries  from and against any and all claims, losses, demands, causes of action and  judgments (including attorneys' fees and court costs) arising from or  concerning your breach of this Agreement and your use of the Service or the  Songs and to reimburse them on demand for any losses, costs or expenses they  incur as a result thereof. <br />
<br />
<strong>TERMINATION </strong><br />
Twinkle Star Dance&trade; may in its sole discretion terminate this Agreement or  suspend your account at any time without notice to you in the event that you  breach (or Twinkle Star Dance&trade; reasonably suspects that you have breached) any  provision of this Agreement. If Twinkle Star Dance&trade; terminates this Agreement,  or suspends your account for any of the reasons set forth in this paragraph, it  shall have no liability or responsibility to you, and Twinkle Star Dance&trade; will  not refund any amounts that you have previously paid. <br />
You understand and agree that your cancellation of your account and Service  membership is your sole right and remedy with respect to any dispute with  Twinkle Star Dance&trade;. <br />
<br />
<strong>DISCLAIMERS</strong> <br />
You understand and agree that your use of the Service and downloads is at your  own sole risk. THE SERVICE AND DOWNLOADS (THE &quot;PRODUCTS&quot;) ARE  PROVIDED &quot;AS IS&quot; AND WITHOUT WARRANTY BY Twinkle Star Dance&trade; OR ITS  AGENTS, EMPLOYEES, PARENTS, SUBSIDIARIES, AFFILIATES, LICENSORS, BUSINESS  PARTNERS AND/OR SUPPLIERS (THE &quot;Twinkle Star Dance&trade; ENTITIES&quot;), AS  APPLICABLE, AND, TO THE MAXIMUM EXTENT ALLOWED BY APPLICABLE LAW, THE Twinkle  Star Dance&trade; ENTITIES EXPRESSLY DISCLAIM ALL WARRANTIES, EXPRESS OR IMPLIED  INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND  FITNESS FOR A PARTICULAR PURPOSE AND ANY WARRANTY OF NONINFRINGEMENT. THE  Twinkle Star Dance&trade; ENTITIES DO NOT WARRANT, GUARANTEE, OR MAKE ANY  REPRESENTATIONS REGARDING THE USE OR THE RESULTS OF THE USE OF THE PRODUCTS  WITH RESPECT TO PERFORMANCE, ACCURACY, RELIABILITY, SECURITY CAPABILITY OR OTHERWISE.  YOU WILL NOT HOLD ANY Twinkle Star Dance&trade; ENTITY RESPONSIBLE FOR ANY DAMAGES  THAT RESULT FROM YOU ACCESSING (INCLUDING ANY SOFTWARE OR SYSTEMS YOU USE TO  ACCESS) THE SERVICE OR USING THE PRODUCTS INCLUDING, BUT NOT LIMITED TO, DAMAGE  TO ANY COMPUTER, SOFTWARE OR SYSTEMS OR PORTABLE DEVICES YOU USE TO ACCESS THE  SAME . NO ORAL OR WRITTEN INFORMATION OR ADVICE GIVEN BY ANY PERSON SHALL  CREATE A WARRANTY IN ANY WAY WHATSOEVER RELATING TO ANY OF THE Twinkle Star  Dance&trade; ENTITIES. <br />
<br />
Twinkle Star Dance&trade; MAKES NO WARRANTY THAT ANY PARTICULAR CD BURNER OR PORTABLE  DEVICE WILL BE COMPATIBLE WITH THE SERVICE OR THAT ANY CD BURNED WILL FUNCTION  IN ALL CD PLAYERS. IT IS YOUR SOLE RESPONSIBILITY TO ENSURE THAT YOUR SYSTEM(S)  WILL FUNCTION CORRECTLY WITH THE SERVICE. <br />
UNDER NO CIRCUMSTANCES SHALL ANY Twinkle Star Dance&trade; ENTITY BE LIABLE FOR ANY  UNAUTHORIZED USE OF THE SERVICE OR DOWNLOADS. <br />
UNDER NO CIRCUMSTANCES SHALL ANY Twinkle Star Dance&trade; ENTITY BE LIABLE TO YOU  FOR ANY CONSEQUENTIAL, INCIDENTAL OR SPECIAL DAMAGES (INCLUDING DAMAGES FOR  LOSS OF BUSINESS PROFITS, BUSINESS INTERRUPTION, LOSS OF BUSINESS INFORMATION,  AND THE LIKE) ARISING OUT OF THE USE OR INABILITY TO USE THE PRODUCTS, EVEN IF  THE Twinkle Star Dance&trade; ENTITY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH  DAMAGES. TO THE EXTENT THAT IN A PARTICULAR CIRCUMSTANCE ANY DISCLAIMER OR  LIMITATION ON DAMAGES OR LIABILITY SET FORTH HEREIN IS PROHIBITED BY APPLICABLE  LAW, THEN, INSTEAD OF THE PROVISIONS HEREOF IN SUCH PARTICULAR CIRCUMSTANCE,  THE Twinkle Star Dance&trade; ENTITIES SHALL BE ENTITLED TO THE MAXIMUM DISCLAIMERS  AND/OR LIMITATIONS ON DAMAGES AND LIABILITY AVAILABLE AT LAW OR IN EQUITY BY  SUCH APPLICABLE LAW IN SUCH PARTICULAR CIRCUMSTANCE, AND IN NO EVENT SHALL SUCH  DAMAGES OR LIABILITY EXCEED US $10. <br />
<br />
<strong>LAW AND LEGAL NOTICES </strong><br />
This Agreement and any other terms or documents referred to herein represent  your entire agreement with Twinkle Star Dance&trade; with respect to your use of the  Service. If any part of this Agreement is held invalid or unenforceable, that portion  shall be construed in a manner consistent with applicable law to reflect, as  nearly as possible, the original intentions of the parties, and the remaining  portions shall remain in full force and effect. The laws of the State of  Illinois, excluding its conflicts of law rules, govern this Agreement and your  use of the Service and the Songs. You expressly agree that the courts in the  State of Illinois, County, have exclusive jurisdiction over any claim or  dispute with Twinkle Star Dance&trade; or relating in any way to your account or your  use of the Service and the Songs. You further agree and expressly consent to  personal jurisdiction over you in the federal and state courts in County in  connection with any such dispute including any claim involving Twinkle Star  Dance&trade; or its partners, parents, licensors, affiliates, subsidiaries,  employees, contractors, officers, directors or suppliers.</div>-->
				</td>
              </tr>
            </table>
			</td>
            <td width="7" align="left" valign="top">&nbsp;</td>
            <td width="240" align="left" valign="top"><? include("page_includes/right.php")?></td>
          </tr>
        </table>
		</td>
      </tr>
             <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
    </table>
	
	</td>
  </tr>
  <tr>
    <td height="80" align="left" valign="top" class="footer">
	<?php include("page_includes/footer.php"); ?>
	</td>
  </tr>
</table>
</body>
</html>
