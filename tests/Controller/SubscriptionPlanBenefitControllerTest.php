<?php

namespace App\Test\Controller;

use App\Entity\SubscriptionPlanBenefit;
use App\Repository\SubscriptionPlanBenefitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubscriptionPlanBenefitControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SubscriptionPlanBenefitRepository $repository;
    private string $path = '/subscription/plan/benefit/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(SubscriptionPlanBenefit::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SubscriptionPlanBenefit index');

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
            'subscription_plan_benefit[name]' => 'Testing',
            'subscription_plan_benefit[subscriptionPlan]' => 'Testing',
        ]);

        self::assertResponseRedirects('/subscription/plan/benefit/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SubscriptionPlanBenefit();
        $fixture->setName('My Title');
        $fixture->setSubscriptionPlan('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SubscriptionPlanBenefit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SubscriptionPlanBenefit();
        $fixture->setName('My Title');
        $fixture->setSubscriptionPlan('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'subscription_plan_benefit[name]' => 'Something New',
            'subscription_plan_benefit[subscriptionPlan]' => 'Something New',
        ]);

        self::assertResponseRedirects('/subscription/plan/benefit/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSubscriptionPlan());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SubscriptionPlanBenefit();
        $fixture->setName('My Title');
        $fixture->setSubscriptionPlan('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/subscription/plan/benefit/');
    }
}
