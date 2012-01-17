<?
class Notification extends WaxEmail{


  public function submission($data, $to, $subject="Notification of form submission", $dev_emails=array()){
    $this->add_to_address($to);
    $this->data = $data;
    $this->subject = $subject;
    foreach($dev_emails as $em) $this->add_bcc_address($em);
  }

}
?>