# unique-in-collection-validator

This symfony validator validates a form collection using the "All" assertion, and takes an optional parameters :
1) array of fields which together should be unique;
2) error message;
2) error path - field for error message.

# Usage

    /**
     * @var Collection
     *
     * @Assert\All(constraints={
     *      @UniqueInCollection(
     *          fields={"name", "surname"},
     *          errorPath="name",
     *          message="This name with this surname is already use."
     *      )
     * })
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SomeEntity")
     */
    private $object;