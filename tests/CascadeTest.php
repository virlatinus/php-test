<?php

namespace tests;

use JsonException;
use PHPUnit\Framework\TestCase;

function get_maxlen($words) {
    return array_reduce($words, static function ($max, $word) {
        return (strlen($word) > $max) ? strlen($word) : $max;
    }, 0);
}

/**
 * @throws JsonException
 */
function cascade(string $s, int $gap): string {
    if (empty($s)) {
        return '';
    }

/*
T__c__b___
_h__o__u__
__e__d__g_
______i___
_______n__
________g_
_________s
*/
    $words = preg_split('/\s+/u', $s);
    $maxlen = get_maxlen($words);

    // Create an array of length maxlen and push letters of each word
    // followed by the gap. Fill empty letters with underscores

    $lines = [];
    for($i = 0; $i < $maxlen; $i++) {
        // add initial underscores
        $lines[$i] = str_repeat('_', $i);
        $line = '';
        foreach ($words as $word) {
            $line .= $word[$i] ?? '_';
        }
        $line = rtrim($line, '_');
        $lines[$i] .= implode(str_repeat('_', $gap), str_split($line));
    }

    // find the longest line and add underscores to the end of the rest
    $maxlen = get_maxlen($lines);
    foreach ($lines as &$line) {
        $line .= str_repeat('_', $maxlen - strlen($line));
    }

    return implode(PHP_EOL, $lines);
}

class CascadeTest extends TestCase
{

    public function test_empty_string_gap_2(): void
    {
        self::assertSame("", cascade("", 2));
    }

    public function test_A_gap_2(): void
    {
        self::assertSame("A", cascade("A", 2));
    }

    public function test_AB_gap_2(): void
    {
        self::assertSame(
            trim(
                "
A_
_B
        "
            ),
            cascade("AB", 2)
        );
    }

    public function test_ABC_gap_2(): void
    {
        self::assertSame(
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

    public function test_ABCD_gap_2(): void
    {
        self::assertSame(
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

    public function test_AB_XYZ_gap_2(): void
    {
        self::assertSame(
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

    public function test_The_codings_bug_gap_2(): void
    {
        self::assertSame(
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

    public function test_The_coding_bug_gap_2(): void
    {
        self::assertSame(
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

    public function test_The_coding_bug_gap_3(): void
    {
        self::assertSame(
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

    public function test_The_coding_bug_gap_4(): void
    {
        self::assertSame(
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

    public function test_Gabriel_Garcia_Marquez_gap_3(): void
    {
        self::assertSame(
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

    public function test_Everywhere_in_one_gap_2(): void
    {
        self::assertSame(
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

    public function test_Everywhere_in_one_gap_1(): void
    {
        self::assertSame(
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

    public function test_Everywhere_in_one_gap_0(): void
    {
        self::assertSame(
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
