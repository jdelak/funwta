<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournament", inversedBy="games")
     */
    private $tournament;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $round;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="playerone")
     * @ORM\JoinColumn(nullable=false)
     */
    private $playerOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="playertwo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $playerTwo;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerOneSetOne;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerOneSetTwo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $playerOneSetThree;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerTwoSetOne;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerTwoSetTwo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $playerTwoSetThree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="winner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $winner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }

    public function getRound(): ?string
    {
        return $this->round;
    }

    public function setRound(string $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getPlayerOne(): ?Player
    {
        return $this->playerOne;
    }

    public function setPlayerOne(?Player $playerOne): self
    {
        $this->playerOne = $playerOne;

        return $this;
    }

    public function getPlayerTwo(): ?Player
    {
        return $this->playerTwo;
    }

    public function setPlayerTwo(?Player $playerTwo): self
    {
        $this->playerTwo = $playerTwo;

        return $this;
    }

    public function getPlayerOneSetOne(): ?int
    {
        return $this->playerOneSetOne;
    }

    public function setPlayerOneSetOne(int $playerOneSetOne): self
    {
        $this->playerOneSetOne = $playerOneSetOne;

        return $this;
    }

    public function getPlayerOneSetTwo(): ?int
    {
        return $this->playerOneSetTwo;
    }

    public function setPlayerOneSetTwo(int $playerOneSetTwo): self
    {
        $this->playerOneSetTwo = $playerOneSetTwo;

        return $this;
    }

    public function getPlayerOneSetThree(): ?int
    {
        return $this->playerOneSetThree;
    }

    public function setPlayerOneSetThree(?int $playerOneSetThree): self
    {
        $this->playerOneSetThree = $playerOneSetThree;

        return $this;
    }

    public function getPlayerTwoSetOne(): ?int
    {
        return $this->playerTwoSetOne;
    }

    public function setPlayerTwoSetOne(int $playerTwoSetOne): self
    {
        $this->playerTwoSetOne = $playerTwoSetOne;

        return $this;
    }

    public function getPlayerTwoSetTwo(): ?int
    {
        return $this->playerTwoSetTwo;
    }

    public function setPlayerTwoSetTwo(int $playerTwoSetTwo): self
    {
        $this->playerTwoSetTwo = $playerTwoSetTwo;

        return $this;
    }

    public function getPlayerTwoSetThree(): ?int
    {
        return $this->playerTwoSetThree;
    }

    public function setPlayerTwoSetThree(?int $playerTwoSetThree): self
    {
        $this->playerTwoSetThree = $playerTwoSetThree;

        return $this;
    }

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
