<?php

if(!defined("IN_ESOTALK")) exit;
$srvs = $data['servers'];
// var_dump($srvs);
?>

<?php foreach($srvs as $entry){ ?>
    <div class="border content">
        <div class="container-1">
            <?php if($entry['gq_protocol'] === 'quake3'){ ?>
                <h2><a href="hlsw://<?php echo $entry['gq_address']?>:<?php echo $entry['gq_port']?>"><?php echo $entry['sv_hostname']?></a></h2>
                <div class="container-1 server">
                    <div class="container-1 serverInfos">
                        <img src="http://et.splatterladder.com/levelshots/et/<?php echo $entry['gq_mapname']?>.jpg" alt="" /><br/>
                        <p>
                            Map: <?php echo $entry['gq_mapname']?>
                        </p>
                        <p>
                            Online: <?php echo $entry['num_players']?> / <?php echo $entry['sv_maxclients']?>
                        </p>
                        <p>
                            <a href="hlsw://<?php echo $entry['gq_address']?>:<?php echo $entry['gq_port']?>">
                                Verbinden mit Server
                            </a>
                        </p>
                    </div>
                    <div class="container-1 serverPlayers">
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Punkte</th>
                                <th>Ping</th>
                            </tr>
                            <?php if($entry['num_players'] > 0){?>
                                <?php $i=0;
                                foreach($entry['players'] as $player){ ?>
                                    <tr class="
                                        <?php
                                        if($i % 2 == 0) echo "even";
                                        else
                                        {
                                            echo "odd";
                                        }
                                        ?>
                                    ">
                                        <td><?php echo $player['name']?></td>
                                        <td><?php echo $player['frags']?></td>
                                        <td>
                                            <?php
                                            if($player['ping']) echo $player['ping'];
                                            else
                                            {
                                                echo "BOT";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } unset($i);?>
                            <?php }else{ ?>
                                <tr>
                                    <td colspan="3"><h2>Niemand online.</h2></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div style="clear: both"></div>
                </div>
            <?php }elseif ($entry['gq_protocol'] === 'teamspeak3'){ ?>
                <h2><a href="ts3://<?php echo $entry['gq_address']?>:<?php echo $entry['virtualserver_port']?>"><?php echo $entry['virtualserver_name']?></a></h2>
                <div class="container-1 server">
                    <div class="container-1 serverInfos">
                        Online: <?php echo count($entry['players'])?> / <?php echo $entry['virtualserver_maxclients']?>
                        <br>
                        <p>
                            <a href="ts3://<?php echo $entry['gq_address']?>:<?php echo $entry['virtualserver_port']?>">
                                Verbinden mit Server
                            </a>
                        </p>
                    </div>
                    <div class="container-1 serverPlayers">
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Channel</th>
                            </tr>
                            <?php if(count($entry['players'])){?>
                                <?php $i=0;
                                foreach($entry['players'] as $player){
                                    foreach($entry['teams'] as $team){
                                        if( $team['cid'] == $player['cid']){
                                            ?>
                                            <tr class="
                                                <?php
                                                if($i % 2 == 0) echo "even";
                                                else
                                                {
                                                    echo "odd";
                                                }
                                                ?>
                                            ">
                                                <td>
                                                    <?php echo $player['client_nickname']?>
                                                </td>
                                                <td>
                                                    <?php echo $team['channel_name']?>
                                                </td>
                                            </tr>
                                        <?php $i++;}}} unset($i);?>
                            <?php }else{ ?>
                                <tr>
                                    <td colspan="3"><h2>Niemand online.</h2></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div style="clear: both"></div>
                </div>
            <?php }elseif ($entry['gq_protocol'] === 'gamespy3' and $entry['game_id'] === 'MINECRAFT'){ ?>
                <h2><?php echo $entry['gq_hostname']?></h2>
                <div class="container-1 server">
                    <div class="container-1 serverInfos">
                        <p>
                            Status: <?php if($entry['gq_online'] == true){echo "Online";}else{echo "Offline";} ?>
                        </p>
                        <p>
                            Online: <?php echo count($entry['players'])?> / <?php echo $entry['gq_maxplayers']?>
                        </p>
                        <p>
                            Map: <?php echo $entry['map']; ?>
                        </p>
                        <p>
                            Version: <?php echo $entry['version']; ?>
                        </p>
                        <p>
                            Server Adresse: <?php echo $entry['gq_address']; ?>
                        </p>
                    </div>
                    <div class="container-1 serverPlayers">
                        <table>
                            <tr>
                                <th>Name</th>
                            </tr>
                            <?php if(count($entry['players'])){?>
                                <?php $i=0;
                                foreach($entry['players'] as $player){
                                    ?>
                                    <tr class="
                                        <?php
                                        if($i % 2 == 0) echo "even";
                                        else
                                        {
                                            echo "odd";
                                        }
                                        ?>
                                    ">
                                        <td>
                                            <?php echo $player['gq_name']?>
                                        </td>
                                    </tr>
                                <?php $i++;} unset($i);?>
                            <?php }else{ ?>
                                <tr>
                                    <td colspan="3"><h2>Niemand online.</h2></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div style="clear: both"></div>
                </div>
            <?php }else{ ?>
                Es wurde noch kein Template für <?php echo $entry['gq_protocol']; ?> definiert.
            <?php } ?>
        </div>
    </div>
<?php } ?>

</div>
<script>
(function(){
    var allimgs = document.images;
    for(var i=0; i<allimgs.length; i++){
        allimgs[i].onerror = function () {
            this.style.visibility = "hidden"; // other elements not affected
        }
    }
})();
</script>
