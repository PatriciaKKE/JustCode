use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[Vich\Uploadable]
class Application
{
    // ...

    #[Vich\UploadableField(mapping: 'application_cv', fileNameProperty: 'cvName')]
    private ?File $cvFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $cvName = null;

    // Fais de même pour la lettre de motivation
}
