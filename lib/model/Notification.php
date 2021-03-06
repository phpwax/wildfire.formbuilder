<?
class Notification extends WaxEmail{


  public function submission($data, $to, $from, $subject=false, $dev_emails=array()){
    if(!$subject) $subject="Notification of form submission";
    $this->from = $from;
    $all = explode(",", str_replace(";", ",", $to));
    $this->add_to_address(array_shift($all));
    foreach($all as $em) $this->add_cc_address($em);
    $this->data = $data;
    $this->subject = $subject;
    foreach($dev_emails as $em) $this->add_bcc_address($em);
  }

}
?>
