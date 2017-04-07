<?php
require "predis/autoload.php";

Class Blindtest {
	private static $_instance;
    private $_redis;
	private $_nbteams;
    private $_prefixteam="team";

	public function __construct() {
		//$this->_nbjoueurs = $nbjoueurs;
		try {
    		$this->_redis = new Predis\Client();
    	    //echo "Successfully connected to Redis";
		}
		catch (Exception $e) {
		    echo "Couldn't connected to Redis";
		    echo $e->getMessage();
		}
        //$this->createTeams();
	}

	/**
     * Récupère l'instance de la classe
     *
     * @return PyWebAppClass
     */
    public static function getInstance()
    {
        if( true === is_null( self::$_instance ) )
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
 
    /**
    * Créé les Equipes
    */
    public function createTeams() {
        
        foreach (range(1, $this->_nbteams) as $i) {
            $this->_redis->hset($this->_prefixteam.$i, "nom", "TEAM ".$i);
            $this->_redis->hset($this->_prefixteam.$i, "time", -1);
            //$this->_redis->hset($this->_prefixteam.$i, "score", 0);
        }
    }

    /*
    * Effacer la base redis
    */
    public function flushall() {
        $this->_redis->flushall();
    }

    /**
    * Init Jeu
    */
    public function resetTimeAll() {
        $teams = $this->_redis->keys("team*");
        foreach ($teams as $team) {
            $this->_redis->hset($team, "time", -1);
        }
    }

    /**
    * get time for team $teamkey
    */
    public function getTime($teamkey) {
        $time = $this->_redis->hget($teamkey, "time");
        return $time;
    }

    /**
    * set time for team $teamkey
    */
    public function setTime($teamkey) {
        $this->_redis->hset($teamkey, "time", microtime(true));
    }

    /**
    * get score for team $teamkey
    */
    public function getScore($teamkey) {
        $score = $this->_redis->hget($teamkey, "score");
        return $score;
    }

    /**
    * increment score for team $teamkey
    */
    public function incrScore($teamkey) {
        $score = $this->getScore($teamkey);
        $newscore = intval($score)+1;
        $this->_redis->hset($teamkey, "score", $newscore);
    }

    /**
    * decrement score for team $teamkey
    */
    public function decrScore($teamkey) {
        $score = $this->getScore($teamkey);
        $newscore = intval($score)-1;
        $this->_redis->hset($teamkey, "score", $newscore);
    }

    /**
    * Set number of teams
    */
    public function setNbTeams($nb) {
        $this->_nbteams = $nb;
        $this->createTeams();
    }


    /**
    * Get Teams
    */
    public function getTeams() {
        $listTeams = array();
        $teams = $this->_redis->keys("team*");
        foreach ($teams as $team) {
            $listTeams[$team]["nom"] = $this->_redis->hget($team, "nom");
            $listTeams[$team]["score"] = $this->_redis->hget($team, "score");
            $time = $this->_redis->hget($team, "time");
            if ($time == "INF") {
                $listTeams[$team]["time"] = -1;
            } else {
                $listTeams[$team]["time"] = floatval($time);
            }
        }
        ksort($listTeams);
        return $listTeams;
    }

    /*
    * Get Positions
    */
    public function getPositions() {
        $times = array();
        $listTeams = $this->getTeams();
        foreach($listTeams as $team=>$infos) {
            $times[$team] = $infos["time"];
        }
        asort($times);
        $positions = array();
        $id = 1;
        foreach($times as $team=>$time) {
            if ($time != -1) {
                $positions[$team] = $id;
                $id++;
            }
        }
        return $positions;
    }
}
?>