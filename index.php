<!DOCTYPE html>
<html>
<head>
    <meta http-equip="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
</head>
    <body>
    <?php
        /* Sets the game board if unavailable */
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
    var $position; // an array that remembers the current game state of the board

    function __construct($squares)
    {
        $this->position = str_split($squares);
    }

    /* checks for the winner game state (whether it's horizontal, vertical or diagonal) */
    function winner($token)
    {
        $result = false;

        /* horizontal */
        for($row=0; $row<3; $row++)
        {
            $result = true;
            for ($col = 0; $col < 3; $col++)
                if ($this->position[3 * $row + $col] != $token)
                    $result = false;

            if($result) return true; // recognizes a whole row with the same token
        }

        /* vertical */
        for($col=0; $col<3; $col++)
        {
            $result = true;
            for ($row = 0; $row < 3; $row++)
                if ($this->position[3 * $row + $col] != $token)
                    $result = false;

            if($result) return true; // recognizes a column
        }

        /* diagonals */
        if(($this->position[0] == $token)&& ($this->position[4] == $token)&& ($this->position[8] == $token))
            $result = true;
        if(($this->position[2] == $token)&& ($this->position[4] == $token)&& ($this->position[6] == $token))
            $result = true;

        return $result;
    }

    /* a random move done by the cpu as an 'o' player */
    function pick_move()
    {
        $cpu = array(); // temporary array for '-' cells

        for ($i = 0; $i < 9; $i ++)
            if($this->position[$i] == '-')
                array_push($cpu, $i); // remembers all the available cells

        $this->position[$cpu[array_rand($cpu)]] = 'o'; // replaces a random available cell
    }

    /* displays the current board state */
    function display()
    {
        echo  '<table cols="3" border = "1" style= "font­size:large; font­weight:bold" width="400" height = "300" >';
        echo '<tr align = "center">';

        for($pos = 0; $pos < 9; $pos++)
        {
            echo $this->show_cell($pos);
            if($pos % 3 == 2) echo '</tr><tr align = "center">'; // makes a new row for every 3 cells made
        }

        echo '</tr>';
        echo '</table>';

    }

    /* shows the player's move in each cell */
    function show_cell($which)
    {
        $token = $this->position[$which];

        if($token <> '-')
            return '<td width="33.33%" height = "33.33%"> '.$token.'</td>';

        $this->newposition = $this->position;
        $this->newposition[$which] = 'x';
        $move = implode($this->newposition);
        $link = 'index.php?board='.$move;
        return '<td height = "33.33%" width="33.33%"><a href="'.$link .'" style="text-decoration: none" >-</a></td>';

    }
}
?>