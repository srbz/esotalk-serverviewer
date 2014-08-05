<?php
//copyright 2014 at sexygaming.de

ET::$pluginInfo["ServerViewer"] = array(
    "name"        => "ServerViewer",
    "description" => "A plugin to serverviews for a community",
    "version"     => "1.0",
    "author"      => "Sallar Ahmadi-Pour",
    "authorEmail" => "sallar.ahmadipour@gmail.com",
    "authorURL"   => "http://sexygaming.de",
    //fancy
    "license"     => "CC BY-NC-SA 4.0",
    "dependencies" => array(
        "esoTalk"       => "1.0.0g4"
    )
);

class ETPlugin_ClanCash extends ETPlugin
{
    public function __construct($rootDirectory)
    {
        parent::__construct($rootDirectory);
        //TODO does this work? correctly for admincontroller?
        // ETFactory::register("transactionModel", "TransactionModel", dirname(__FILE__)."/TransactionModel.class.php");
        // ETFactory::registerController("transaction", "TransactionController", dirname(__FILE__)."/TransactionController.class.php");
    }
    public function handler_init($sender)
    {
        //adds the route to transaction controller in the top navigation menu
        //there must be a way with a handler...dont know it yet...
        if(ET::$session->userId){
            $sender->addToMenu("user", "transaction", "<a href='".URL("serverViewer")."'>".T("Server")."</a>", 1);
        }
    }
    public function handler_initAdmin($sender, $menu)
    {
        //adds the admin menu for administration of transactions
        $menu->add("transaction", "<a href='".URL("admin/serverViewer")."'><i class='icon-pencil'></i> ".T("Server")."</a>");
    }

    public function setup($oldVersion = "")
    {
        return true;
    }
    public function disable()
    {
        //maybe i'll do something in the future
        return true;
    }
    //function will drop the database when being uninstalled
    public function uninstall()
    {
        return true;
    }
}
