<?php
/*
 * @version $Id: timeline_viewsubitem.php 23588 2015-07-10 11:09:46Z moyo $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2015 Teclib'.

 http://glpi-project.org

 based on GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2014 by the INDEPNET Development Team.
 
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
include ('../inc/includes.php');
header("Content-Type: text/html; charset=UTF-8");
Html::header_nocache();

Session::checkLoginUser();

if (!isset($_POST['type'])) {
   exit();
}
if (!isset($_POST['parenttype'])) {
   exit();
}

if (($item = getItemForItemtype($_POST['type']))
    && ($parent = getItemForItemtype($_POST['parenttype']))) {
   if (isset($_POST[$parent->getForeignKeyField()])
       && isset($_POST["id"])
       && $parent->getFromDB($_POST[$parent->getForeignKeyField()])) {
         Ticket::showSubForm($item, $_POST["id"], array('parent' => $parent, 
                                                                  'tickets_id' => $_POST["tickets_id"]));
   } else {
      _e('Access denied');
   }
} else if ($_POST['type'] == "Solution") {
   $ticket = new Ticket;
   $ticket->getFromDB($_POST["tickets_id"]);

   if (!isset($_REQUEST['load_kb_sol'])) {
      $_REQUEST['load_kb_sol'] = 0;
   }
   $ticket->showSolutionForm($_REQUEST['load_kb_sol']);
}
Html::ajaxFooter();
?>