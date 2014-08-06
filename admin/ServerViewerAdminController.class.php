<?php

if(!defined("IN_ESOTALK")) exit;

class ServerViewerAdminController extends ETAdminController
{
    public function action_index()
    {
        //we need more permissions for this
        if (!$this->allowed()) return;
        $model = ETFactory::make("serverviewerAdminModel");
        $res = $model->getServers();
        $this->data("servers", $res);
        $this->render("admin/ServerViewerAdminIndexView");
    }
    public function action_add()
    {
        //we need those permissions...
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $form->action = URL("admin/serverviewer/save/");
        $this->data("form", $form);
        $this->render("admin/ServerViewerAdminAddView");
    }
    public function action_del($id)
    {
        if (!$this->allowed()) return;
        $transModel = ETFactory::make("serverviewerAdminModel");
        //delete it... without asking
        $transModel->deleteById($id);
        //back to administration -- maybe there is more to delete hue
        redirect(URL("admin/serverviewer"));
    }
    public function action_edit($id)
    {
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $model = ETFactory::make("serverviewerAdminModel");
        //build the form
        $form->action = URL("admin/serverviewer/save/".$id);
        $entry = $model->getById($id);
        if($entry != null)
        {
            $form->setValues($entry);
            $this->data("form", $form);
            $this->data("srvs", $entry);
            $this->render("admin/ServerViewerAdminEditView");
        }
        else
        {
            redirect(URL("admin/serverviewer"));
        }
    }
    public function action_save($id = false)
    {
        if (!$this->allowed()) return;
        $form = ETFactory::make("form");
        $model = ETFactory::make("serverviewerAdminModel");
        //if we want to add a new entry
        //TODO use the pattern of esoTalk and use models for this -- not necessery at the moment
        if($id == false){
            $formData = $form->getValues();
            //somehow we have to ensure that the value at least is a number between -infty to +infty as double
            $formData = $model->cleanFormData($formData);
            //memberId is the SQL field for the table in DB
            if($res = $model->addTransaction($formData))
            {
                redirect(URL("admin/serverviewer"));
            }
            redirect(URL("admin/serverviewer"));
        }
        else
        {
            if($form->validPostBack("save"))
            {
                //seems like someone wants to save an edit ... fine.
                $formData = $form->getValues();
                //somehow we have to ensure that the value at least is a number between -infty to +infty as double
                $newData = $model->cleanFormData($formData);
                //then you can update it...
                if($res = $model->editTransaction($id,$newData))
                {
                    //TODO we need a fancy success message!
                    redirect(URL("admin/serverviewer"));
                    //this->render("admin/TransactionAdminEditView");
                }
                redirect("admin/serverviewer");
            }
            if($form->validPostBack("cancel"))
            {
                //get him back
                redirect(URL("admin/serverviewer"));
            }
            else{
                //not sure if this is really needed, but i have the feeling it is.
                redirect(URL("admin/serverviewer"));
            }
        }
    }
}
