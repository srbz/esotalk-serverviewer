<?php

if(!defined("IN_ESOTALK")) exit;
require_once "resources/GameQ-2/GameQ.php";
class ServerViewerController extends ETController
{
    public function action_index()
    {
        if(!$this->allowed()) return;
        $model = ETFactory::make("serverviewerModel");
        $res = $model->getServers();
        $gq = new GameQ();
        $gq->setFilter('normalise');
        foreach($res as $entry)
        {
            $gq->addServer(array(
                'id' => $entry['serverId'],
                'type' => $entry['type'],
                'host' => $entry['host']
            ));
        }
        $data = $gq->requestData();
        $data = array_filter($data, function($entry){
            return isset($entry['gq_hostname']) && $entry['gq_hostname'];
        });
        // var_dump($data);
        // echo "<br><br><br>";
                foreach($data as $serverType => $serverData){
            if($serverData['gq_protocol'] === 'quake3')
            {
                $data[$serverType]['sv_hostname'] = $this->parseQuake3ColorCodes($data[$serverType]['sv_hostname']);
                $data[$serverType]['gq_hostname'] = $this->parseQuake3ColorCodes($data[$serverType]['sv_hostname']);
                if(isset($data[$serverType]['players'])){
                    foreach($data[$serverType]['players'] as $k => $player){
                        $data[$serverType]['players'][$k]['name'] = $this->parseQuake3ColorCodes($player['name']);
                    }
                }
            }
            if($serverData['gq_protocol'] === 'teamspeak3')
            {
                if(isset($serverData['players']))
                {
                    usort($data[$serverType]['players'], function($a, $b){ return $a['cid'] < $b['cid']; });
                }
            }
        }
        $srvs = $data;
        $this->data("servers", $srvs);
        $this->render("ServerViewerIndexView");
    }
    /**
     * Parses and translates the Quake3 Color Codes into html
     *
     * @param string $name name with q3 color codes
     *
     * @return string String with span-html which contains the color
     */
    public function parseQuake3ColorCodes($name) {
        $colorMapping = array(
            '~' => '#00007F',
            '!' => '#FF9919',
            '@' => '#7F3F00',
            '#' => '#7F007F',
            '$' => '#007FFF',
            '%' => '#7F00FF',
            '&' => '#3399CC',
            '*' => '#CCC', //FFFFFF
            '(' => '#006633',
            ')' => '#FF0033',
            '_' => '#7F0000',
            '+' => '#993300',
            '|' => '#007F00',
            '`' => '#7F3F00',
            '1' => '#FF0000',
            '2' => '#00FF00',
            '3' => '#FFFF00',
            '4' => '#0000FF',
            '5' => '#00FFFF',
            '6' => '#FF00FF',
            '7' => '#CCC', //FFFFFF
            '8' => '#FF7F00',
            '9' => '#7F7F7F',
            '0' => '#000000',
            '-' => '#999933',
            '=' => '#7F7F00',
            '\\' => '#007F00',
            'Q' => '#FF0000',
            'W' => '#CCC', //FFFFFF
            'E' => '#7F00FF',
            'R' => '#00FF00',
            'T' => '#0000FF',
            'Y' => '#7F7F7F',
            'U' => '#00FFFF',
            'I' => '#FF0033',
            'O' => '#FFFF7F',
            'P' => '#000000',
            '[' => '#BFBFBF',
            ']' => '#7F7F00',
            '{' => '#BFBFBF',
            '}' => '#7F7F00',
            'A' => '#FF9919',
            'S' => '#FFFF00',
            'D' => '#007FFF',
            'F' => '#3399CC',
            'G' => '#CCFFCC',
            'H' => '#006633',
            'J' => '#B21919',
            'K' => '#993300',
            'L' => '#CC9933',
            ';' => '#BFBFBF',
            '\'' => '#CCFFCC',
            ':' => '#BFBFBF',
            'Z' => '#BFBFBF',
            'X' => '#FF7F00',
            'C' => '#7F007F',
            'V' => '#FF00FF',
            'B' => '#007F7F',
            'N' => '#FFFFBF',
            'M' => '#999933',
            ',' => '#CC9933',
            '.' => '#FFFFBF',
            '/' => '#FFFF7F',
            '<' => '#007F00',
            '>' => '#00007F',
            '?' => '#7F0000',
        );

        $color = '<span class="player"><span style="#ccc">';
        for($i = 0; $i < strlen($name); $i++)
        {
            if($name[$i] == '^')
            {
                $colorCode = isset($colorMapping[strtoupper($name[$i+1])]) ? $colorMapping[strtoupper($name[$i+1])] : '#ccc';
                $color    .= '</span><span style="color: '.$colorCode.'">';
                $i++; continue;
            }

            $color .= $name[$i];
        }

        $color .= '</span></span>';
        return $color;
    }
}
