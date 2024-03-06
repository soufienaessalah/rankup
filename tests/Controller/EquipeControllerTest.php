<?php

namespace App\Test\Controller;

use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EquipeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EquipeRepository $repository;
    private string $path = '/equipe/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Equipe::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Equipe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'equipe[IdEquipe]' => 'Testing',
            'equipe[Nbmax]' => 'Testing',
            'equipe[NomEquipe]' => 'Testing',
        ]);

        self::assertResponseRedirects('/equipe/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Equipe();
        $fixture->setIdEquipe('My Title');
        $fixture->setNbmax('My Title');
        $fixture->setNomEquipe('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Equipe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Equipe();
        $fixture->setIdEquipe('My Title');
        $fixture->setNbmax('My Title');
        $fixture->setNomEquipe('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'equipe[IdEquipe]' => 'Something New',
            'equipe[Nbmax]' => 'Something New',
            'equipe[NomEquipe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/equipe/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdEquipe());
        self::assertSame('Something New', $fixture[0]->getNbmax());
        self::assertSame('Something New', $fixture[0]->getNomEquipe());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Equipe();
        $fixture->setIdEquipe('My Title');
        $fixture->setNbmax('My Title');
        $fixture->setNomEquipe('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/equipe/');
    }
}
