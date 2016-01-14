<!DOCTYPE html>
<html>
<head>
    <meta http-equip="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
    <body>
    <?php

        $game = new Game(!isset($_GET['board']) ? '---------' : $_GET['board']);

        if($game->winner('x'))
            echo 'x wins';
        else if ($game->winner('o'))
            echo 'o wins';
        else
        {
            $game->pick_move();
            echo $game->winner('o') ? 'o wins' : 'no winner';
        }

        $game->display();

        echo '<a href="index.php">play again</a>';

    ?>
    </body>
</html>

<?php
class Game
{
    var $position;

    function __construct($squares)
    {
        $this->position = str_split($squares);
    }


    function winner($token)
    {
        // horizontal
        if(($this->position[0] == $token)&& ($this->position[1] == $token)&& ($this->position[2] == $token))
            return true;
        if(($this->position[3] == $token)&& ($this->position[4] == $token)&& ($this->position[5] == $token))
            return true;
        if(($this->position[6] == $token)&& ($this->position[7] == $token)&& ($this->position[8] == $token))
            return true;

        // vertical
        if(($this->position[0] == $token)&& ($this->position[3] == $token)&& ($this->position[6] == $token))
            return true;
        if(($this->position[1] == $token)&& ($this->position[4] == $token)&& ($this->position[7] == $token))
            return true;
        if(($this->position[2] == $token)&& ($this->position[5] == $token)&& ($this->position[8] == $token))
            return true;

        // diagonal
        if(($this->position[0] == $token)&& ($this->position[4] == $token)&& ($this->position[8] == $token))
            return true;
        if(($this->position[2] == $token)&& ($this->position[4] == $token)&& ($this->position[6] == $token))
            return true;
        return false;
    }


    /*
    function winner($token)
    {
        $result = false;

        for($row=0; $row<3; $row++)
            for ($col = 0; $col < 3; $col++)
                if ($this->position[3 * $row + $col] != $token)
                    $result = false;

        for($row=0; $row<3; $row++)
            for ($col = 0; $col < 3; $col++)
                if ($this->position[3 * $row + $col] != $token)
                    $result = false;

        if(($this->position[0] == $token)&& ($this->position[4] == $token)&& ($this->position[8] == $token))
            $result = true;
        if(($this->position[2] == $token)&& ($this->position[4] == $token)&& ($this->position[6] == $token))
            $result = true;

        return $result;
    }
    */



    function pick_move()
    {
        $cpu = array();
        for ($i = 0; $i < 9; $i ++)
            if($this->position[$i] == '-')
                array_push($cpu, $i);
        $this->position[$cpu[array_rand($cpu)]] = 'o';
    }


    function display()
    {
        echo  '<table cols="3" style= "font­size:large; font­weight:bold">';
        echo '<tr>';

        for($pos = 0; $pos < 9; $pos++)
        {
            echo $this->show_cell($pos);
            if($pos % 3 == 2) echo '</tr><tr>';
        }

        echo '</tr>';
        echo '</table>';
    }

    function show_cell($which)
    {

        $token = $this->position[$which];

        if($token <> '-')
            return '<td>'.$token.'</td>';

        $this->newposition = $this->position;
        $this->newposition[$which] = 'x';
        $move = implode($this->newposition);
        $link = 'index.php?board='.$move;
        return '<td><a href="'.$link .'" style="text-decoration: none" >-</a></td>';

    }
}
?>