<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Despesas implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $descricao;
    /**
     * @ORM\Column(type="integer")
     */
    private $valor;
    /**
     * @ORM\Column(type="string")
     */
    private $data;
    /**
     * @ORM\Column(type="string")
     */
    private $categoria;

    /**
     * @ORM\Column(type="string")
     */
    private $mesano;
   



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescricao(): ?string
    {
        return $this->descricao;
    }


    public function setDescricao($descricao): self
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }


    public function setValor(int $valor): self
    {
        $this->valor = $valor;
        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }


    public function setCategoria(string $categoria): self
    {
        $this->categoria = $categoria;
        return $this;
    }


    public function getData()
    {
        return $this->data;
    }

    
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getMesano()
    {
        return $this->mesano;
    }

    
    public function setMesano($mesano): self
    {
        $this->mesano = $mesano;

        return $this;
    }
  

    //eu nao tinha colocado isso e o get nao tava funcionando... 
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'descricao' => $this->getDescricao(),
            'valor' => $this->getValor(),
            'categoria' => $this->getCategoria(),
            'data' => $this->getData(),
            'mesano' => $this->getMesano()
        ];

    }

    
}    