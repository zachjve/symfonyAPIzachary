<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Country;
use App\Repository\AnimalRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/animals", name="animals_")
 */
class AnimalsController extends AbstractController
{
    /**
     * @Route("/", name="app_animal_index", methods={"GET"})
     */
    public function index(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();

        return $this->json($animals);
    }

    /**
     * @Route("/{id}", name="app_animal_show", methods={"GET"})
     */
    public function show(Animal $animal): Response
    {
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], 404);
        }

        return $this->json($animal, 200);
    }

    /**
     * @Route("/country/{id}", name="app_animal_by_country", methods={"GET"})
     */
    public function getByCountry(Country $country, AnimalRepository $animalRepository): Response
    {
        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $animals = $animalRepository->findBy(['country' => $country]);

        if (!$animals) {
            return $this->json(['error' => 'Animals not found for this country'], 404);
        }

        return $this->json($animals, 200);
    }

    /**
     * @Route("/", name="app_animal_create", methods={"POST"})
     */
    public function create(Request $request, CountryRepository $countryRepository, AnimalRepository $animalRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $country = $countryRepository->find($data['country']['id']);
        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $animal = new Animal();
        $animal->setName($data['name']);
        $animal->setAverageSize($data['averageSize']);
        $animal->setCountry($country);
        $animal->setAverageLifeSpan($data['averageLifespan']);
        $animal->setMartialArt($data['martialArt']);
        $animal->setPhoneNumber($data['phoneNumber']);

        $em->persist($animal);
        $em->flush();

        return $this->json($animal, 201);
    }


    /**
     * @Route("/{id}", name="app_animal_update", methods={"PUT"})
     */
    public function update(Request $request, Animal $animal, CountryRepository $countryRepository, EntityManagerInterface $em): Response
    {
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $country = $countryRepository->find($data['country']['id']);
        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $animal->setName($data['name']);
        $animal->setAverageSize($data['averageSize']);
        $animal->setCountry($country);
        $animal->setAverageLifeSpan($data['averageLifespan']);
        $animal->setMartialArt($data['martialArt']);
        $animal->setPhoneNumber($data['phoneNumber']);

        $em->flush();

        return $this->json($animal, 200);
    }


    /**
     * @Route("/{id}/country", name="app_animal_update_country", methods={"PATCH"})
     */
    public function updateCountry(Request $request, Animal $animal, CountryRepository $countryRepository, EntityManagerInterface $em): Response
    {
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $country = $countryRepository->find($data['country']['id']);        
        if (!$country) {
            return $this->json(['error' => 'Country not found'], 404);
        }

        $animal->setCountry($country);

        $em->flush();

        return $this->json($animal, 200);
    }

    /**
     * @Route("/{id}", name="app_animal_delete", methods={"DELETE"})
     */
    public function delete(Animal $animal, EntityManagerInterface $em): Response
    {
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], 404);
        }

        $em->remove($animal);
        $em->flush();

        return $this->json(['message' => 'Animal deleted']);
    }
}