<?php
//
//namespace Project4\Repository;
//
//use Doctrine\ORM\EntityManager;
//use Doctrine\ORM\Exception\ORMException;
//use Doctrine\ORM\OptimisticLockException;
//use PDO;
//use Project4\Entity\TOBEDELETEDPostsCategories;
//use Ramsey\Uuid\Uuid;
//
//class TOBEDELETEDPostsCategoriesRepositoryFromDoctrine implements TOBEDELETEDPostsCategoriesRepository
//{
//    public function __construct(private EntityManager $entityManager)
//    {
//    }
//
//    /**
//     * @throws OptimisticLockException
//     * @throws ORMException
//     */
//    public function storePostsCategories(TOBEDELETEDPostsCategories $postsCategories): void
//        {
//            $this->entityManager->persist($postsCategories);
//            $this->entityManager->flush();
//        }
//
//        public function find($id): array
//        {
//            return $this
//                ->entityManager
//                ->getRepository(TOBEDELETEDPostsCategories::class)
//                ->find(['id' => $id]);
//        }
//}
