<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TournamentRepository")
 */
class Tournament
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="tournaments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TournamentRanking", mappedBy="tournament")
     */
    private $tournamentRankings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="tournament")
     */
    private $games;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    

    public function __construct()
    {
        $this->tournamentRankings = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @return Collection|TournamentRanking[]
     */
    public function getTournamentRankings(): Collection
    {
        return $this->tournamentRankings;
    }

    public function addTournamentRanking(TournamentRanking $tournamentRanking): self
    {
        if (!$this->tournamentRankings->contains($tournamentRanking)) {
            $this->tournamentRankings[] = $tournamentRanking;
            $tournamentRanking->setTournament($this);
        }

        return $this;
    }

    public function removeTournamentRanking(TournamentRanking $tournamentRanking): self
    {
        if ($this->tournamentRankings->contains($tournamentRanking)) {
            $this->tournamentRankings->removeElement($tournamentRanking);
            // set the owning side to null (unless already changed)
            if ($tournamentRanking->getTournament() === $this) {
                $tournamentRanking->setTournament(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addMatch(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $match->setTournament($this);
        }

        return $this;
    }

    public function removeMatch(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getTournament() === $this) {
                $game->setTournament(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

   
}
