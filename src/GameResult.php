<?php
namespace src;
/**
 * @Entity @Table(name="game_results")
 **/
class GameResult
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $date;


}