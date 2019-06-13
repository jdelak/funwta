<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @Vich\Uploadable
 */
class Player
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
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="player_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $monteeFilet;

    /**
     * @ORM\Column(type="integer")
     */
    private $puissance;

    /**
     * @ORM\Column(type="integer")
     */
    private $reflexes;

    /**
     * @ORM\Column(type="integer")
     */
    private $vitesseService;

    /**
     * @ORM\Column(type="integer")
     */
    private $endurance;

    /**
     * @ORM\Column(type="integer")
     */
    private $vitesse;

    /**
     * @ORM\Column(type="integer")
     */
    private $servicePlat;

    /**
     * @ORM\Column(type="integer")
     */
    private $serviceLift;

    /**
     * @ORM\Column(type="integer")
     */
    private $serviceSlice;

    /**
     * @ORM\Column(type="integer")
     */
    private $droitPlat;

    /**
     * @ORM\Column(type="integer")
     */
    private $droitLift;

    /**
     * @ORM\Column(type="integer")
     */
    private $droitSlice;

    /**
     * @ORM\Column(type="integer")
     */
    private $reversPlat;

    /**
     * @ORM\Column(type="integer")
     */
    private $reversLift;

    /**
     * @ORM\Column(type="integer")
     */
    private $reversSlice;

    /**
     * @ORM\Column(type="integer")
     */
    private $volee;

    /**
     * @ORM\Column(type="integer")
     */
    private $voleeAmorti;

    /**
     * @ORM\Column(type="integer")
     */
    private $lob;

    /**
     * @ORM\Column(type="integer")
     */
    private $victory;

    /**
     * @ORM\Column(type="integer")
     */
    private $trophy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TournamentRanking", mappedBy="player")
     */
    private $tournamentRankings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Archive", mappedBy="player")
     */
    private $archives;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ranking", mappedBy="player")
     */
    private $rankings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="playerOne")
     */
    private $playerone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="playerTwo")
     */
    private $playertwo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="winner")
     */
    private $winner;
    
    private $note;
    

    public function __construct()
    {
        $this->tournamentRankings = new ArrayCollection();
        $this->archives = new ArrayCollection();
        $this->rankings = new ArrayCollection();
        $this->updatedAt= new \DateTime();
        $this->playerone = new ArrayCollection();
        $this->playertwo = new ArrayCollection();
        $this->winner = new ArrayCollection();
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

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

        public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }


    public function getMonteeFilet(): ?int
    {
        return $this->monteeFilet;
    }

    public function setMonteeFilet(int $monteeFilet): self
    {
        $this->monteeFilet = $monteeFilet;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getReflexes(): ?int
    {
        return $this->reflexes;
    }

    public function setReflexes(int $reflexes): self
    {
        $this->reflexes = $reflexes;

        return $this;
    }

    public function getVitesseService(): ?int
    {
        return $this->vitesseService;
    }

    public function setVitesseService(int $vitesseService): self
    {
        $this->vitesseService = $vitesseService;

        return $this;
    }

    public function getEndurance(): ?int
    {
        return $this->endurance;
    }

    public function setEndurance(int $endurance): self
    {
        $this->endurance = $endurance;

        return $this;
    }

    public function getVitesse(): ?int
    {
        return $this->vitesse;
    }

    public function setVitesse(int $vitesse): self
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getServicePlat(): ?int
    {
        return $this->servicePlat;
    }

    public function setServicePlat(int $servicePlat): self
    {
        $this->servicePlat = $servicePlat;

        return $this;
    }

    public function getServiceLift(): ?int
    {
        return $this->serviceLift;
    }

    public function setServiceLift(int $serviceLift): self
    {
        $this->serviceLift = $serviceLift;

        return $this;
    }

    public function getServiceSlice(): ?int
    {
        return $this->serviceSlice;
    }

    public function setServiceSlice(int $serviceSlice): self
    {
        $this->serviceSlice = $serviceSlice;

        return $this;
    }

    public function getDroitPlat(): ?int
    {
        return $this->droitPlat;
    }

    public function setDroitPlat(int $droitPlat): self
    {
        $this->droitPlat = $droitPlat;

        return $this;
    }

    public function getDroitLift(): ?int
    {
        return $this->droitLift;
    }

    public function setDroitLift(int $droitLift): self
    {
        $this->droitLift = $droitLift;

        return $this;
    }

    public function getDroitSlice(): ?int
    {
        return $this->droitSlice;
    }

    public function setDroitSlice(int $droitSlice): self
    {
        $this->droitSlice = $droitSlice;

        return $this;
    }

    public function getReversPlat(): ?int
    {
        return $this->reversPlat;
    }

    public function setReversPlat(int $reversPlat): self
    {
        $this->reversPlat = $reversPlat;

        return $this;
    }

    public function getReversLift(): ?int
    {
        return $this->reversLift;
    }

    public function setReversLift(int $reversLift): self
    {
        $this->reversLift = $reversLift;

        return $this;
    }

    public function getReversSlice(): ?int
    {
        return $this->reversSlice;
    }

    public function setReversSlice(int $reversSlice): self
    {
        $this->reversSlice = $reversSlice;

        return $this;
    }

    public function getVolee(): ?int
    {
        return $this->volee;
    }

    public function setVolee(int $volee): self
    {
        $this->volee = $volee;

        return $this;
    }

    public function getVoleeAmorti(): ?int
    {
        return $this->voleeAmorti;
    }

    public function setVoleeAmorti(int $voleeAmorti): self
    {
        $this->voleeAmorti = $voleeAmorti;

        return $this;
    }

    public function getLob(): ?int
    {
        return $this->lob;
    }

    public function setLob(int $lob): self
    {
        $this->lob = $lob;

        return $this;
    }

    public function getVictory(): ?int
    {
        return $this->victory;
    }

    public function setVictory(int $victory): self
    {
        $this->victory = $victory;

        return $this;
    }

    public function getTrophy(): ?int
    {
        return $this->trophy;
    }

    public function setTrophy(int $trophy): self
    {
        $this->trophy = $trophy;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNote(): ?int
    {
        $note = ($this->monteeFilet + $this->puissance + $this->reflexes + $this->vitesseService + $this->endurance
            + $this->vitesse + $this->servicePlat + $this->serviceLift + $this->serviceSlice + $this->droitPlat +
            $this->droitLift + $this->droitSlice + $this->reversPlat + $this->reversLift + $this->reversSlice
            + $this->volee + $this->voleeAmorti + $this->lob) / 18;
        
        return $note;
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
            $tournamentRanking->setPlayer($this);
        }

        return $this;
    }

    public function removeTournamentRanking(TournamentRanking $tournamentRanking): self
    {
        if ($this->tournamentRankings->contains($tournamentRanking)) {
            $this->tournamentRankings->removeElement($tournamentRanking);
            // set the owning side to null (unless already changed)
            if ($tournamentRanking->getPlayer() === $this) {
                $tournamentRanking->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Archive[]
     */
    public function getArchives(): Collection
    {
        return $this->archives;
    }

    public function addArchive(Archive $archive): self
    {
        if (!$this->archives->contains($archive)) {
            $this->archives[] = $archive;
            $archive->setPlayer($this);
        }

        return $this;
    }

    public function removeArchive(Archive $archive): self
    {
        if ($this->archives->contains($archive)) {
            $this->archives->removeElement($archive);
            // set the owning side to null (unless already changed)
            if ($archive->getPlayer() === $this) {
                $archive->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ranking[]
     */
    public function getRankings(): Collection
    {
        return $this->rankings;
    }

    public function addRanking(Ranking $ranking): self
    {
        if (!$this->rankings->contains($ranking)) {
            $this->rankings[] = $ranking;
            $ranking->setPlayer($this);
        }

        return $this;
    }

    public function removeRanking(Ranking $ranking): self
    {
        if ($this->rankings->contains($ranking)) {
            $this->rankings->removeElement($ranking);
            // set the owning side to null (unless already changed)
            if ($ranking->getPlayer() === $this) {
                $ranking->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getPlayerone(): Collection
    {
        return $this->playerone;
    }

    /**
     * @return Collection|Game[]
     */
        public function getPlayerTwo(): Collection
    {
        return $this->playertwo;
    }

    /**
     * @return Collection|Game[]
     */
        public function getWinner(): Collection
    {
        return $this->winner;
    }

    


}
