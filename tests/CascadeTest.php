<?php

namespace tests;

use PHPUnit\Framework\TestCase;

function cascade(string $s, int $gap): string {
    if (empty($s)) {
        return "";
    }

    $ls = [];
    foreach (preg_split('/\s+/', $s) as $w) {
        $ls[] = str_split($w);
    }

    // find the longest word
    $m = 0;
    foreach($ls as $l) {
        if (count($l) > $m) {
            $m = count($l);
        }
    }

    //echo "letters:\n";
    //echo json_encode($ls, JSON_PRETTY_PRINT) . PHP_EOL;
    // rotate array of letters
    // i.e.
    // AB           AX
    // XYZ    =>    BY
    //               Z
    $ls = rotate($ls, $gap);

    echo "rotated:\n";
    echo json_encode($ls, JSON_PRETTY_PRINT) . PHP_EOL;



    $r = [];
    foreach($ls as $w) {
        $r[] = implode($w);
    }

    $output = implode(str_repeat('_', $gap), $r);

    var_dump($output);
    var_dump($m);

    return implode(PHP_EOL, str_split($output, $split_length = $m));
}

function rotate($ws, $n) {
    $a = [];
    // find the longest word
    $m = 0;
    foreach($ws as $w) {
        if (count($w) > $m) {
            $m = count($w);
        }
    }

    // fill empty spaces
    foreach($ws as $i => $w) {
        //   for ($k = 0, $i=0; $k < $m; $k++, $i++) {
        //     if (!isset($ws[$k])) $w = str_repeat('_', $m);
        //    else $w = $ws[$k];
        for($j = 0; $j < $m; $j++) {
            if (!isset($w[$j])) {
                $a[$j][$i] = '_';
            }
            else {
                $a[$j][$i] = $w[$j];
            }
        }
    }

    return $a;
}

class CascadeTest extends TestCase
{
    public function test_empty_string_gap_2()
    {
        $this->assertSame("", cascade("", 2));
    }

    public function test_A_gap_2()
    {
        $this->assertSame("A", cascade("A", 2));
    }

    public function test_AB_gap_2()
    {
        $this->assertSame(
            trim(
                "
A_
_B
        "
            ),
            cascade("AB", 2)
        );
    }

    public function test_ABC_gap_2()
    {
        $this->assertSame(
            trim(
                "
A__
_B_
__C
        "
            ),
            cascade("ABC", 2)
        );
    }

    public function test_ABCD_gap_2()
    {
        $this->assertSame(
            trim(
                "
A___
_B__
__C_
___D
        "
            ),
            cascade("ABCD", 2)
        );
    }

    public function test_AB_XYZ_gap_2()
    {
        $this->assertSame(
            trim(
                "
A__X__
_B__Y_
_____Z
        "
            ),
            cascade("AB XYZ", 2)
        );
    }

    public function test_The_codings_bug_gap_2()
    {
        $this->assertSame(
            trim(
                "
T__c__b___
_h__o__u__
__e__d__g_
______i___
_______n__
________g_
_________s
        "
            ),
            cascade("The codings bug", 2)
        );
    }

    public function test_The_coding_bug_gap_2()
    {
        $this->assertSame(
            trim(
                "
T__c__b__
_h__o__u_
__e__d__g
______i__
_______n_
________g
        "
            ),
            cascade("The coding bug", 2)
        );
    }

    public function test_The_coding_bug_gap_3()
    {
        $this->assertSame(
            trim(
                "
T___c___b__
_h___o___u_
__e___d___g
_______i___
________n__
_________g_
        "
            ),
            cascade("The coding bug", 3)
        );
    }

    public function test_The_coding_bug_gap_4()
    {
        $this->assertSame(
            trim(
                "
T____c____b__
_h____o____u_
__e____d____g
________i____
_________n___
__________g__
        "
            ),
            cascade("The coding bug", 4)
        );
    }

    public function test_Gabriel_Garcia_Marquez_gap_3()
    {
        $this->assertSame(
            trim(
                "
G___G___M______
_a___a___a_____
__b___r___r____
___r___c___q___
____i___i___u__
_____e___a___e_
______l_______z
        "
            ),
            cascade("Gabriel Garcia Marquez", 3)
        );
    }

    public function test_Everywhere_in_one_gap_2()
    {
        $this->assertSame(
            trim(
                "
E__i__o___
_v__n__n__
__e_____e_
___r______
____y_____
_____w____
______h___
_______e__
________r_
_________e
        "
            ),
            cascade("Everywhere in one", 2)
        );
    }

    public function test_Everywhere_in_one_gap_1()
    {
        $this->assertSame(
            trim(
                "
E_i_o_____
_v_n_n____
__e___e___
___r______
____y_____
_____w____
______h___
_______e__
________r_
_________e
        "
            ),
            cascade("Everywhere in one", 1)
        );
    }

    public function test_Everywhere_in_one_gap_0()
    {
        $this->assertSame(
            trim(
                "
Eio_______
_vnn______
__e_e_____
___r______
____y_____
_____w____
______h___
_______e__
________r_
_________e
        "
            ),
            cascade("Everywhere in one", 0)
        );
    }
}
