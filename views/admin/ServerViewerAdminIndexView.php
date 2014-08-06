<?php

if(!defined("IN_ESOTALK")) exit;
$srvs = $data['servers'];
// var_dump($srvs);
?>
<?php

if(!defined("IN_ESOTALK")) exit;
$srvs = $data['servers'];
// var_dump($srvs);
?>
<div class='actions'>
    <ul class='menu'>
        <li><a class='button' href='serverviewer/add'>Add new server</a></li>
    </ul>
</div>
<div class='servers'>
    <table border='1' style="border-spacing: 0px;margin: 5px;padding: 0px;width: 100%;text-align: center;">
        <tr>
            <th>Id</th>
            <th>Server Id</th>
            <th>Type</th>
            <th>Host</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach($srvs as $entry)
        {
        ?>
        <tr>
            <td><?php echo $entry['id'] ?></td>
            <td><?php echo $entry['serverId'] ?></td>
            <td><?php echo $entry['type'] ?></td>
            <td><?php echo $entry['host'] ?></td>
            <td><a class="button" href="serverviewer/edit/<?php echo $entry['id'] ?>">Edit</a> <a class="button" href="serverviewer/del/<?php echo $entry['id'] ?>">Delete</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
