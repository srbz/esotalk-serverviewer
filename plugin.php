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

class ETPlugin_ServerViewer extends ETPlugin
{
    public function __construct($rootDirectory)
    {
        parent::__construct($rootDirectory);
        ETFactory::registerController("serverviewer", "ServerViewerController", dirname(__FILE__)."/ServerViewerController.class.php");
        ETFactory::register("serverviewerModel", "ServerViewerModel", dirname(__FILE__)."/ServerViewerModel.class.php");
        ETFactory::registerAdminController("serverviewer", "ServerViewerAdminController", dirname(__FILE__)."/admin/ServerViewerAdminController.class.php");
        ETFactory::register("serverviewerAdminModel", "ServerViewerAdminModel", dirname(__FILE__)."/admin/ServerViewerAdminModel.class.php");
    }
    public function handler_renderBefore($sender)
    {
    	$sender->addCSSFile($this->resource("serverTables.css"));
    }
    public function handler_init($sender)
    {
        //adds the route to transaction controller in the top navigation menu
        //there must be a way with a handler...dont know it yet...
        if(ET::$session->userId){
            $sender->addToMenu("user", "serverviewer", "<a href='".URL("serverviewer")."'>".T("Server")."</a>", 1);
        }
    }
    public function handler_initAdmin($sender, $menu)
    {
        //adds the admin menu for administration of transactions
        $menu->add("serverviewer", "<a href='".URL("admin/serverviewer")."'><i class='icon-pencil'></i> ".T("Server")."</a>");
    }

    public function setup($oldVersion = "")
    {
            $structure = ET::$database->structure();

            if(!$structure->table("eso_serverviewer")->exists())
            {
                //serverviewer structure
                $structure->table("serverviewer")
                //internal id to use as primary key
                    ->column("id", "int(11) unsigned", false)
                    ->key("id", "primary")
                    ->column("serverId", "varchar(140)", false)
                    /*
                    *    + acutally i have an idea which i'm not sure about yet:
                    *        - type is saved inside gameQs games.ini
                    *        - its only possible to choose gametypes from there
                    *    + my idea covers to parse this file (games.ini) into a seperate database, to
                    *        refer as an int(11) unsiged id as foreign key which is the primary key in
                    *        the games.ini table
                    *    pro: database normalization and easy to built a menu which auto-completes with the db
                    *    con: a newer version of gameQ requires an update and reparsing the file instead of
                    *        having an omniscent user (hue hue)
                    *    handling the contra issue could be done by an hash of the games.ini which
                    *    gets compared to something saved (whereever, in a data, or in a meta-table or so)
                    *    if the file has changes the files gets reparsed and all the entries in the table
                    *    get updates or replaced.
                    *
                    *    future plans for conquering the world.
                    */
                    ->column("type", "varchar(140)", false)
                    ->column("host", "varchar(140)", false)
                    ->exec(false);
                return true;
            }
    }
    public function disable()
    {
        //maybe i'll do something in the future
        return true;
    }
    public function uninstall()
    {
        $structure = ET::$database->structure();
        $structure->table("eso_serverviewer")->drop();
        return true;
    }
}
