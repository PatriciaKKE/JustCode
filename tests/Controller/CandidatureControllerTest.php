<?php

namespace App\Tests\Controller;

use App\Entity\Candidature;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CandidatureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $candidatureRepository;
    private string $path = '/candidature/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->candidatureRepository = $this->manager->getRepository(Candidature::class);

        foreach ($this->candidatureRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Candidature index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'candidature[nom]' => 'Testing',
            'candidature[prenom]' => 'Testing',
            'candidature[email]' => 'Testing',
            'candidature[dateCandidature]' => 'Testing',
            'candidature[cv]' => 'Testing',
            'candidature[lettreMotivation]' => 'Testing',
            'candidature[status]' => 'Testing',
            'candidature[noteInterne]' => 'Testing',
            'candidature[offre]' => 'Testing',
            'candidature[user]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->candidatureRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Candidature();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEmail('My Title');
        $fixture->setDateCandidature('My Title');
        $fixture->setCv('My Title');
        $fixture->setLettreMotivation('My Title');
        $fixture->setStatus('My Title');
        $fixture->setNoteInterne('My Title');
        $fixture->setOffre('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Candidature');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Candidature();
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setEmail('Value');
        $fixture->setDateCandidature('Value');
        $fixture->setCv('Value');
        $fixture->setLettreMotivation('Value');
        $fixture->setStatus('Value');
        $fixture->setNoteInterne('Value');
        $fixture->setOffre('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'candidature[nom]' => 'Something New',
            'candidature[prenom]' => 'Something New',
            'candidature[email]' => 'Something New',
            'candidature[dateCandidature]' => 'Something New',
            'candidature[cv]' => 'Something New',
            'candidature[lettreMotivation]' => 'Something New',
            'candidature[status]' => 'Something New',
            'candidature[noteInterne]' => 'Something New',
            'candidature[offre]' => 'Something New',
            'candidature[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/candidature/');

        $fixture = $this->candidatureRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getDateCandidature());
        self::assertSame('Something New', $fixture[0]->getCv());
        self::assertSame('Something New', $fixture[0]->getLettreMotivation());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getNoteInterne());
        self::assertSame('Something New', $fixture[0]->getOffre());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Candidature();
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setEmail('Value');
        $fixture->setDateCandidature('Value');
        $fixture->setCv('Value');
        $fixture->setLettreMotivation('Value');
        $fixture->setStatus('Value');
        $fixture->setNoteInterne('Value');
        $fixture->setOffre('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/candidature/');
        self::assertSame(0, $this->candidatureRepository->count([]));
    }
}
