<?php
// this really needs a better formatting, I hate css so much...
if(!defined("IN_ESOTALK")) exit;
$form = $data['form'];
?>
<div class='servers'>
<!--  need some more form stuff todo -->
    <?php
        echo $form->open();
            //maybe a list with all users? -- maybe this gets to overloaded
            //maybe ajax list
            //TODO change this, really!
            //really really needs formatting -- because i hate css
        echo "<label>Server Id</label> ".$form->input("serverId", "text")."</br></br>";
        echo "<label>Type</label> ".$form->input("type", "text")."</br></br>";
        echo "<label>Host</label> ".$form->input("host", "text")."</br></br>";
        echo $form->button("save", "Add new Server")." ",
            $form->button("cancel", "Cancel operation"),
            $form->close();
    ?>
</div>
