<?php

namespace App\Tests\Controller;

use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class OffreControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $offreRepository;
    private string $path = '/offre/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->offreRepository = $this->manager->getRepository(Offre::class);

        foreach ($this->offreRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Offre index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'offre[titre]' => 'Testing',
            'offre[description]' => 'Testing',
            'offre[datePublication]' => 'Testing',
            'offre[dateFinPublication]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->offreRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offre();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDatePublication('My Title');
        $fixture->setDateFinPublication('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Offre');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offre();
        $fixture->setTitre('Value');
        $fixture->setDescription('Value');
        $fixture->setDatePublication('Value');
        $fixture->setDateFinPublication('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'offre[titre]' => 'Something New',
            'offre[description]' => 'Something New',
            'offre[datePublication]' => 'Something New',
            'offre[dateFinPublication]' => 'Something New',
        ]);

        self::assertResponseRedirects('/offre/');

        $fixture = $this->offreRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDatePublication());
        self::assertSame('Something New', $fixture[0]->getDateFinPublication());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offre();
        $fixture->setTitre('Value');
        $fixture->setDescription('Value');
        $fixture->setDatePublication('Value');
        $fixture->setDateFinPublication('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/offre/');
        self::assertSame(0, $this->offreRepository->count([]));
    }
}
